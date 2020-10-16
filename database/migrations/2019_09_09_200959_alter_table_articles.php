<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->boolean('available')->nullable()->after('state');
            $table->string('trademark')->nullable()->after('available');
            $table->string('model')->nullable()->after('trademark');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function ($table) {
            $table->dropColumn('available');
            $table->dropColumn('trademark');
            $table->dropColumn('model');
        });
    }
}
