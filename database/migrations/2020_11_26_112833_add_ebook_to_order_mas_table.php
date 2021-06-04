<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEbookToOrderMasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_mas', function (Blueprint $table) {
            $table->string('approve_status',1)->nullable()->after('order_status');
            $table->date('approve_date')->nullable(); 
            $table->time('approve_time', 0)->nullable();
            $table->time('paid_time', 0)->nullable()->after('date_paid');
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
            $table->dropColumn('approve_status');
            $table->dropColumn('approve_date');
            $table->dropColumn('approve_time');
            $table->dropColumn('paid_time');
           
        });
    }
}
