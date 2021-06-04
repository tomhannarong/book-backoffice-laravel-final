<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEbookToOrderTranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_tran', function (Blueprint $table) {
            $table->string('username')->nullable()->after('order_id'); 
            $table->decimal('product_price', 10, 2)->nullable()->after('price'); 
            $table->double('share_percent', 10, 2)->nullable()->after('net'); 
            $table->string('approve_status',1)->nullable();
            $table->dateTime('approve_date',0)->nullable();  
            $table->string('is_ebook',10)->nullable();   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_tran', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('product_price');
            $table->dropColumn('share_percent');
            $table->dropColumn('approve_status');
            $table->dropColumn('approve_date');
            $table->dropColumn('is_ebook');
        });
    }
}
