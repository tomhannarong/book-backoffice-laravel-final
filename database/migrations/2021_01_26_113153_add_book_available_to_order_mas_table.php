<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBookAvailableToOrderMasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_mas', function (Blueprint $table) {
            $table->string('book_available')->nullable()->after('reason');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_mas', function (Blueprint $table) {
            $table->dropColumn('book_available');
        });
    }
}
