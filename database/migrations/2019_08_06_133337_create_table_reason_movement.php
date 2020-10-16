<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableReasonMovement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mov_reasons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->integer('mov_type_id')->unsigned();
            $table->foreign('mov_type_id')->references('id')->on('mov_types');
            $table->boolean('available')->default(1);
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
        Schema::dropIfExists('mov_reasons');
    }
}
