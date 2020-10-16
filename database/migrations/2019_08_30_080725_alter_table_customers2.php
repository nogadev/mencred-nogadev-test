<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableCustomers2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->smallInteger('sequence_order')->unsigned()->default(0);
            $table->integer('visitday_id')->unsigned()->nullable();
            $table->foreign('visitday_id')->references('id')->on('visit_days');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function ($table) {
            $table->dropColumn('sequence_order');
            $table->dropForeign(['visitday_id']);
            $table->dropColumn('visitday_id');
        });
    }
}
