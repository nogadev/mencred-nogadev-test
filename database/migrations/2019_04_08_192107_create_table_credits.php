<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCredits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->integer('seller_id')->unsigned();
            $table->foreign('seller_id')->references('id')->on('sellers');
            $table->integer('delivery_id')->unsigned();
            $table->foreign('delivery_id')->references('id')->on('deliveries');
            $table->integer('store_id')->unsigned();
            $table->foreign('store_id')->references('id')->on('stores');
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('status');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->tinyInteger('guarantee')->nullable();
            $table->tinyInteger('according')->nullable();
            $table->tinyInteger('have_card')->nullable();

            $table->date('created_date');
            $table->date('guarantee_date')->nullable();
            $table->date('card_date')->nullable();
            $table->date('confirm_date')->nullable();
            $table->date('init_date')->nullable();

            $table->decimal('fee_quantity', 10, 2)->nullable();
            $table->decimal('fee_amount',10,2)->nullable();
            $table->decimal('initial_payment', 10,2)->nullable();
            $table->decimal('total_amount', 10,2)->nullable();
            $table->decimal('unification', 10,2)->nullable();

            $table->string('observation',255)->nullable();

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
        Schema::dropIfExists('credits');
    }
}
