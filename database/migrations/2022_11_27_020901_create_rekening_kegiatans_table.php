<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekeningKegiatansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekening_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rekening_id');
            $table->string('kode_kegiatan');
            $table->string('nama_kegiatan');
            $table->string('ket_kegiatan')->nullable();
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
        Schema::dropIfExists('rekening_kegiatans');
    }
}
