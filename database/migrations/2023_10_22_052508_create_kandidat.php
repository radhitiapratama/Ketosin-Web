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
        Schema::create('kandidat', function (Blueprint $table) {
            $table->id("id_kandidat");
            $table->foreignId("id_ketua")->references("id_peserta")->on("peserta");
            $table->foreignId("id_wakil")->references("id_peserta")->on("peserta");
            $table->text("visi");
            $table->text("misi");
            $table->text("slogan");
            $table->string("foto")->nullable();
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
        Schema::dropIfExists('kandidat');
    }
};
