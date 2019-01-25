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
//        DB::table('users')->insert([
//            'id'              => '1',
//            'user_name'       => 'admin',
//            'user_login_name' => 'admin',
//            'user_email'      => 'admin@gmail.com',
//            'user_is_admin'   => 1,
//            'password'        => bcrypt('123456'),
//            'user_order'      => 1,
//            'user_status'     => 1,
//            'created_at'      => date('Y-m-d H:i:s')
//        ]);
//        DB::table('cores_user_metas')->insert(
//                [
//                    'user_id'         => '1',
//                    'user_meta_key'   => 'user_address',
//                    'user_meta_value' => '75 Phương Mai - Đống Đa - Hà Nội'
//                ]
//        );
//        DB::table('cores_user_metas')->insert(
//                [
//                    'user_id'         => '1',
//                    'user_meta_key'   => 'user_job_title',
//                    'user_meta_value' => 'Quản trị hệ thống'
//                ]
//        );
//        DB::table('cores_user_metas')->insert(
//                [
//                    'user_id'         => '1',
//                    'user_meta_key'   => 'user_phone',
//                    'user_meta_value' => '0868605579'
//                ]
//        );
//		DB::table('cores_user_metas')->insert(
//                [
//                    'user_id'         => '1',
//                    'user_meta_key'   => 'permit',
//                    'user_meta_value' => 'ou'
//                ]
//        );
//		DB::table('cores_user_metas')->insert(
//                [
//                    'user_id'         => '1',
//                    'user_meta_key'   => 'permit',
//                    'user_meta_value' => 'group'
//                ]
//        );
//		DB::table('cores_user_metas')->insert(
//                [
//                    'user_id'         => '1',
//                    'user_meta_key'   => 'permit',
//                    'user_meta_value' => 'user'
//                ]
//        );
        $this->call(LaratrustSeeder::class);
    }

}
