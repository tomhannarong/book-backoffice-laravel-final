<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEbookOrderPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ebook_order_payment', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('order_id')->nullable();
            $table->unsignedInteger('payment_id')->nullable();
            $table->string('username_customer')->nullable(); 
            $table->string('username_receipt')->nullable(); 
            $table->decimal('total_order', 10, 2)->nullable();
            $table->dateTime('bank_datetime', 0)->nullable(); 
            $table->string('payment_method' , 1)->nullable(); 
            $table->string('remark1')->nullable(); 
            $table->string('file1')->nullable(); 
            $table->string('order_status' , 1)->nullable(); 
            $table->dateTime('approve_date', 0)->nullable(); 
            $table->dateTime('post_date', 0)->nullable(); 
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
        Schema::dropIfExists('ebook_order_payment');
    }
}
