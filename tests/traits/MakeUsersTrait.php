<?php

use Faker\Factory as Faker;
use App\Models\Users;
use App\Repositories\UsersRepository;

trait MakeUsersTrait
{
    /**
     * Create fake instance of Users and save it in database
     *
     * @param array $usersFields
     * @return Users
     */
    public function makeUsers($usersFields = [])
    {
        /** @var UsersRepository $usersRepo */
        $usersRepo = App::make(UsersRepository::class);
        $theme = $this->fakeUsersData($usersFields);
        return $usersRepo->create($theme);
    }

    /**
     * Get fake instance of Users
     *
     * @param array $usersFields
     * @return Users
     */
    public function fakeUsers($usersFields = [])
    {
        return new Users($this->fakeUsersData($usersFields));
    }

    /**
     * Get fake data of Users
     *
     * @param array $postFields
     * @return array
     */
    public function fakeUsersData($usersFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'email' => $fake->word,
            'password' => $fake->word,
            'type' => $fake->word,
            'first_name' => $fake->word,
            'last_name' => $fake->word,
            'phone' => $fake->word,
            'country_id' => $fake->word,
            'company_name' => $fake->word,
            'brief_name' => $fake->word,
            'company_address' => $fake->word,
            'website' => $fake->word,
            'description' => $fake->word,
            'is_paid' => $fake->randomDigitNotNull,
            'address' => $fake->word,
            'identity_card' => $fake->word,
            'establishment_year' => $fake->randomDigitNotNull,
            'business_registration_number' => $fake->randomDigitNotNull,
            'form_of_ownership' => $fake->word,
            'number_of_employees' => $fake->randomDigitNotNull,
            'floor_area' => $fake->word,
            'area_of_factory' => $fake->word,
            'commercial_service_type' => $fake->word,
            'revenue_per_year' => $fake->word,
            'pieces_per_year' => $fake->randomDigitNotNull,
            'compliance' => $fake->word,
            'activation_code' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $usersFields);
    }
}
