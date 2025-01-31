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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('role_id');
            $table->enum('jns_kelamin', ['Laki-laki', 'Perempuan']);
            $table->bigInteger('nip');
            $table->string('no_hp');
            $table->string('username', 70)->unique();
            $table->string('password', 255);
            $table->timestamps();
            
            $table->foreign('role_id')->references('id')->on('role');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
