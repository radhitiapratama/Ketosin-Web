<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemilihan', function (Blueprint $table) {
            $table->id("id_pemilihan");
            $table->foreignId("id_peserta")->references("id_peserta")->on("peserta");
            $table->foreignId("id_kandidat")->references("id_kandidat")->on("kandidat");
            $table->timestamp("waktu");
            $table->string("longtitude")->nullable();
            $table->string("latitude")->nullable();
            $table->string("mac")->nullable();
            $table->integer("status")->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemilihan');
    }
};
