<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableSuppliers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->integer('traveler_id')->unsigned()->nullable();
            $table->foreign('traveler_id')->references('id')->on('travelers');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('suppliers', function ($table) {
            $table->dropForeign(['traveler_id']);
            $table->dropColumn('traveler_id');
        });
    }
}
