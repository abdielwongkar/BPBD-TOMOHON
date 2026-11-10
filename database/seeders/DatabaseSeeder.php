<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'nama' => 'Pedro V Rapar',
            'username' => 'edoedo',
            'password' => bcrypt('edoedo'),
            'role' => 'superadmin',
        ]);

        User::create([
            'nama' => 'Admin1',
            'username' => 'admin1',
            'password' => bcrypt('admin1'),
            'role' => 'admin',
        ]);


        $data = [
            ['kecamatan' => 'Tomohon Barat', 'kelurahan' => 'Woloan Satu', 'lat' => 1.325630, 'lng' => 124.818924, 'jenis_bencana' => 'Longsor', 'tingkat_kerentanan' => 'Menengah', 'curah_hujan' => 0.6, 'kemiringan_lereng' => 0.7, 'vegetasi' => 0.4, 'jarak_sumber_bahaya' => 0.6, 'riwayat_bencana' => 0.5, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Utara', 'kelurahan' => 'Kakaskasen Dua', 'lat' => 1.354981, 'lng' => 124.807786, 'jenis_bencana' => 'Gunung berapi', 'tingkat_kerentanan' => 'Menengah', 'curah_hujan' => 0.6, 'kemiringan_lereng' => 0.6, 'vegetasi' => 0.5, 'jarak_sumber_bahaya' => 0.7, 'riwayat_bencana' => 0.5, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Utara', 'kelurahan' => 'Kakaskasen Satu', 'lat' => 1.357536, 'lng' => 124.816270, 'jenis_bencana' => 'Gunung berapi', 'tingkat_kerentanan' => 'Menengah', 'curah_hujan' => 0.6, 'kemiringan_lereng' => 0.6, 'vegetasi' => 0.5, 'jarak_sumber_bahaya' => 0.7, 'riwayat_bencana' => 0.5, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Utara', 'kelurahan' => 'Tinoor Satu', 'lat' => 1.370280, 'lng' => 124.812264, 'jenis_bencana' => 'Gunung berapi', 'tingkat_kerentanan' => 'Menengah', 'curah_hujan' => 0.5, 'kemiringan_lereng' => 0.7, 'vegetasi' => 0.6, 'jarak_sumber_bahaya' => 0.7, 'riwayat_bencana' => 0.5, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Tengah', 'kelurahan' => 'Talete Dua', 'lat' => 1.330681, 'lng' => 124.838523, 'jenis_bencana' => 'Banjir', 'tingkat_kerentanan' => 'Rendah', 'curah_hujan' => 0.4, 'kemiringan_lereng' => 0.2, 'vegetasi' => 0.7, 'jarak_sumber_bahaya' => 0.3, 'riwayat_bencana' => 0.2, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Utara', 'kelurahan' => 'Wailan', 'lat' => 1.331434, 'lng' => 124.817616, 'jenis_bencana' => 'Longsor', 'tingkat_kerentanan' => 'Rendah', 'curah_hujan' => 0.3, 'kemiringan_lereng' => 0.3, 'vegetasi' => 0.8, 'jarak_sumber_bahaya' => 0.2, 'riwayat_bencana' => 0.2, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Utara', 'kelurahan' => 'Wailan', 'lat' => 1.338038, 'lng' => 124.818811, 'jenis_bencana' => 'Banjir', 'tingkat_kerentanan' => 'Rendah', 'curah_hujan' => 0.4, 'kemiringan_lereng' => 0.2, 'vegetasi' => 0.8, 'jarak_sumber_bahaya' => 0.3, 'riwayat_bencana' => 0.2, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Utara', 'kelurahan' => 'Kayawu', 'lat' => 1.330797, 'lng' => 124.808186, 'jenis_bencana' => 'Longsor', 'tingkat_kerentanan' => 'Rendah', 'curah_hujan' => 0.3, 'kemiringan_lereng' => 0.3, 'vegetasi' => 0.8, 'jarak_sumber_bahaya' => 0.2, 'riwayat_bencana' => 0.3, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Utara', 'kelurahan' => 'Kayawu', 'lat' => 1.332920, 'lng' => 124.804932, 'jenis_bencana' => 'Longsor', 'tingkat_kerentanan' => 'Menengah', 'curah_hujan' => 0.5, 'kemiringan_lereng' => 0.5, 'vegetasi' => 0.5, 'jarak_sumber_bahaya' => 0.5, 'riwayat_bencana' => 0.5, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Barat', 'kelurahan' => 'Woloan Dua', 'lat' => 1.322661, 'lng' => 124.806492, 'jenis_bencana' => 'Longsor', 'tingkat_kerentanan' => 'Menengah', 'curah_hujan' => 0.6, 'kemiringan_lereng' => 0.6, 'vegetasi' => 0.5, 'jarak_sumber_bahaya' => 0.6, 'riwayat_bencana' => 0.5, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Utara', 'kelurahan' => 'Kayawu', 'lat' => 1.329062, 'lng' => 124.807800, 'jenis_bencana' => 'Longsor', 'tingkat_kerentanan' => 'Menengah', 'curah_hujan' => 0.5, 'kemiringan_lereng' => 0.5, 'vegetasi' => 0.5, 'jarak_sumber_bahaya' => 0.5, 'riwayat_bencana' => 0.5, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Utara', 'kelurahan' => 'Kayawu', 'lat' => 1.331666, 'lng' => 124.806487, 'jenis_bencana' => 'Banjir', 'tingkat_kerentanan' => 'Rendah', 'curah_hujan' => 0.4, 'kemiringan_lereng' => 0.2, 'vegetasi' => 0.7, 'jarak_sumber_bahaya' => 0.3, 'riwayat_bencana' => 0.3, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Utara', 'kelurahan' => 'Kayawu', 'lat' => 1.324251, 'lng' => 124.793605, 'jenis_bencana' => 'Kebakaran Hutan', 'tingkat_kerentanan' => 'Rendah', 'curah_hujan' => 0.2, 'kemiringan_lereng' => 0.3, 'vegetasi' => 0.6, 'jarak_sumber_bahaya' => 0.4, 'riwayat_bencana' => 0.3, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Utara', 'kelurahan' => 'Kayawu', 'lat' => 1.323734, 'lng' => 124.792308, 'jenis_bencana' => 'Banjir', 'tingkat_kerentanan' => 'Rendah', 'curah_hujan' => 0.3, 'kemiringan_lereng' => 0.2, 'vegetasi' => 0.7, 'jarak_sumber_bahaya' => 0.3, 'riwayat_bencana' => 0.2, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Utara', 'kelurahan' => 'Kinilow', 'lat' => 1.370962, 'lng' => 124.835601, 'jenis_bencana' => 'Longsor', 'tingkat_kerentanan' => 'Menengah', 'curah_hujan' => 0.6, 'kemiringan_lereng' => 0.6, 'vegetasi' => 0.5, 'jarak_sumber_bahaya' => 0.6, 'riwayat_bencana' => 0.5, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Utara', 'kelurahan' => 'Kakaskasen Satu', 'lat' => 1.352747, 'lng' => 124.844201, 'jenis_bencana' => 'Longsor', 'tingkat_kerentanan' => 'Tinggi', 'curah_hujan' => 0.9, 'kemiringan_lereng' => 0.9, 'vegetasi' => 0.3, 'jarak_sumber_bahaya' => 0.9, 'riwayat_bencana' => 0.8, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Tengah', 'kelurahan' => 'Talete Dua', 'lat' => 1.337795, 'lng' => 124.842703, 'jenis_bencana' => 'Longsor', 'tingkat_kerentanan' => 'Menengah', 'curah_hujan' => 0.5, 'kemiringan_lereng' => 0.5, 'vegetasi' => 0.5, 'jarak_sumber_bahaya' => 0.5, 'riwayat_bencana' => 0.5, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Tengah', 'kelurahan' => 'Talete Dua', 'lat' => 1.334919, 'lng' => 124.843610, 'jenis_bencana' => 'Longsor', 'tingkat_kerentanan' => 'Menengah', 'curah_hujan' => 0.6, 'kemiringan_lereng' => 0.6, 'vegetasi' => 0.4, 'jarak_sumber_bahaya' => 0.6, 'riwayat_bencana' => 0.5, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Tengah', 'kelurahan' => 'Talete Satu', 'lat' => 1.333253, 'lng' => 124.843584, 'jenis_bencana' => 'Banjir', 'tingkat_kerentanan' => 'Rendah', 'curah_hujan' => 0.4, 'kemiringan_lereng' => 0.2, 'vegetasi' => 0.7, 'jarak_sumber_bahaya' => 0.3, 'riwayat_bencana' => 0.3, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Tengah', 'kelurahan' => 'Talete Satu', 'lat' => 1.330843, 'lng' => 124.842619, 'jenis_bencana' => 'Longsor', 'tingkat_kerentanan' => 'Rendah', 'curah_hujan' => 0.3, 'kemiringan_lereng' => 0.3, 'vegetasi' => 0.8, 'jarak_sumber_bahaya' => 0.2, 'riwayat_bencana' => 0.2, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Tengah', 'kelurahan' => 'Talete Satu', 'lat' => 1.328974, 'lng' => 124.842982, 'jenis_bencana' => 'Banjir', 'tingkat_kerentanan' => 'Rendah', 'curah_hujan' => 0.4, 'kemiringan_lereng' => 0.2, 'vegetasi' => 0.7, 'jarak_sumber_bahaya' => 0.3, 'riwayat_bencana' => 0.2, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Tengah', 'kelurahan' => 'Talete Satu', 'lat' => 1.329058, 'lng' => 124.841253, 'jenis_bencana' => 'Banjir', 'tingkat_kerentanan' => 'Rendah', 'curah_hujan' => 0.3, 'kemiringan_lereng' => 0.2, 'vegetasi' => 0.8, 'jarak_sumber_bahaya' => 0.3, 'riwayat_bencana' => 0.2, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Timur', 'kelurahan' => 'Paslaten Satu', 'lat' => 1.326249, 'lng' => 124.849245, 'jenis_bencana' => 'Longsor', 'tingkat_kerentanan' => 'Menengah', 'curah_hujan' => 0.6, 'kemiringan_lereng' => 0.6, 'vegetasi' => 0.5, 'jarak_sumber_bahaya' => 0.6, 'riwayat_bencana' => 0.5, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Utara', 'kelurahan' => 'Wailan', 'lat' => 1.343990, 'lng' => 124.808358, 'jenis_bencana' => 'Gunung berapi', 'tingkat_kerentanan' => 'Menengah', 'curah_hujan' => 0.5, 'kemiringan_lereng' => 0.6, 'vegetasi' => 0.6, 'jarak_sumber_bahaya' => 0.7, 'riwayat_bencana' => 0.5, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Timur', 'kelurahan' => 'Paslaten Dua', 'lat' => 1.324864, 'lng' => 124.848692, 'jenis_bencana' => 'Banjir', 'tingkat_kerentanan' => 'Menengah', 'curah_hujan' => 0.6, 'kemiringan_lereng' => 0.4, 'vegetasi' => 0.5, 'jarak_sumber_bahaya' => 0.5, 'riwayat_bencana' => 0.6, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Timur', 'kelurahan' => 'Paslaten Dua', 'lat' => 1.325065, 'lng' => 124.848970, 'jenis_bencana' => 'Longsor', 'tingkat_kerentanan' => 'Menengah', 'curah_hujan' => 0.6, 'kemiringan_lereng' => 0.6, 'vegetasi' => 0.5, 'jarak_sumber_bahaya' => 0.6, 'riwayat_bencana' => 0.5, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Tengah', 'kelurahan' => 'Matani Satu', 'lat' => 1.319924, 'lng' => 124.851705, 'jenis_bencana' => 'Banjir', 'tingkat_kerentanan' => 'Rendah', 'curah_hujan' => 0.4, 'kemiringan_lereng' => 0.2, 'vegetasi' => 0.7, 'jarak_sumber_bahaya' => 0.3, 'riwayat_bencana' => 0.3, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Tengah', 'kelurahan' => 'Matani Satu', 'lat' => 1.318435, 'lng' => 124.851724, 'jenis_bencana' => 'Longsor', 'tingkat_kerentanan' => 'Menengah', 'curah_hujan' => 0.5, 'kemiringan_lereng' => 0.5, 'vegetasi' => 0.5, 'jarak_sumber_bahaya' => 0.5, 'riwayat_bencana' => 0.5, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Tengah', 'kelurahan' => 'Matani Satu', 'lat' => 1.316283, 'lng' => 124.851024, 'jenis_bencana' => 'Banjir', 'tingkat_kerentanan' => 'Rendah', 'curah_hujan' => 0.3, 'kemiringan_lereng' => 0.2, 'vegetasi' => 0.8, 'jarak_sumber_bahaya' => 0.3, 'riwayat_bencana' => 0.2, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Barat', 'kelurahan' => 'Tara-tara 3', 'lat' => 1.321775, 'lng' => 124.788891, 'jenis_bencana' => 'Longsor', 'tingkat_kerentanan' => 'Menengah', 'curah_hujan' => 0.6, 'kemiringan_lereng' => 0.6, 'vegetasi' => 0.5, 'jarak_sumber_bahaya' => 0.6, 'riwayat_bencana' => 0.5, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Barat', 'kelurahan' => 'Tara-tara 3', 'lat' => 1.320006, 'lng' => 124.783779, 'jenis_bencana' => 'Banjir', 'tingkat_kerentanan' => 'Rendah', 'curah_hujan' => 0.4, 'kemiringan_lereng' => 0.2, 'vegetasi' => 0.7, 'jarak_sumber_bahaya' => 0.3, 'riwayat_bencana' => 0.3, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Utara', 'kelurahan' => 'Wailan', 'lat' => 1.342609, 'lng' => 124.820013, 'jenis_bencana' => 'Banjir', 'tingkat_kerentanan' => 'Rendah', 'curah_hujan' => 0.3, 'kemiringan_lereng' => 0.2, 'vegetasi' => 0.8, 'jarak_sumber_bahaya' => 0.3, 'riwayat_bencana' => 0.2, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Utara', 'kelurahan' => 'Wailan', 'lat' => 1.342952, 'lng' => 124.805140, 'jenis_bencana' => 'Kebakaran Hutan', 'tingkat_kerentanan' => 'Rendah', 'curah_hujan' => 0.2, 'kemiringan_lereng' => 0.3, 'vegetasi' => 0.6, 'jarak_sumber_bahaya' => 0.4, 'riwayat_bencana' => 0.3, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Utara', 'kelurahan' => 'Wailan', 'lat' => 1.340481, 'lng' => 124.807203, 'jenis_bencana' => 'Kebakaran Hutan', 'tingkat_kerentanan' => 'Rendah', 'curah_hujan' => 0.2, 'kemiringan_lereng' => 0.3, 'vegetasi' => 0.6, 'jarak_sumber_bahaya' => 0.4, 'riwayat_bencana' => 0.3, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Utara', 'kelurahan' => 'Kakaskasen Dua', 'lat' => 1.347816, 'lng' => 124.828237, 'jenis_bencana' => 'Banjir', 'tingkat_kerentanan' => 'Rendah', 'curah_hujan' => 0.4, 'kemiringan_lereng' => 0.2, 'vegetasi' => 0.7, 'jarak_sumber_bahaya' => 0.3, 'riwayat_bencana' => 0.3, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Utara', 'kelurahan' => 'Kakaskasen Satu', 'lat' => 1.351792, 'lng' => 124.829968, 'jenis_bencana' => 'Banjir', 'tingkat_kerentanan' => 'Rendah', 'curah_hujan' => 0.3, 'kemiringan_lereng' => 0.2, 'vegetasi' => 0.8, 'jarak_sumber_bahaya' => 0.3, 'riwayat_bencana' => 0.2, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Utara', 'kelurahan' => 'Kakaskasen Tiga', 'lat' => 1.336687, 'lng' => 124.824284, 'jenis_bencana' => 'Kebakaran Hutan', 'tingkat_kerentanan' => 'Rendah', 'curah_hujan' => 0.2, 'kemiringan_lereng' => 0.3, 'vegetasi' => 0.6, 'jarak_sumber_bahaya' => 0.4, 'riwayat_bencana' => 0.3, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Utara', 'kelurahan' => 'Kakaskasen', 'lat' => 1.332869, 'lng' => 124.825528, 'jenis_bencana' => 'Longsor', 'tingkat_kerentanan' => 'Menengah', 'curah_hujan' => 0.5, 'kemiringan_lereng' => 0.5, 'vegetasi' => 0.5, 'jarak_sumber_bahaya' => 0.5, 'riwayat_bencana' => 0.5, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Utara', 'kelurahan' => 'Kakaskasen', 'lat' => 1.332222, 'lng' => 124.824105, 'jenis_bencana' => 'Longsor', 'tingkat_kerentanan' => 'Menengah', 'curah_hujan' => 0.6, 'kemiringan_lereng' => 0.6, 'vegetasi' => 0.4, 'jarak_sumber_bahaya' => 0.6, 'riwayat_bencana' => 0.5, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Utara', 'kelurahan' => 'Kakaskasen Tiga', 'lat' => 1.339401, 'lng' => 124.829256, 'jenis_bencana' => 'Banjir', 'tingkat_kerentanan' => 'Rendah', 'curah_hujan' => 0.3, 'kemiringan_lereng' => 0.2, 'vegetasi' => 0.8, 'jarak_sumber_bahaya' => 0.3, 'riwayat_bencana' => 0.2, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Utara', 'kelurahan' => 'Kakaskasen Tiga', 'lat' => 1.340865, 'lng' => 124.831201, 'jenis_bencana' => 'Banjir', 'tingkat_kerentanan' => 'Rendah', 'curah_hujan' => 0.4, 'kemiringan_lereng' => 0.2, 'vegetasi' => 0.7, 'jarak_sumber_bahaya' => 0.3, 'riwayat_bencana' => 0.3, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Utara', 'kelurahan' => 'Kakaskasen Tiga', 'lat' => 1.345417, 'lng' => 124.829639, 'jenis_bencana' => 'Banjir', 'tingkat_kerentanan' => 'Menengah', 'curah_hujan' => 0.6, 'kemiringan_lereng' => 0.4, 'vegetasi' => 0.5, 'jarak_sumber_bahaya' => 0.5, 'riwayat_bencana' => 0.6, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Tengah', 'kelurahan' => 'Matani Tiga', 'lat' => 1.314870, 'lng' => 124.829639, 'jenis_bencana' => 'Banjir', 'tingkat_kerentanan' => 'Menengah', 'curah_hujan' => 0.6, 'kemiringan_lereng' => 0.4, 'vegetasi' => 0.5, 'jarak_sumber_bahaya' => 0.5, 'riwayat_bencana' => 0.6, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Tengah', 'kelurahan' => 'Kamasi', 'lat' => 1.319246, 'lng' => 124.826015, 'jenis_bencana' => 'Banjir', 'tingkat_kerentanan' => 'Rendah', 'curah_hujan' => 0.4, 'kemiringan_lereng' => 0.2, 'vegetasi' => 0.7, 'jarak_sumber_bahaya' => 0.3, 'riwayat_bencana' => 0.3, 'created_at' => now(), 'updated_at' => now()],
            ['kecamatan' => 'Tomohon Utara', 'kelurahan' => 'Kakaskasen Tiga', 'lat' => 1.351901, 'lng' => 124.800451, 'jenis_bencana' => 'Kebakaran Hutan', 'tingkat_kerentanan' => 'Tinggi', 'curah_hujan' => 0.2, 'kemiringan_lereng' => 0.7, 'vegetasi' => 0.2, 'jarak_sumber_bahaya' => 0.8, 'riwayat_bencana' => 0.9, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('bencanas')->insert($data);
    }
}
