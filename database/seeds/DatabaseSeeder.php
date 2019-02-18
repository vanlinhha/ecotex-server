<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        $faker = Faker\Factory::create();

//target có: baby,kids, men, women,
//segment có : active, casual, formal, workwear
//product group thì có: dresses, fullbody, Jackets & Coats,skirts

        DB::table('target_groups')->insert(
            [
                'name' => 'baby',
            ]
        );
        DB::table('target_groups')->insert(
            [
                'name' => 'kids',
            ]
        );
        DB::table('target_groups')->insert(
            [
                'name' => 'men',
            ]
        );
        DB::table('target_groups')->insert(
            [
                'name' => 'women',
            ]
        );


        DB::table('segment_groups')->insert(
            [
                'name' => 'active',
            ]
        );
        DB::table('segment_groups')->insert(
            [
                'name' => 'casual',
            ]
        );
        DB::table('segment_groups')->insert(
            [
                'name' => 'formal',
            ]
        );
        DB::table('segment_groups')->insert(
            [
                'name' => 'workwear',
            ]
        );


        DB::table('product_groups')->insert(
            [
                'name'      => 'dresses',
                'parent_id' => 0

            ]
        );
        DB::table('product_groups')->insert(
            [
                'name'      => 'casual',
                'parent_id' => 0
            ]
        );
        DB::table('product_groups')->insert(
            [
                'name'      => 'fullbody',
                'parent_id' => 0
            ]
        );
        DB::table('product_groups')->insert(
            [
                'name'      => 'Jackets & Coats',
                'parent_id' => 0
            ]
        );
        DB::table('product_groups')->insert(
            [
                'name'      => 'Skirts',
                'parent_id' => 0
            ]
        );



        DB::table('minimum_order_quantities')->insert(
            [
                'name' => '100 - 500',
            ]
        );
        DB::table('minimum_order_quantities')->insert(
            [
                'name' => '500 - 1000',
            ]
        );
        DB::table('minimum_order_quantities')->insert(
            [
                'name' => '1000 - 5000',
            ]
        );
        DB::table('minimum_order_quantities')->insert(
            [
                'name' => '5000 - 20000',
            ]
        );
        DB::table('minimum_order_quantities')->insert(
            [
                'name' => 'more than 20000',
            ]
        );



//        );
        $this->call(LaratrustSeeder::class);
    }

}
