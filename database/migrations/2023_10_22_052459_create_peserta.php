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
        Schema::create('peserta', function (Blueprint $table) {
            $table->id("id_peserta");
            $table->string("nama_peserta");
            $table->integer("tipe");
            $table->string("qr_code")->nullable();
            $table->integer("tingkatan")->nullable();
            $table->foreignId("id_kelas")->nullable()->references("id_kelas")->on("kelas");
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
        Schema::dropIfExists('peserta');
    }
};
