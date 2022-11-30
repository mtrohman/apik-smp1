<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRkaPengeluaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rka_pengeluarans', function (Blueprint $table) {
            $table->id();
            $table->year('ta');
            $table->unsignedBigInteger('kegiatan_id');
            $table->double('nominal', 12, 2);
            $table->double('realisasi_1' , 12, 2)->default(0);
            $table->double('realisasi_2' , 12, 2)->default(0);
            $table->double('realisasi_3' , 12, 2)->default(0);
            $table->double('realisasi_4' , 12, 2)->default(0);
            $table->double('realisasi_5' , 12, 2)->default(0);
            $table->double('realisasi_6' , 12, 2)->default(0);
            $table->double('realisasi_7' , 12, 2)->default(0);
            $table->double('realisasi_8' , 12, 2)->default(0);
            $table->double('realisasi_9' , 12, 2)->default(0);
            $table->double('realisasi_10', 12, 2)->default(0);
            $table->double('realisasi_11', 12, 2)->default(0);
            $table->double('realisasi_12', 12, 2)->default(0);
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
        Schema::dropIfExists('rka_pengeluarans');
    }
}
