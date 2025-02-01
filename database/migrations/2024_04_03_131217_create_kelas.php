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
            $table->increments('id');

            //foreign
            $table->unsignedInteger('jurusan_id');
            
            $table->string('kelas_tingkat', 10);
            $table->integer('rombel');
            $table->timestamps();
            
            $table->foreign('jurusan_id')->references('id')->on('jurusan')->onUpdate('cascade')->onDelete('restrict');
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