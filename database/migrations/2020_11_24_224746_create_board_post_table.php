<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_post', function (Blueprint $table) {
            $table->id();
            $table->text('topic')->nullable(); 
            $table->string('username')->nullable();
            $table->integer('view')->nullable();
            $table->text('post_description')->nullable(); 
            $table->string('show_status',5)->nullable();
            $table->string('pin',1)->nullable();
            $table->dateTime('post_date', 0)->nullable(); 
            $table->dateTime('lastupdate', 0)->nullable(); 
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
        Schema::dropIfExists('board_post');
    }
}
