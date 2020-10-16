<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableCustomersbis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->integer('customer_category_id')->unsigned()->nullable();
            $table->foreign('customer_category_id')->references('id')->on('customer_categories');
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
            $table->dropForeign(['customer_category_id']);
            $table->dropColumn('customer_category_id');
        });
    }
}
