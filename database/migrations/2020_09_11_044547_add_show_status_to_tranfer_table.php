<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShowStatusToTranferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tranfer', function (Blueprint $table) {
            $table->string('show_status', 5)->nullable()->after('username'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tranfer', function (Blueprint $table) {
            $table->dropColumn('show_status');
        });
    }
}
