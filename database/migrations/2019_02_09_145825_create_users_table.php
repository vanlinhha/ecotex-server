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
            $table->string('type');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('country');
            $table->string('company_name');
            $table->string('brief_name');
            $table->string('company_address');
            $table->string('website');
            $table->string('description');
            $table->integer('is_paid')->default(0);
            $table->string('address');
            $table->string('identity_card');
            $table->integer('establishment_year');
            $table->integer('business_registration_number');
            $table->string('form_of_ownership');
            $table->integer('number_of_employees');
            $table->double('floor_area');
            $table->double('area_of_factory');
            $table->string('commercial_service_type');
            $table->double('revenue_per_year');
            $table->integer('pieces_per_year');
            $table->string('compliance');
            $table->string('activation_code');
            $table->tinyInteger('is_activated');
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
