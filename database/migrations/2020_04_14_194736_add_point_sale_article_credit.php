<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPointSaleArticleCredit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('article_credits', function (Blueprint $table) {            
            $table->integer('point_of_sale_id')->unsigned()->after('company_id');;
            $table->foreign('point_of_sale_id')->references('id')->on('point_of_sales');
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
    }
}
