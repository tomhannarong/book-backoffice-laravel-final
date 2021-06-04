<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_news', function (Blueprint $table) {
            $table->id();
            $table->text('head_news')->nullable(); 
            $table->text('news_detail')->nullable(); 
            $table->string('username')->nullable();
            $table->dateTime('news_date', 0)->nullable(); 
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
        Schema::dropIfExists('web_news');
    }
}
