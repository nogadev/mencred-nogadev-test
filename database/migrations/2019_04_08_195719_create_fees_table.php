<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('credit_id')->unsigned();
            $table->foreign('credit_id')->references('id')->on('credits');
            $table->integer('route_id')->unsigned();
            $table->foreign('route_id')->references('id')->on('routes');
            $table->integer('reason_id')->unsigned()->nullable();
            $table->foreign('reason_id')->references('id')->on('reasons');
            
            $table->integer('number')->nullable();

            $table->date('paid_date')->nullable();

            $table->decimal('payment_amount',10,2);
            $table->decimal('paid_amount', 10,2);

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
        Schema::dropIfExists('fees');
    }
}
