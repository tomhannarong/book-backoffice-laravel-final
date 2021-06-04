<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRateStarNumberToProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->integer('rate_one_num')->default(0)->after('rate_num');
            $table->integer('rate_two_num')->default(0)->after('rate_one_num');
            $table->integer('rate_three_num')->default(0)->after('rate_two_num');
            $table->integer('rate_four_num')->default(0)->after('rate_three_num');
            $table->integer('rate_five_num')->default(0)->after('rate_four_num');
            $table->integer('comment_num')->default(0)->after('rate_five_num');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropColumn('rate_one_num');
            $table->dropColumn('rate_two_num');
            $table->dropColumn('rate_three_num');
            $table->dropColumn('rate_four_num');
            $table->dropColumn('rate_five_num');
            $table->dropColumn('comment_num');
        });
    }
}
