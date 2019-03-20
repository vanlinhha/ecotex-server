<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductPostsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_group_id');
            $table->integer('quantity');
            $table->float('target_price');
            $table->text('specification');
            $table->integer('type_id');
            $table->integer('incoterm');
            $table->integer('creator_id');
            $table->text('title');
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
        Schema::drop('product_posts');
    }
}
