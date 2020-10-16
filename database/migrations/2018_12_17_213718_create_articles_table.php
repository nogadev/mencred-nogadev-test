<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code'); 
            $table->string('barcode')->nullable(); 
            $table->string('description');
            $table->string('print_name')->nullable();
            $table->string('price_update_level')->nullable();
            $table->double('price',9,2)->nullable();
            $table->integer('fee_quantity')->unsigned()->nullable();
            $table->double('fee_amount',9,2)->nullable();
            $table->integer('supplier_id')->nullable()->unsigned();
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->integer('article_category_id')->nullable()->unsigned();
            $table->foreign('article_category_id')->references('id')->on('article_categories');            
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
        Schema::dropIfExists('articles');
    }
}
