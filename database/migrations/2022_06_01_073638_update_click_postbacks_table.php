<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateClickPostbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('click_postbacks', function (Blueprint $table) {
            $table->string('amount');
            $table->string('currency')->default('EUR');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('click_postbacks', function (Blueprint $table) {
            $table->dropColumn('amount');
            $table->dropColumn('currency');
        });
    }
}