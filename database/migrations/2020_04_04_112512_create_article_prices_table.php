<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('article_id')->unsigned();
            $table->foreign('article_id')->references('id')->on('articles');
            $table->integer('point_of_sales_id')->unsigned();
            $table->foreign('point_of_sales_id')->references('id')->on('point_of_sales');
            $table->decimal('price',9,2)->nullable();
            $table->integer('fee_quantity')->unsigned()->nullable();
            $table->decimal('fee_amount',9,2)->nullable();
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
        Schema::dropIfExists('article_prices');
    }
}
