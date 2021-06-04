<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('product_id')->nullable();
            $table->unsignedInteger('order_id')->nullable();
            $table->string('username')->nullable();
            $table->decimal('price', 10, 2); 
            $table->decimal('product_price', 10, 2); 
            $table->integer('quantitys')->nullable();
            $table->integer('percent_discount')->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('net', 10, 2)->nullable();
            $table->decimal('share_percent', 10, 2)->nullable();
            $table->string('buffet',10)->default('false')->nullable();
            $table->string('is_ebook',10)->nullable();
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
        Schema::dropIfExists('order_history');
    }
}
