<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('name');
            $table->string('business_name')->nullable();
            $table->string('address')->nullable();
            $table->integer('neighborhood_id')->nullable()->unsigned();
            $table->foreign('neighborhood_id')->references('id')->on('neighborhoods');
            $table->integer('town_id')->nullable()->unsigned();
            $table->foreign('town_id')->references('id')->on('towns');
            $table->integer('district_id')->nullable()->unsigned();
            $table->foreign('district_id')->references('id')->on('districts');
            $table->integer('province_id')->nullable()->unsigned();
            $table->foreign('province_id')->references('id')->on('provinces');
            $table->integer('country_id')->nullable()->unsigned();
            $table->foreign('country_id')->references('id')->on('countries');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('comments')->nullable();            
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
        Schema::dropIfExists('suppliers');
    }
}
