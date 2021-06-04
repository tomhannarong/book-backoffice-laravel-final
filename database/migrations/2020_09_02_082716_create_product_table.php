<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->text('book_name')->nullable();
            $table->integer('book_type_id')->nullable();
            $table->text('writer')->nullable();
            $table->text('alias')->nullable();
            $table->double('price' , 7 , 2)->nullable();
            $table->integer('pages')->nullable();
            $table->text('book_description')->nullable();
            $table->text('picture')->nullable();
            $table->text('attachment')->nullable();
            $table->integer('stock')->nullable();
            $table->text('on_market')->nullable();
            $table->text('ISBN')->nullable();
            $table->integer('pim_time')->nullable();
            $table->integer('pim_year')->nullable();
            $table->integer('publisher_id')->nullable();
            $table->text('tag_description')->nullable();
            $table->text('tag_keyword')->nullable();
            $table->string('blame_product' ,5)->nullable();
            $table->string('serie_product' ,5)->nullable();
            $table->text('blame_position')->nullable();
            $table->text('blame_images')->nullable();
            $table->string('show_blame' ,5)->nullable();
            $table->text('blog_url')->nullable();
            $table->text('youtube_url')->nullable();
            $table->string('buffet' ,10)->nullable();
            $table->integer('stock_total')->nullable();
            $table->integer('stock_hold')->nullable();
            $table->integer('stock_remain')->nullable();
            $table->integer('stock_sold')->nullable();
            $table->string('public_show' ,10)->nullable();
            $table->string('can_discount' ,10)->nullable();
            $table->integer('book_weight')->nullable();
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
        Schema::dropIfExists('product');
    }
}
