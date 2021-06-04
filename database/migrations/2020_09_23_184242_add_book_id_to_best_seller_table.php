<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBookIdToBestSellerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('best_seller', function (Blueprint $table) {
            $table->unsignedInteger('book_id')->nullable()->after('attachment'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('best_seller', function (Blueprint $table) {
            $table->dropColumn('book_id');
        });
    }
}
