<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAppliedCVsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applied_c_vs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('job_post_id');
            $table->text('education')->nullable();
            $table->text('experience')->nullable();
            $table->text('skill')->nullable();
            $table->text('foreign_language')->nullable();
            $table->text('other')->nullable();
            $table->timestamps();
//            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('applied_c_vs');
    }
}
