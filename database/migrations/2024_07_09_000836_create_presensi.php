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
        Schema::create('presensi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('totalsakit')->nullable();
            $table->integer('totalizin')->nullable();
            $table->integer('totalalpa')->nullable();
            $table->string('keterangan')->nullable();
            
            $table->unsignedInteger('mapel_id');
            $table->unsignedInteger('id_guru');
            $table->unsignedInteger('wakel_id');
            $table->unsignedInteger('kelas_id');
            $table->bigInteger('nis');
            $table->unsignedInteger('pembelajaran_id');
            $table->timestamps();

            $table->foreign('mapel_id')->references('id')->on('mapel')->onDelete('cascade')->onUpdate('restrict');
            $table->foreign('id_guru')->references('id')->on('users')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('wakel_id')->references('id')->on('wakel')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('nis')->references('nis')->on('siswa')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('pembelajaran_id')->references('id')->on('pembelajaran')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi');
    }
};
