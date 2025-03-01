<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNfcToAssetExtracomtableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_extracomptable', function (Blueprint $table) {
            //
            $table->string('nfc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asset_extracomptable', function (Blueprint $table) {
            //
            $table->dropColumn('nfc');
        });
    }
}
