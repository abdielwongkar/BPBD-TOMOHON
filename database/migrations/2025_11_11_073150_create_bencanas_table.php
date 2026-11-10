<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bencanas', function (Blueprint $table) {

            $table->id();
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->decimal('lat', 10, 6);
            $table->decimal('lng', 10, 6);
            $table->string('jenis_bencana');
            $table->string('tingkat_kerentanan');
            $table->decimal('curah_hujan', 3, 2);
            $table->decimal('kemiringan_lereng', 3, 2);
            $table->decimal('vegetasi', 3, 2);
            $table->decimal('jarak_sumber_bahaya', 3, 2);
            $table->decimal('riwayat_bencana', 3, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bencanas');
    }
};
