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
            $table->id("pemilihan_id");
            $table->foreignId("id_peserta")->references("id_peserta")->on("peserta");
            $table->foreignId("id_kandidat")->references("id_kandidat")->on("kandidat");
            $table->timestamp("waktu");
            $table->string("longtitude");
            $table->string("langtitude");
            $table->string("mac");
            $table->integer("status");
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
