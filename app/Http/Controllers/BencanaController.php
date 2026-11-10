<?php

namespace App\Http\Controllers;

use App\Models\Bencana;
use Illuminate\Http\Request;

class BencanaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Bencana::orderBy('created_at', 'desc')->get();
        return view('dashboard.databencana', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi data
            $validated = $request->validate([
                'kecamatan' => 'required|string|max:255',
                'kelurahan' => 'required|string|max:255',
                'jenis_bencana' => 'required|string|max:255',
                'lat' => 'required|numeric|between:-90,90',
                'lng' => 'required|numeric|between:-180,180',
                'curah_hujan' => 'required|numeric|between:0,1',
                'kemiringan_lereng' => 'required|numeric|between:0,1',
                'vegetasi' => 'required|numeric|between:0,1',
                'riwayat_bencana' => 'required|numeric|between:0,1',
                'jarak_sumber_bahaya' => 'nullable|numeric|between:0,1',
            ]);

            // Simulasikan proses analisis fuzzy logic
            //sleep(2);

            // Hitung tingkat kerentanan menggunakan fuzzy logic 51 rules
            $tingkat_kerentanan = $this->hitungTingkatKerentananFuzzy(
                $validated['jenis_bencana'],
                $validated['curah_hujan'],
                $validated['kemiringan_lereng'],
                $validated['vegetasi'],
                $validated['riwayat_bencana'],
                $validated['jarak_sumber_bahaya'] ?? null
            );

            // Tambahkan tingkat kerentanan ke data
            $validated['tingkat_kerentanan'] = $tingkat_kerentanan;

            // Simpan data ke database
            Bencana::create($validated);

            return redirect()->route('bencana.index')
                ->with('success', 'Data bencana berhasil ditambahkan! Tingkat kerentanan: ' . $tingkat_kerentanan)
                ->with('analyzing', true);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Fuzzy Logic System dengan 51 Rules
     */
    private function hitungTingkatKerentananFuzzy($jenisBencana, $curahHujan, $kemiringanLereng, $vegetasi, $riwayatBencana, $jarakSumberBahaya = null)
    {
        // Konversi nilai numerik ke fuzzy sets
        $curahHujanFuzzy = $this->fuzzifyCurahHujan($curahHujan);
        $kemiringanFuzzy = $this->fuzzifyKemiringan($kemiringanLereng);
        $vegetasiFuzzy = $this->fuzzifyVegetasi($vegetasi);
        $riwayatFuzzy = $this->fuzzifyRiwayat($riwayatBencana);
        $jarakFuzzy = $jarakSumberBahaya ? $this->fuzzifyJarak($jarakSumberBahaya) : null;

        // Terapkan rules berdasarkan jenis bencana
        return $this->applyFuzzyRules($jenisBencana, $curahHujanFuzzy, $kemiringanFuzzy, $vegetasiFuzzy, $riwayatFuzzy, $jarakFuzzy);
    }

    /**
     * Fuzzification untuk curah hujan
     */
    private function fuzzifyCurahHujan($value)
    {
        if ($value <= 0.3) return 'Low';
        if ($value <= 0.6) return 'Medium';
        return 'High';
    }

    /**
     * Fuzzification untuk kemiringan lereng
     */
    private function fuzzifyKemiringan($value)
    {
        if ($value <= 0.3) return 'Flat';
        if ($value <= 0.6) return 'Moderate';
        return 'Steep';
    }

    /**
     * Fuzzification untuk vegetasi
     */
    private function fuzzifyVegetasi($value)
    {
        if ($value <= 0.3) return 'Low';      // Sedikit vegetasi
        if ($value <= 0.6) return 'Medium';   // Vegetasi sedang
        return 'High';                        // Banyak vegetasi
    }

    /**
     * Fuzzification untuk riwayat bencana
     */
    private function fuzzifyRiwayat($value)
    {
        if ($value <= 0.3) return 'None';
        if ($value <= 0.6) return 'Some';
        return 'Frequent';
    }

    /**
     * Fuzzification untuk jarak sumber bahaya
     */
    private function fuzzifyJarak($value)
    {
        if ($value <= 0.3) return 'Far';
        if ($value <= 0.6) return 'Moderate';
        return 'Close';
    }

    /**
     * Apply Fuzzy Rules berdasarkan 51 rules
     */
    private function applyFuzzyRules($jenisBencana, $curahHujan, $kemiringan, $vegetasi, $riwayat, $jarak)
    {
        $rules = [];

        // === RULES BERDASARKAN JENIS BENCANA ===

        if ($jenisBencana === 'Longsor') {
            // LONGSON - 12 Rules
            $rules = [
                // HIGH (4 rules)
                ($riwayat === 'Frequent' && $kemiringan === 'Steep') ? 'Tinggi' : null,
                ($riwayat === 'Some' && $kemiringan !== 'Flat') ? 'Tinggi' : null,
                ($curahHujan === 'High' && $kemiringan === 'Steep') ? 'Tinggi' : null,
                ($curahHujan === 'High' && $riwayat === 'Frequent') ? 'Tinggi' : null,

                // MENENGAH (4 rules)
                ($curahHujan === 'High' && $vegetasi === 'Low') ? 'Menengah' : null,
                ($curahHujan === 'Medium' && $riwayat === 'Some') ? 'Menengah' : null,
                ($curahHujan === 'Medium' && $kemiringan === 'Steep') ? 'Menengah' : null,
                ($vegetasi === 'Low' && $riwayat === 'Some') ? 'Menengah' : null,

                // RENDAH (4 rules)
                ($curahHujan === 'Low' && $vegetasi === 'High') ? 'Rendah' : null,
                ($kemiringan === 'Flat' && $riwayat === 'None') ? 'Rendah' : null,
                ($curahHujan === 'Low' && $kemiringan === 'Moderate' && $vegetasi === 'High') ? 'Rendah' : null,
                ($vegetasi === 'High' && $riwayat === 'None') ? 'Rendah' : null,
            ];
        } elseif ($jenisBencana === 'Banjir') {
            // BANJIR - 12 Rules
            $rules = [
                // HIGH (4 rules)
                ($curahHujan === 'High' && $jarak === 'Close') ? 'Tinggi' : null,
                ($curahHujan === 'High' && $riwayat === 'Frequent') ? 'Tinggi' : null,
                ($curahHujan === 'High' && $vegetasi === 'Low') ? 'Tinggi' : null,
                ($jarak === 'Close' && $riwayat === 'Frequent') ? 'Tinggi' : null,

                // MENENGAH (4 rules)
                ($curahHujan === 'Medium' && $jarak === 'Moderate') ? 'Menengah' : null,
                ($jarak === 'Close' && $vegetasi === 'Low') ? 'Menengah' : null,
                ($curahHujan === 'Medium' && $jarak === 'Close') ? 'Menengah' : null,
                ($vegetasi === 'Low' && $riwayat === 'Some') ? 'Menengah' : null,

                // RENDAH (4 rules)
                ($curahHujan === 'Low' && $jarak === 'Far') ? 'Rendah' : null,
                ($vegetasi === 'High' && $riwayat === 'None') ? 'Rendah' : null,
                ($curahHujan === 'Low' && $vegetasi === 'High') ? 'Rendah' : null,
                ($jarak === 'Far' && $riwayat === 'None') ? 'Rendah' : null,
            ];
        } elseif ($jenisBencana === 'Kebakaran Hutan') {
            // KEBAKARAN HUTAN - 12 Rules
            $rules = [
                // HIGH (4 rules)
                ($vegetasi === 'Low' && $curahHujan === 'Low') ? 'Tinggi' : null,
                ($riwayat === 'Frequent' && $curahHujan === 'Low') ? 'Tinggi' : null,
                ($vegetasi === 'Low' && $kemiringan === 'Steep') ? 'Tinggi' : null,
                ($curahHujan === 'Low' && $kemiringan === 'Steep') ? 'Tinggi' : null,

                // MENENGAH (4 rules)
                ($vegetasi === 'Medium' && $curahHujan === 'Low') ? 'Menengah' : null,
                ($curahHujan === 'Medium' && $riwayat === 'Some') ? 'Menengah' : null,
                ($vegetasi === 'Low' && $riwayat === 'Some') ? 'Menengah' : null,
                ($curahHujan === 'Low' && $vegetasi === 'Medium' && $kemiringan === 'Flat') ? 'Menengah' : null,

                // RENDAH (4 rules)
                ($vegetasi === 'High' && $curahHujan === 'High') ? 'Rendah' : null,
                ($riwayat === 'None') ? 'Rendah' : null,
                ($curahHujan === 'High' && $vegetasi === 'High' && $riwayat === 'None') ? 'Rendah' : null,
                ($curahHujan === 'Medium' && $vegetasi === 'High') ? 'Rendah' : null,
            ];
        } elseif ($jenisBencana === 'Gunung berapi') {
            // GUNUNG BERAPI - 9 Rules
            $rules = [
                // HIGH (3 rules)
                ($jarak === 'Close') ? 'Tinggi' : null,
                ($jarak === 'Close' && $riwayat === 'Frequent') ? 'Tinggi' : null,
                ($jarak === 'Close' && $curahHujan === 'High') ? 'Tinggi' : null,

                // MENENGAH (3 rules)
                ($jarak === 'Moderate') ? 'Menengah' : null,
                ($jarak === 'Moderate' && $riwayat === 'Frequent') ? 'Menengah' : null,
                ($jarak === 'Moderate' && $vegetasi === 'Low') ? 'Menengah' : null,

                // RENDAH (3 rules)
                ($jarak === 'Far') ? 'Rendah' : null,
                ($jarak === 'Far' && $vegetasi === 'High') ? 'Rendah' : null,
                ($jarak === 'Far' && $riwayat === 'None') ? 'Rendah' : null,
            ];
        }

        // === EMERGENCY RULES (6 Rules - Untuk semua jenis bencana) ===
        $emergencyRules = [
            // Emergency High Rules
            ($curahHujan === 'High' && $kemiringan === 'Steep' && $vegetasi === 'Low') ? 'Tinggi' : null,
            ($curahHujan === 'High' && $riwayat === 'Frequent' && $jarak === 'Close') ? 'Tinggi' : null,

            // Emergency Low Rules
            ($curahHujan === 'Low' && $vegetasi === 'High' && $riwayat === 'None') ? 'Rendah' : null,
            ($kemiringan === 'Flat' && $jarak === 'Far' && $riwayat === 'None') ? 'Rendah' : null,
        ];

        // Gabungkan semua rules
        $allRules = array_merge($rules, $emergencyRules);
        $results = array_filter($allRules);

        // Jika ada rules yang match, ambil yang paling tinggi
        if (!empty($results)) {
            if (in_array('Tinggi', $results)) return 'Tinggi';
            if (in_array('Menengah', $results)) return 'Menengah';
            return 'Rendah';
        }

        // === FALLBACK RULES (jika tidak ada rules yang match) ===
        $highCount = 0;
        if ($curahHujan === 'High') $highCount++;
        if ($kemiringan === 'Steep') $highCount++;
        if ($vegetasi === 'Low') $highCount++; // Vegetasi sedikit = risiko tinggi
        if ($riwayat === 'Frequent') $highCount++;
        if ($jarak === 'Close') $highCount++;

        // Fallback decision
        if ($highCount >= 3) return 'Tinggi';
        if ($highCount == 2) return 'Menengah';
        return 'Rendah';
    }

    /**
     * Display the specified resource.
     */
    public function show(Bencana $bencana)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bencana $bencana)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bencana $bencana)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bencana $bencana)
    {
        //
    }
}
