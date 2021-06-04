<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaitFictionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wait_fiction', function (Blueprint $table) {
            $table->id();
            $table->text('book_name')->nullable();
            $table->text('alias')->nullable();
            $table->decimal('price', 7, 2)->nullable();
            $table->text('pim_time')->nullable();
            $table->text('isbn')->nullable();
            $table->text('writer')->nullable();
            $table->text('pages')->nullable();
            $table->text('book_description')->nullable();
            $table->text('picture')->nullable();
            $table->text('pim_year')->nullable();
            $table->text('publisher_id')->nullable();
            $table->integer('book_type_id')->nullable();
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
        Schema::dropIfExists('wait_fiction');
    }
}
