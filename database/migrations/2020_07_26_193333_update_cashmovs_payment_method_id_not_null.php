<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCashmovsPaymentMethodIdNotNull extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('cash_movs', function (Blueprint $table) {
            $table->integer('payment_method_id')->unsigned()->nullable(false)->change();
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down()
    {
        Schema::table('cash_movs', function ($table) {
            $table->dropColumn('payment_method_id');
        });
    }
}
