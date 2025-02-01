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
        Schema::create('pembelajaran', function (Blueprint $table) {
            $table->increments('id');

            //foreign
            $table->unsignedInteger('thajaran_id');
            $table->unsignedInteger('id_guru');
            $table->unsignedInteger('wakel_id');
            $table->unsignedInteger('kelas_id');
            $table->unsignedInteger('mapel_id');
            $table->timestamps();

            $table->foreign('thajaran_id')->references('id')->on('tahunajaran')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('id_guru')->references('id')->on('users')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('wakel_id')->references('id')->on('wakel')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('mapel_id')->references('id')->on('mapel')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelajaran');
    }
};
