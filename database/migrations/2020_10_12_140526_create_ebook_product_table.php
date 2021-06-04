<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEbookProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ebook_product', function (Blueprint $table) {
            $table->id();
            $table->string('product_name')->nullable(); 
            $table->unsignedInteger('cat_id')->nullable();
            $table->string('product_image')->nullable(); 
            $table->string('product_thumb_image')->nullable(); 
            $table->text('promote_link')->nullable(); 
            $table->text('product_description')->nullable(); 
            $table->string('product_pdf')->nullable(); 
            $table->string('product_pdf2')->nullable(); 
            $table->dateTime('add_date', 0)->nullable(); 
            $table->dateTime('last_modified', 0)->nullable(); 
            $table->decimal('alias_price', 10, 2)->nullable();
            $table->decimal('product_price', 10, 2)->nullable();
            $table->decimal('affiliate_price', 10, 2)->nullable();
            $table->integer('sale_qty')->nullable();
            $table->string('username')->nullable(); 
            $table->string('publish1',1)->nullable(); 
            $table->string('best_seller',1)->nullable(); 
            $table->string('recommended',1)->nullable(); 
            $table->string('hot_item',1)->nullable(); 
            $table->string('user_book',1)->nullable(); 
            $table->string('alias1')->nullable(); 
            $table->string('publishing1')->nullable(); 
            $table->string('serie_set')->nullable(); 
            $table->string('preview')->nullable(); 
            $table->integer('enable')->nullable();
            $table->string('ISBN')->nullable(); 
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
        Schema::dropIfExists('ebook_product');
    }
}
