<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoresUserMetasTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cores_user_metas', function (Blueprint $table)
        {
            $table->increments('user_meta_id');
            $table->bigInteger('user_id');
            $table->string('user_meta_key', 50);
            $table->string('user_meta_value', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cores_user_metas');
    }

}
