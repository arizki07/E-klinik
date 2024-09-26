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
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pasien');
            $table->string('ktp');
            $table->date('tgl_lahir');
            $table->string('alamat');
            $table->string('no_tlpn');
            $table->enum('jenis_pasien', ['baru', 'lama']);
            $table->boolean('bpjs_status')->default(false);
            $table->string('bpjs_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
