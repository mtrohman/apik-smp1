<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailToRkaPengeluarans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rka_pengeluarans', function (Blueprint $table) {
            $table->json('sumber_dana')->after('kegiatan_id');
            $table->json('alokasi')->after('sumber_dana');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rka_pengeluarans', function (Blueprint $table) {
            $table->dropColumn('sumber_dana');
            $table->dropColumn('alokasi');
        });
    }
}
