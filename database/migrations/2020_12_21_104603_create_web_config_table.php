<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_config', function (Blueprint $table) {
            $table->id();
            $table->string('shop_name')->nullable();
            $table->text('logo')->nullable(); 
            $table->string('tag_title')->nullable();  
            $table->text('tag_keyword')->nullable(); 
            $table->text('tag_description')->nullable(); 
            $table->string('publisher')->nullable(); 
            $table->text('address')->nullable();
            $table->text('subdistric')->nullable();
            $table->text('distric')->nullable();
            $table->text('province')->nullable();
            $table->text('zipcode')->nullable();
            $table->string('tel')->nullable(); 
            $table->string('mobile_number')->nullable(); 
            $table->string('fax')->nullable(); 
            $table->string('email')->nullable();
            $table->string('email_news')->nullable();
            $table->string('buffet',10)->nullable();
            $table->double('share_admin', 5, 2);
            $table->double('share_pub', 5, 2);
            $table->double('fee', 11, 2);
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
        Schema::dropIfExists('web_config');
    }
}
