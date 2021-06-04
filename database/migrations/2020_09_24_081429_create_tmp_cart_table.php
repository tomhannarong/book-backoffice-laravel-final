<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmpCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmp_cart', function (Blueprint $table) {
            $table->id();            
            $table->unsignedInteger('book_id')->nullable();
            $table->string('username')->nullable(); 
            $table->integer('quantity')->nullable();
            $table->string('blame_product',5)->nullable(); 
            $table->string('buffet',5)->nullable(); 
            $table->string('can_discount',5)->nullable();   
            $table->unsignedInteger('user_id')->nullable();
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
        Schema::dropIfExists('tmp_cart');
    }
}
