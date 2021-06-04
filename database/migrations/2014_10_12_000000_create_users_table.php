<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50)->nullable();
            $table->string('password');
            $table->string('class_user', 5)->nullable();
            $table->string('name' , 50)->nullable();
            $table->string('surname')->nullable();
            $table->string('address' , 300)->nullable();
            $table->string('email', 150)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('tel', 15    )->nullable();  
            $table->string('alias' , 30)->nullable();
            $table->string('sid')->nullable();
            $table->string('bank_name' , 10)->nullable();
            $table->string('bank_no' , 20)->nullable();
            $table->string('bank_acc' , 50)->nullable();
            $table->integer('bank_type')->nullable();
            $table->string('bank_branch' , 50)->nullable();
            $table->string('bank_file' , 150)->nullable();
            $table->string('ban_status' , 5)->nullable();
            $table->string('ip', 15)->nullable();
            $table->string('sex' ,15)->nullable();
            $table->date('birthday')->nullable();
            $table->integer('news')->nullable();
            $table->double('revenue_share' , 5 , 2)->nullable();
            $table->string('memberCode' ,10)->nullable();
            
            $table->string('department')->nullable();
            $table->string('road')->nullable();
            $table->string('village')->nullable();
            $table->string('address_full')->nullable();
            $table->string('subdistric')->nullable();
            $table->string('distric')->nullable();
            $table->string('province')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('avatar')->nullable();
            $table->string('ban')->nullable();         
            $table->string('soi')->nullable();
            $table->string('moo')->nullable();
            $table->text('condo')->nullable();
            $table->text('welcome_message')->nullable();
            $table->bigInteger('counter')->nullable();
            $table->string('bg_color')->nullable();
            $table->text('bg_img')->nullable();
            $table->string('bg_repeat')->nullable();
            $table->string('bg_attachment')->nullable();
            $table->string('bg_hposition')->nullable();
            $table->string('bg_vposition')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
