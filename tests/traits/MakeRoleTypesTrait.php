<?php

use Faker\Factory as Faker;
use App\Models\RoleTypes;
use App\Repositories\RoleTypesRepository;

trait MakeRoleTypesTrait
{
    /**
     * Create fake instance of RoleTypes and save it in database
     *
     * @param array $roleTypesFields
     * @return RoleTypes
     */
    public function makeRoleTypes($roleTypesFields = [])
    {
        /** @var RoleTypesRepository $roleTypesRepo */
        $roleTypesRepo = App::make(RoleTypesRepository::class);
        $theme = $this->fakeRoleTypesData($roleTypesFields);
        return $roleTypesRepo->create($theme);
    }

    /**
     * Get fake instance of RoleTypes
     *
     * @param array $roleTypesFields
     * @return RoleTypes
     */
    public function fakeRoleTypes($roleTypesFields = [])
    {
        return new RoleTypes($this->fakeRoleTypesData($roleTypesFields));
    }

    /**
     * Get fake data of RoleTypes
     *
     * @param array $postFields
     * @return array
     */
    public function fakeRoleTypesData($roleTypesFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'role_id' => $fake->randomDigitNotNull,
            'name' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $roleTypesFields);
    }
}
