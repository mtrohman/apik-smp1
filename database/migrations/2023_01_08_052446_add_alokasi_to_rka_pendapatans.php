<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAlokasiToRkaPendapatans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rka_pendapatans', function (Blueprint $table) {
            $table->json('alokasi')->nullable()->after('rekening_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rka_pendapatans', function (Blueprint $table) {
            $table->dropColumn('alokasi');
        });
    }
}
