<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRealisasiSumberDanaToRkaPengeluarans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rka_pengeluarans', function (Blueprint $table) {
            $table->json('realisasi_sumber_dana')->nullable()->after('sumber_dana');
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
            $table->dropColumn('realisasi_sumber_dana');
        });
    }
}
