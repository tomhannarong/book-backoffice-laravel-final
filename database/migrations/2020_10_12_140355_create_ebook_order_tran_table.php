<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEbookOrderTranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ebook_order_tran', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('order_id')->nullable();
            $table->unsignedInteger('share_id')->nullable();
            $table->unsignedInteger('product_id')->nullable();
            $table->string('username')->nullable(); 
            $table->string('device' , 1)->nullable(); 
            $table->string('udid1' , 50)->nullable(); 
            $table->string('udid2' , 50)->nullable(); 
            $table->string('udid3' , 50)->nullable(); 
            $table->decimal('product_price', 10, 2)->nullable();
            $table->integer('product_qty')->nullable();
            $table->decimal('total_price', 10, 2)->nullable();
            $table->string('username_owner')->nullable(); 
            $table->double('share_percent', 5, 2);
            $table->string('order_status' , 1)->nullable(); 
            $table->dateTime('order_date', 0)->nullable(); 
            $table->dateTime('approve_date', 0)->nullable(); 
            $table->date('paid_date')->nullable(); 
            $table->time('paid_time', 0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ebook_order_tran');
    }
}
