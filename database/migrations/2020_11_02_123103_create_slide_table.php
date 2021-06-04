<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlideTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slide', function (Blueprint $table) {
            $table->id();
            $table->integer('position')->nullable();
            $table->text('slide_name')->nullable(); 
            $table->text('slide_images')->nullable(); 
            $table->string('first_page',1)->nullable(); 
            $table->string('cart_page',1)->nullable(); 
            $table->string('cartb_page',1)->nullable(); 
            $table->string('carts_page',1)->nullable(); 
            $table->string('buffet_page',1)->nullable(); 
            $table->string('is_active',1)->nullable(); 
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
        Schema::dropIfExists('slide');
    }
}
