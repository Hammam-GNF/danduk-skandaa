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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id('id_kelas');
            $table->string('kelas_tingkat');
            $table->string('jurusan_id');
            $table->string('rombel_id');
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('jurusan_id')->references('id_jurusan')->on('jurusan');
            $table->foreign('rombel_id')->references('id_rombel')->on('rombel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};