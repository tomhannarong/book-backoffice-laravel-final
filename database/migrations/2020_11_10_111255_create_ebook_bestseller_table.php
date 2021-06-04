<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEbookBestsellerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ebook_bestseller', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->nullable();
            $table->integer('seq')->nullable();
            $table->dateTime('post_date', 0)->nullable();
            $table->string('ip',15)->nullable();
            $table->integer('pv')->nullable();
            $table->integer('sale_qty')->nullable();
            $table->string('device',1)->nullable();
            $table->string('best_type',1)->nullable();
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
        Schema::dropIfExists('ebook_bestseller');
    }
}
