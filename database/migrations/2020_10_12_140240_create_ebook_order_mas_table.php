<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEbookOrderMasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ebook_order_mas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('share_id')->nullable();
            $table->date('order_date')->nullable(); 
            $table->time('order_time', 0)->nullable(); 
            $table->string('username')->nullable(); 
            $table->string('device')->nullable();
            $table->decimal('total_order', 10, 2)->nullable();
            $table->unsignedInteger('payment_id')->nullable();
            $table->string('order_status',1)->nullable();
            $table->string('username_receipt')->nullable();
            $table->string('approve_status',1)->nullable();
            $table->date('approve_date')->nullable(); 
            $table->time('approve_time', 0)->nullable(); 
            $table->date('paid_date')->nullable(); 
            $table->time('paid_time', 0)->nullable();
            $table->integer('pay_method')->nullable();





            
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
        Schema::dropIfExists('ebook_order_mas');
    }
}
