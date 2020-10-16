<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buys', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->integer('supplier_id')->nullable()->unsigned();
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->date('date');
            $table->integer('voucher_type_id')->unsigned();
            $table->foreign('voucher_type_id')->references('id')->on('voucher_types');
            $table->string('subsidiary_number');
            $table->string('voucher_number');
            for ($i=1; $i <= 5; $i++) { 
                $table->decimal('net_'.$i, 9, 2)->nullable();
                $table->decimal('tax_percentage_'.$i, 5, 2)->nullable();
                $table->decimal('tax_'.$i, 9, 2)->nullable();
            }
            $table->decimal('net_not_taxed', 9, 2)->nullable();
            $table->decimal('net_exempt', 9, 2)->nullable();
            $table->decimal('perception_gain_base', 9, 2)->nullable();
            $table->decimal('perception_gain_percentage', 5, 2)->nullable();            
            $table->decimal('perception_gain', 9, 2)->nullable();
            $table->decimal('perception_iibb_base', 9, 2)->nullable();
            $table->decimal('perception_iibb_percentage', 5, 2)->nullable();            
            $table->decimal('perception_iibb', 9, 2)->nullable();
            $table->decimal('perception_iva_base', 9, 2)->nullable();
            $table->decimal('perception_iva_percentage', 5, 2)->nullable();            
            $table->decimal('perception_iva', 9, 2)->nullable();
            $table->decimal('internal_taxes_base', 9, 2)->nullable();
            $table->decimal('internal_taxes_percentage', 5, 2)->nullable();            
            $table->decimal('internal_taxes', 9, 2)->nullable();
            $table->decimal('municipal_taxes_base', 9, 2)->nullable();
            $table->decimal('municipal_taxes_percentage', 5, 2)->nullable();            
            $table->decimal('municipal_taxes', 9, 2)->nullable();
            $table->decimal('bonus_percentage', 5, 2)->nullable();            
            $table->decimal('bonus', 9, 2)->nullable();            
            $table->decimal('total', 9, 2);
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
        Schema::dropIfExists('buys');
    }
}
