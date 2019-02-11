<?php

use Faker\Factory as Faker;
use App\Models\MainProductGroups;
use App\Repositories\MainProductGroupsRepository;

trait MakeMainProductGroupsTrait
{
    /**
     * Create fake instance of MainProductGroups and save it in database
     *
     * @param array $mainProductGroupsFields
     * @return MainProductGroups
     */
    public function makeMainProductGroups($mainProductGroupsFields = [])
    {
        /** @var MainProductGroupsRepository $mainProductGroupsRepo */
        $mainProductGroupsRepo = App::make(MainProductGroupsRepository::class);
        $theme = $this->fakeMainProductGroupsData($mainProductGroupsFields);
        return $mainProductGroupsRepo->create($theme);
    }

    /**
     * Get fake instance of MainProductGroups
     *
     * @param array $mainProductGroupsFields
     * @return MainProductGroups
     */
    public function fakeMainProductGroups($mainProductGroupsFields = [])
    {
        return new MainProductGroups($this->fakeMainProductGroupsData($mainProductGroupsFields));
    }

    /**
     * Get fake data of MainProductGroups
     *
     * @param array $postFields
     * @return array
     */
    public function fakeMainProductGroupsData($mainProductGroupsFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'user_id' => $fake->randomDigitNotNull,
            'product_group_id' => $fake->randomDigitNotNull,
            'percent' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $mainProductGroupsFields);
    }
}
