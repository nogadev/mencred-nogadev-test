<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('customers', function (Blueprint $table) {
            $table->string('email',255);

            $table->integer('commerce_id')->unsigned()->nullable();
            $table->foreign('commerce_id')->references('id')->on('commerces');

            $table->integer('seller_id')->unsigned()->nullable();
            $table->foreign('seller_id')->references('id')->on('sellers');

            $table->string('commercial_address',255)->nullable();
            $table->integer('commercial_district_id')->unsigned()->nullable();
            $table->foreign('commercial_district_id')->references('id')->on('districts');
            $table->integer('commercial_town_id')->unsigned()->nullable();
            $table->foreign('commercial_town_id')->references('id')->on('towns');
            $table->integer('commercial_neighborhood_id')->unsigned()->nullable();
            $table->foreign('commercial_neighborhood_id')->references('id')->on('neighborhoods');
            $table->string('commercial_between',255)->nullable();

            $table->string('personal_address',255)->nullable();
            $table->integer('personal_district_id')->unsigned()->nullable();
            $table->foreign('personal_district_id')->references('id')->on('districts');
            $table->integer('personal_town_id')->unsigned()->nullable();
            $table->foreign('personal_town_id')->references('id')->on('towns');
            $table->integer('personal_neighborhood_id')->unsigned()->nullable();
            $table->foreign('personal_neighborhood_id')->references('id')->on('neighborhoods');
            $table->string('personal_between',255)->nullable();

            $table->string('doc_number',32)->nullable();
            $table->date('birthday')->nullable();

            $table->string('horary', 255)->nullable();
            $table->enum('marital_status',['SIN DATOS','SOLTERO/A','CASADO/A','DIVORCIADO/A','CONCUBINO/A','VIUDO/A'])->nullable();
            $table->string('partner',255)->nullable();

            $table->string('particular_tel',64)->nullable();
            $table->string('comercial_tel',64)->nullable();
            $table->string('contact_tel',64)->nullable();

            $table->string('cuit',32)->nullable();
            //cateogria
            $table->string('contact',255)->nullable();
            $table->integer('kinship_id')->unsigned()->nullable();
            $table->foreign('kinship_id')->references('id')->on('kinships');

            $table->tinyinteger('owner')->nullable();
            $table->date('antiquity')->nullable();

            $table->string('observation',255)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('customers', function ($table) {
            $table->dropForeign(['commerce_id']);
            $table->dropColumn('commerce_id');
            
            $table->dropColumn('commercial_address');
            $table->dropForeign(['commercial_district_id']);
            $table->dropColumn('commercial_district_id');
            $table->dropForeign(['commercial_town_id']);
            $table->dropColumn('commercial_town_id');
            $table->dropForeign(['commercial_neighborhood_id']);
            $table->dropColumn('commercial_neighborhood_id');
            $table->dropColumn('commercial_between');

            $table->dropColumn('personal_address');
            $table->dropForeign(['personal_district_id']);
            $table->dropColumn('personal_district_id');
            $table->dropForeign(['personal_town_id']);
            $table->dropColumn('personal_town_id');
            $table->dropForeign(['personal_neighborhood_id']);
            $table->dropColumn('personal_neighborhood_id');
            $table->dropColumn('personal_between');

            $table->dropColumn('doc_number');
            $table->dropColumn('birthday');
            $table->dropColumn('horary');
            $table->dropColumn('marital_status');
            $table->dropColumn('partner');
            $table->dropColumn('particular_tel');
            $table->dropColumn('contact_tel');
            $table->dropColumn('comercial_tel');
            $table->dropColumn('cuit');
            $table->dropColumn('contact');
            $table->dropColumn('owner');
            $table->dropColumn('antiquity');
            $table->dropColumn('observation');
            $table->dropForeign(['kinship_id']);
            $table->dropColumn('kinship_id');

            $table->dropForeign(['seller_id']);
            $table->dropColumn('seller_id');
        });
    }
}
