<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tranfer', function (Blueprint $table) {
            $table->id();
            $table->date('tranfer_date')->nullable();
            $table->string('tranfer_time', 10)->nullable();
            $table->dateTime('inform_date',)->nullable();
            $table->text('attach_slip',)->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->unsignedInteger('account_tranfer')->nullable();
            $table->text('bank_tranfer')->nullable();
            $table->string('username', 50)->nullable();
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
        Schema::dropIfExists('tranfer');
    }
}
