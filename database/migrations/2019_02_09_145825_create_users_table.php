<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('password');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('company_name')->nullable();
            $table->string('brief_name')->nullable();
            $table->string('avatar')->nullable();
            $table->string('company_address')->nullable();
            $table->string('website')->nullable();
            $table->string('description')->nullable();
            $table->integer('minimum_order_quantity')->nullable();
            $table->string('address')->nullable();
            $table->string('identity_card')->nullable();
            $table->integer('establishment_year')->nullable();
            $table->integer('business_registration_number')->nullable();
            $table->string('form_of_ownership')->nullable();
            $table->integer('number_of_employees')->nullable();
            $table->double('floor_area')->nullable();
            $table->double('area_of_factory')->nullable();
            $table->string('commercial_service_type')->nullable();
            $table->double('revenue_per_year')->nullable();
            $table->integer('pieces_per_year')->nullable();
            $table->string('compliance')->nullable();
            $table->string('activation_code')->nullable();
            $table->tinyInteger('is_activated')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
