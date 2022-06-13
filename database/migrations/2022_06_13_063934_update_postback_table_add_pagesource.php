<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePostbackTableAddPagesource extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('click_postbacks', function (Blueprint $table) {
            $table->string('s1')->nullable();
            $table->string('s2')->nullable();
            $table->string('s3')->nullable();
            $table->string('s4')->nullable();
            $table->string('s5')->nullable();

            $table->smallInteger('site_id');
            $table->string('site_source')->nullable();
            $table->string('page_source')->nullable();

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
            $table->dropColumn('s1');
            $table->dropColumn('s2');
            $table->dropColumn('s3');
            $table->dropColumn('s4');
            $table->dropColumn('s5');
            $table->dropColumn('site_id');
            $table->dropColumn('site_source');
            $table->dropColumn('page_source');
        });
    }
}