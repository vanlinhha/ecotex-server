<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateResponsesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_post_id');
            $table->integer('owner_id');
            $table->integer('accepted_quantity');
            $table->string('suggest_quantity')->nullable();
            $table->integer('accepted_price');
            $table->string('suggest_price')->nullable();
            $table->integer('accepted_delivery');
            $table->string('suggest_delivery')->nullable();
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
        Schema::drop('responses');
    }
}
