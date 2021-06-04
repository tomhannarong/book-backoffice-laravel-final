<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToOrderMasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_mas', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable()->after('address_zipcode'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_mas', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
}
