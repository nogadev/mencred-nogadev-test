<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditsArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_credits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('credit_id')->unsigned();
            $table->foreign('credit_id')->references('id')->on('credits');
            $table->integer('article_id')->unsigned();
            $table->foreign('article_id')->references('id')->on('articles');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->integer('store_id')->unsigned();
            $table->foreign('store_id')->references('id')->on('stores');

            $table->decimal('price',10,2)->nullable();
            $table->decimal('quantity',10,2)->nullable();

            $table->string('serial_number',128)->nullable();
            $table->boolean('billed')->default(0);

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
        Schema::dropIfExists('article_credits');
    }
}
