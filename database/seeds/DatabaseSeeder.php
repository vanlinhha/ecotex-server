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


        DB::table('target_groups')->insert([
                [
                    'name' => 'baby',
                ],

                [
                    'name' => 'kids',
                ],
                [
                    'name' => 'men',
                ],
                [
                    'name' => 'women',
                ]
            ]

        );


        DB::table('segment_groups')->insert([
                [
                    'name' => 'active',
                ],

                [
                    'name' => 'casual',
                ],
                [
                    'name' => 'formal',
                ],
                [
                    'name' => 'workwear',
                ]
            ]

        );

        DB::table('product_groups')->insert([
                [
                    'name'      => 'Áo',
                    'parent_id' => 0
                ],

                [
                    'name'      => 'Quần',
                    'parent_id' => 0
                ],

                [
                    'name'      => 'Váy',
                    'parent_id' => 0
                ],

                [
                    'name'      => 'Đồ lót',
                    'parent_id' => 0
                ],

                [
                    'name'      => 'Vest & jacket',
                    'parent_id' => 0
                ],
                [
                    'name'      => 'Phụ kiện',
                    'parent_id' => 0
                ]
            ]
        );

        DB::table('product_groups')->insert([
                [
                    'name'      => 'Áo thun dài tay',
                    'parent_id' => 1
                ],

                [
                    'name'      => 'Áo len',
                    'parent_id' => 1
                ],

                [
                    'name'      => 'Áo khoác',
                    'parent_id' => 1
                ],

                [
                    'name'      => 'Áo blazer',
                    'parent_id' => 1
                ],

                [
                    'name'      => 'Áo Polo',
                    'parent_id' => 1
                ],
                [
                    'name'      => 'Áo Thun ',
                    'parent_id' => 1
                ]
            ]
        );

        DB::table('product_groups')->insert([
                [
                    'name'      => 'Quần Âu ',
                    'parent_id' => 2
                ],

                [
                    'name'      => 'Quần Kaki',
                    'parent_id' => 2
                ],

                [
                    'name'      => 'Quần Thể thao',
                    'parent_id' => 2
                ],

                [
                    'name'      => 'Quần Short',
                    'parent_id' => 2
                ]
            ]
        );

        DB::table('product_groups')->insert([
                [
                    'name'      => 'Thắt lưng',
                    'parent_id' => 6
                ],

                [
                    'name'      => 'Ví nam',
                    'parent_id' => 6
                ],

                [
                    'name'      => 'Ví nữ ',
                    'parent_id' => 6
                ],

                [
                    'name'      => 'Cà vạt ',
                    'parent_id' => 6
                ]
            ]
        );

        DB::table('material_groups')->insert([
                [
                    'name'      => 'Vải',
                    'parent_id' => 0
                ],

                [
                    'name'      => 'Chỉ',
                    'parent_id' => 0
                ],

                [
                    'name'      => 'Cúc',
                    'parent_id' => 0
                ],

                [
                    'name'      => 'Dây kéo',
                    'parent_id' => 0
                ],

                [
                    'name'      => 'Vật liệu dựng',
                    'parent_id' => 0
                ],
                [
                    'name'      => 'Phụ kiện',
                    'parent_id' => 0
                ]
            ]
        );

        DB::table('material_groups')->insert([
                [
                    'name'      => 'Vải loại 1',
                    'parent_id' => 1
                ],

                [
                    'name'      => 'Vải loại 2',
                    'parent_id' => 1
                ],

                [
                    'name'      => 'Chỉ bông',
                    'parent_id' => 2
                ],

                [
                    'name'      => 'Chỉ tơ tằm',
                    'parent_id' => 2
                ],

                [
                    'name'      => 'Cúc gỗ',
                    'parent_id' => 3
                ],

                [
                    'name'      => 'Cúc nhựa',
                    'parent_id' => 3
                ],
                [
                    'name'      => 'Cúc kim loại',
                    'parent_id' => 3
                ]
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
