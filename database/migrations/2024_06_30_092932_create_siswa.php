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
        Schema::create('siswa', function (Blueprint $table) {
            $table->bigInteger('nis')->primary();

            //foreign
            $table->unsignedInteger('thajaran_id')->nullable();
            $table->unsignedInteger('kelas_id');

            $table->char('nama_siswa', 100);
            $table->char('jns_kelamin', 10);
            $table->char('status',20);
            $table->char('nama_ortu', 100)->nullable();
            $table->bigInteger('nohp_ortu')->nullable();
            $table->string('alamat', 255)->nullable();
            $table->timestamps();

            $table->foreign('thajaran_id')->references('id')->on('tahunajaran')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onUpdate('cascade')->onDelete('restrict');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
