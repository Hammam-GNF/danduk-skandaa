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
        Schema::create('wakel', function (Blueprint $table) {
            $table->string('nip')->primary();
            $table->string('nama_wakel');
            $table->unsignedBigInteger('kelas_id');
            $table->string('jurusan_id');
            $table->unsignedBigInteger('rombel_id');
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('kelas_id')->references('id')->on('kelas');
            $table->foreign('jurusan_id')->references('id_jurusan')->on('jurusan');
            $table->foreign('rombel_id')->references('id')->on('rombel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wakel');
    }
};