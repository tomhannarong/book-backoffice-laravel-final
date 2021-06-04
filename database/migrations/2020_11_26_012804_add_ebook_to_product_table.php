<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEbookToProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->decimal('product_price', 10, 2)->nullable()->after('price');
            $table->text('promote_link')->nullable(); 
            $table->text('product_pdf')->nullable(); 
            $table->decimal('affiliate_price', 10, 2)->nullable();
            $table->string('username')->nullable(); 
            $table->string('publish1',1)->nullable();
            $table->string('best_seller',1)->nullable(); 
            $table->string('recommended',1)->nullable(); 
            $table->string('hot_item',1)->nullable(); 
            $table->string('user_book',1)->nullable();   
            $table->string('is_ebook',10)->nullable();   
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
            $table->dropColumn('product_price');
            $table->dropColumn('promote_link');
            $table->dropColumn('product_pdf');
            $table->dropColumn('affiliate_price');
            $table->dropColumn('username');
            $table->dropColumn('publish1');
            $table->dropColumn('best_seller');
            $table->dropColumn('recommended');
            $table->dropColumn('hot_item');
            $table->dropColumn('user_book');
            $table->dropColumn('is_ebook');
        });
    }
}
