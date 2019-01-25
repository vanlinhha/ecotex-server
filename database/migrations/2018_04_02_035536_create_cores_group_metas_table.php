<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoresGroupMetasTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cores_group_metas', function (Blueprint $table)
        {
            $table->bigIncrements('group_meta_id');
            $table->bigInteger('group_id');
            $table->string('group_meta_key', 255);
            $table->longText('group_meta_value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cores_group_metas');
    }

}
