<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBestSellerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('best_seller', function (Blueprint $table) {
            $table->id();
            $table->integer('top')->nullable(); 
            $table->text('book_name')->nullable();
            $table->text('alias')->nullable();
            $table->double('price' , 7 , 2)->nullable();
            $table->integer('pim_time')->nullable(); 
            $table->text('isbn')->nullable();
            $table->text('writer')->nullable();
            $table->integer('pages')->nullable(); 
            $table->text('book_description')->nullable();
            $table->text('picture')->nullable();
            $table->text('pim_year')->nullable();
            $table->text('publisher_id')->nullable();
            $table->integer('book_type_id')->nullable(); 
            $table->text('attachment')->nullable();
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
        Schema::dropIfExists('best_seller');
    }
}
