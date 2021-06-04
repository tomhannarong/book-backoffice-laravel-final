<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderMasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_mas', function (Blueprint $table) {
            $table->id();
            $table->date('order_date')->nullable();
            $table->time('order_time', 0)->nullable();
            $table->string('username', 50)->nullable(); 
            $table->text('payment')->nullable();
            $table->text('transport')->nullable();
            $table->decimal('transport_rate', 10, 2)->nullable();
            $table->decimal('net_price', 10, 2)->nullable();
            $table->text('order_status')->nullable();
            $table->string('show_status', 5)->nullable(); 
            $table->text('tranfer_address')->nullable();
            $table->string('tracking_number', 50)->nullable();
            $table->string('confirmation', 255)->nullable();
            $table->date('date_paid')->nullable();
            $table->string('fullname')->nullable(); 
            $table->string('address_subdistric')->nullable(); 
            $table->string('address_distric')->nullable(); 
            $table->string('address_province')->nullable(); 
            $table->string('address_zipcode')->nullable(); 
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
        Schema::dropIfExists('order_mas');
    }
}
