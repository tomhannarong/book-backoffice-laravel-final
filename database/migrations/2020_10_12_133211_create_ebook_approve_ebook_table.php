<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEbookApproveEbookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ebook_approve_ebook', function (Blueprint $table) {
            $table->id();
            
            $table->string('username')->nullable(); 
            $table->unsignedInteger('product_id')->nullable();
            $table->unsignedInteger('order_id')->nullable();
            $table->unsignedInteger('tran_id')->nullable();
            $table->string('approve_status',1)->nullable(); 
            $table->dateTime('approve_date', 0)->nullable(); 
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
        Schema::dropIfExists('ebook_approve_ebook');
    }
}
