<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('nilai', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uh1')->nullable();
            $table->integer('uh2')->nullable();
            $table->integer('uh3')->nullable();
            $table->integer('uts')->nullable();
            $table->integer('uas')->nullable();

            $table->bigInteger('nis');
            $table->unsignedInteger('id_guru');
            $table->unsignedInteger('wakel_id');
            $table->unsignedInteger('kelas_id');
            $table->unsignedInteger('mapel_id');
            $table->unsignedInteger('pembelajaran_id');
            $table->timestamps();
    
            $table->foreign('nis')->references('nis')->on('siswa')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('id_guru')->references('id')->on('users')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('wakel_id')->references('id')->on('wakel')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('mapel_id')->references('id')->on('mapel')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('pembelajaran_id')->references('id')->on('pembelajaran')->onUpdate('cascade')->onDelete('restrict');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
