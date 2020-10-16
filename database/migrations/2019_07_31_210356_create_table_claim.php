<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableClaim extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claims', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('credit_id')->unsigned();
            $table->foreign('credit_id')->references('id')->on('credits');
            $table->integer('status_id')->unsigned()->nullable();
            $table->foreign('status_id')->references('id')->on('status');
            $table->date('init_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('type',['FALTA DE PAGO','SERVICIO TECNICO','AMBOS','ARMADO DE MUEBLES','CONSTANCIAS DE PAGARE ENTREGADO','REVISITA', 'OTRO'])->default('OTRO');
            $table->longtext('observation');
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
        Schema::dropIfExists('claims');
    }
}
