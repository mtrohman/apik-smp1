<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKodeToRekeningParentPendapatans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rekening_parent_pendapatans', function (Blueprint $table) {
            $table->string('kode_parent')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rekening_parent_pendapatans', function (Blueprint $table) {
            $table->dropColumn('kode_parent');
        });
    }
}
