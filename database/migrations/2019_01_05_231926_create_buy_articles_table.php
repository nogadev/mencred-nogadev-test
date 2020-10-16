<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('buy_id')->unsigned();
            $table->foreign('buy_id')->references('id')->on('buys');
            $table->integer('article_id')->unsigned();
            $table->foreign('article_id')->references('id')->on('articles');
            $table->string('code');
            $table->string('barcode');
            $table->string('description');
            $table->integer('item_no');
            $table->decimal('quantity',8,2);
            $table->decimal('net',9,2);
            $table->decimal('bonus_percentage',8,5)->nullable();
            $table->decimal('bonus',9,2)->nullable();
            $table->decimal('tax_percentage',5,2)->nullable();
            $table->decimal('tax',9,2)->nullable();
            $table->decimal('subtotal',9,2);            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buy_articles');
    }
}
