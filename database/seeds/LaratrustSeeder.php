<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaratrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $this->command->info('Truncating User, Role and Permission tables');
        $this->truncateLaratrustTables();

        DB::table('users')->insert([
            'first_name'             => $faker->firstName,
            'last_name'              => $faker->lastName,
            'email'                  => 'admin@gmail.com',
            'password'               => bcrypt('123456'),
            'phone'                  => $faker->phoneNumber,
            'country_id'             => random_int(1, 239),
            'company_name'           => $faker->company,
            'brief_name'             => $faker->companySuffix,
            'company_address'        => $faker->address,
            'website'                => $faker->address,
            'description'            => $faker->sentence(),
            'minimum_order_quantity' => random_int(1, 5),
            'is_activated'           => 1,
        ]);


        $config         = config('laratrust_seeder.role_structure');
        $userPermission = config('laratrust_seeder.permission_structure');
        $mapPermission  = collect(config('laratrust_seeder.permissions_map'));

        foreach ($config as $key => $modules) {

            // Create a new role
            $role = \App\Role::create([
                'name'          => $key,
                'is_enterprise' => in_array($key, ['enterprise buyer', 'paid supplier', 'supplier', 'paid manufacture', 'manufacture']) ? 1 : 0,
                'is_paid'       => in_array($key, ['paid supplier', 'paid manufacture']) ? 1 : 0,
                //                'display_name' => ucwords(str_replace('_', ' ', $key)),
                'description'   => ucwords(str_replace('_', ' ', $key))
            ]);

            if ($key == 'manufacture') {
                DB::table('role_types')->insert([
                        [
                            'role_id' => $role->id,
                            'name'    => 'Cut & Make',
                        ],

                        [
                            'role_id' => $role->id,
                            'name'    => 'Partial subcontractor',
                        ],

                        [
                            'role_id' => $role->id,
                            'name'    => 'PLV (job processing)',
                        ],

                        [
                            'role_id' => $role->id,
                            'name'    => 'Ready-made garment manufacture',
                        ],
                    ]

                );
            }

            $permissions = [];

            $this->command->info('Creating Role ' . strtoupper($key));

            // Reading role permission modules
            foreach ($modules as $module => $value) {

                foreach (explode(',', $value) as $p => $perm) {

                    $permissionValue = $mapPermission->get($perm);

                    $permissions[] = \App\Permission::firstOrCreate([
                        'name'        => $permissionValue ? $permissionValue . '-' . $module : $module,
                        //                        'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($module),
                        'description' => ucfirst($permissionValue) . ' ' . ucfirst($module),
                    ])->id;

                    $this->command->info('Creating Permission to ' . $permissionValue . ' for ' . $module);
                }
            }

            // Attach all permissions to the role
            $role->permissions()->sync($permissions);

            $this->command->info("Creating '{$key}' user");

            for ($i = 0; $i < 100; $i++) {
                // Create default user for each role

                if ($i % 2 == 0) {
                    // Create default user for each permission set
                    $user = \App\Models\Users::create([
                        'first_name'             => $faker->firstName,
                        'last_name'              => $faker->lastName,
                        'email'                  => $faker->companyEmail,
                        'password'               => bcrypt('123456'),
                        'phone'                  => $faker->phoneNumber,
                        'country_id'             => random_int(1, 239),
                        'company_name'           => $faker->company,
                        'brief_name'             => $faker->companySuffix,
                        'company_address'        => $faker->address,
                        'website'                => $faker->address,
                        'description'            => $faker->sentence(),
                        'minimum_order_quantity' => random_int(1, 5),

                        //personal
                        'address'                => $faker->address,
                        'identity_card'          => mt_rand(100000000, 999999999),

                    ]);
                } else {
                    // Create default user for each permission set
                    $user = \App\Models\Users::create([
                        'first_name'                   => $faker->firstName,
                        'last_name'                    => $faker->lastName,
                        'email'                        => $faker->companyEmail,
                        'password'                     => bcrypt('123456'),
                        'phone'                        => $faker->phoneNumber,
                        'country_id'                   => random_int(1, 239),
                        'company_name'                 => $faker->company,
                        'brief_name'                   => $faker->companySuffix,
                        'company_address'              => $faker->address,
                        'website'                      => $faker->address,
                        'description'                  => $faker->sentence(),
                        'minimum_order_quantity'       => random_int(1, 5),


                        //enterprise
                        'establishment_year'           => random_int(2000, 2019),
                        'business_registration_number' => $faker->creditCardNumber(),
                        'form_of_ownership'            => '',
                        'number_of_employees'          => random_int(15, 5000),
                        'floor_area'                   => random_int(10000, 100000),
                        'area_of_factory'              => random_int(100000, 5000000),
                        'commercial_service_type'      => str_random(29),
                        'revenue_per_year'             => rand(10000, 2000000),
                        'pieces_per_year'              => random_int(1, 100),
                        'compliance'                   => str_random(6),
                        'activation_code'              => str_random(10),
                        'is_activated'                 => random_int(0, 1),
                    ]);
                }

                DB::table('main_services')->insert([

                        [
                            'user_id'    => $user->id,
                            'service_id' => random_int(1, 3),
                        ],
                        [
                            'user_id'    => $user->id,
                            'service_id' => random_int(1, 3),
                        ]
                    ]

                );

                DB::table('main_export_countries')->insert([

                        [
                            'user_id'    => $user->id,
                            'country_id' => random_int(1, 249),
                            'percent'    => random_int(30, 40)
                        ],
                        [
                            'user_id'    => $user->id,
                            'country_id' => random_int(1, 249),
                            'percent'    => random_int(30, 40)
                        ]
                    ]

                );


                DB::table('main_product_groups')->insert([

                        [
                            'user_id'          => $user->id,
                            'product_group_id' => random_int(1, 5),
                            'percent'          => random_int(30, 40)
                        ]
                    ]

                );

                DB::table('main_material_groups')->insert([

                        [
                            'user_id'           => $user->id,
                            'material_group_id' => random_int(1, 5),
                            'percent'           => random_int(30, 40)
                        ]
                    ]

                );

                DB::table('main_segment_groups')->insert([

                        [
                            'user_id'          => $user->id,
                            'segment_group_id' => random_int(1, 4),
                            'percent'          => random_int(30, 45)
                        ]
                    ]

                );

                DB::table('main_targets')->insert([

                        [
                            'user_id'         => $user->id,
                            'target_group_id' => random_int(1, 4),
                            'percent'         => random_int(30, 40)
                        ]
                    ]

                );

                $user->attachRole($role);
            }
        }

        // Creating user with permissions
        if (!empty($userPermission)) {

            foreach ($userPermission as $key => $modules) {

                foreach ($modules as $module => $value) {
                    for ($i = 0; $i < 30; $i++) {
                        if ($i % 2 == 0) {
                            // Create default user for each permission set
                            $user = \App\Models\Users::create([
                                'first_name'             => $faker->firstName,
                                'last_name'              => $faker->lastName,
                                'email'                  => $faker->companyEmail,
                                'password'               => bcrypt('password'),
                                'phone'                  => $faker->phoneNumber,
                                'country_id'             => random_int(1, 239),
                                'company_name'           => $faker->company,
                                'brief_name'             => $faker->companySuffix,
                                'company_address'        => $faker->address,
                                'website'                => $faker->address,
                                'description'            => $faker->sentence(),
                                'minimum_order_quantity' => random_int(1, 5),

                                //personal
                                'address'                => $faker->address,
                                'identity_card'          => mt_rand(100000000, 999999999),

                            ]);
                        } else {
                            // Create default user for each permission set
                            $user = \App\Models\Users::create([
                                'first_name'                   => $faker->firstName,
                                'last_name'                    => $faker->lastName,
                                'email'                        => $faker->companyEmail,
                                'password'                     => bcrypt('password'),
                                'phone'                        => $faker->phoneNumber,
                                'country_id'                   => random_int(1, 239),
                                'company_name'                 => $faker->company,
                                'brief_name'                   => $faker->companySuffix,
                                'company_address'              => $faker->address,
                                'website'                      => $faker->address,
                                'description'                  => $faker->sentence(),
                                'minimum_order_quantity'       => random_int(1, 5),

                                //enterprise
                                'establishment_year'           => random_int(2000, 2019),
                                'business_registration_number' => $faker->creditCardNumber(),
                                'form_of_ownership'            => '',
                                'number_of_employees'          => random_int(15, 5000),
                                'floor_area'                   => random_int(10000, 100000),
                                'area_of_factory'              => random_int(100000, 5000000),
                                'commercial_service_type'      => str_random(29),
                                'revenue_per_year'             => rand(10000, 2000000),
                                'pieces_per_year'              => random_int(1, 100),
                                'compliance'                   => str_random(6),
                                'activation_code'              => str_random(10),
                                'is_activated'                 => random_int(0, 1),
                            ]);
                        }

                        DB::table('main_services')->insert([

                                [
                                    'user_id'    => $user->id,
                                    'service_id' => random_int(1, 3),
                                ]
                            ]

                        );

                        DB::table('main_export_countries')->insert([

                                [
                                    'user_id'    => $user->id,
                                    'country_id' => random_int(1, 249),
                                    'percent'    => random_int(30, 40)
                                ]
                            ]

                        );

                        DB::table('main_product_groups')->insert([

                                [
                                    'user_id'          => $user->id,
                                    'product_group_id' => random_int(1, 5),
                                    'percent'          => random_int(30, 40)
                                ]
                            ]

                        );

                        DB::table('main_segment_groups')->insert([

                                [
                                    'user_id'          => $user->id,
                                    'segment_group_id' => random_int(1, 4),
                                    'percent'          => random_int(30, 40)
                                ]
                            ]

                        );


                        DB::table('main_targets')->insert([

                                [
                                    'user_id'         => $user->id,
                                    'target_group_id' => random_int(1, 4),
                                    'percent'         => random_int(30, 40)
                                ]
                            ]

                        );

                    }


                    $permissions = [];

                    foreach (explode(',', $value) as $p => $perm) {

                        $permissionValue = $mapPermission->get($perm);

                        $permissions[] = \App\Permission::firstOrCreate([
                            'name'        => $permissionValue ? $permissionValue . '-' . $module : $module,
                            //                            'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($module),
                            'description' => ucfirst($permissionValue) . ' ' . ucfirst($module),
                        ])->id;

                        $this->command->info('Creating Permission to ' . $permissionValue . ' for ' . $module);
                    }

                }

                // Attach all permissions to the user
                $user->permissions()->sync($permissions);
            }
        }

        \App\Models\Users::find(1)->attachRole(1);

    }

    /**
     * Truncates all the laratrust tables and the users table
     *
     * @return    void
     */
    public function truncateLaratrustTables()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('permission_role')->truncate();
        DB::table('permission_user')->truncate();
        DB::table('role_user')->truncate();
        \App\Models\Users::truncate();
        \App\Role::truncate();
        \App\Permission::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
