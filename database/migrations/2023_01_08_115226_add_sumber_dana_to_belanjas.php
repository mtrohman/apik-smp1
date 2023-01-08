<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSumberDanaToBelanjas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('belanjas', function (Blueprint $table) {
            $table->string('sumber_dana')->nullable()->after('rka_pengeluaran_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('belanjas', function (Blueprint $table) {
            $table->dropColumn('sumber_dana');
        });
    }
}
