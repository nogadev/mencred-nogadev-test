<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');
            $table->string('extension');
            $table->integer('reference')->unsigned();
            $table->integer('entity_type_id')->unsigned();
            $table->foreign('entity_type_id')->references('id')->on('entity_types');
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
        Schema::dropIfExists('file_details');
    }
}
