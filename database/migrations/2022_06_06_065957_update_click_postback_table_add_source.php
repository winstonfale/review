<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateClickPostbackTableAddSource extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('click_postbacks', function (Blueprint $table) {
            $table->string('pagesource')->nullable();
            $table->string('device')->nullable();
            $table->string('browser')->nullable();
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
            $table->dropColumn('pagesource');
            $table->dropColumn('device');
            $table->dropColumn('browser');
        });
    }
}