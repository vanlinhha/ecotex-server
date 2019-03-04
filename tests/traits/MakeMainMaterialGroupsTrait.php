<?php

use Faker\Factory as Faker;
use App\Models\MainMaterialGroups;
use App\Repositories\MainMaterialGroupsRepository;

trait MakeMainMaterialGroupsTrait
{
    /**
     * Create fake instance of MainMaterialGroups and save it in database
     *
     * @param array $mainMaterialGroupsFields
     * @return MainMaterialGroups
     */
    public function makeMainMaterialGroups($mainMaterialGroupsFields = [])
    {
        /** @var MainMaterialGroupsRepository $mainMaterialGroupsRepo */
        $mainMaterialGroupsRepo = App::make(MainMaterialGroupsRepository::class);
        $theme = $this->fakeMainMaterialGroupsData($mainMaterialGroupsFields);
        return $mainMaterialGroupsRepo->create($theme);
    }

    /**
     * Get fake instance of MainMaterialGroups
     *
     * @param array $mainMaterialGroupsFields
     * @return MainMaterialGroups
     */
    public function fakeMainMaterialGroups($mainMaterialGroupsFields = [])
    {
        return new MainMaterialGroups($this->fakeMainMaterialGroupsData($mainMaterialGroupsFields));
    }

    /**
     * Get fake data of MainMaterialGroups
     *
     * @param array $postFields
     * @return array
     */
    public function fakeMainMaterialGroupsData($mainMaterialGroupsFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'user_id' => $fake->randomDigitNotNull,
            'material_group_id' => $fake->randomDigitNotNull,
            'percent' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $mainMaterialGroupsFields);
    }
}
