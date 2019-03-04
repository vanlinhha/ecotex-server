<?php

use Faker\Factory as Faker;
use App\Models\MaterialGroups;
use App\Repositories\MaterialGroupsRepository;

trait MakeMaterialGroupsTrait
{
    /**
     * Create fake instance of MaterialGroups and save it in database
     *
     * @param array $materialGroupsFields
     * @return MaterialGroups
     */
    public function makeMaterialGroups($materialGroupsFields = [])
    {
        /** @var MaterialGroupsRepository $materialGroupsRepo */
        $materialGroupsRepo = App::make(MaterialGroupsRepository::class);
        $theme = $this->fakeMaterialGroupsData($materialGroupsFields);
        return $materialGroupsRepo->create($theme);
    }

    /**
     * Get fake instance of MaterialGroups
     *
     * @param array $materialGroupsFields
     * @return MaterialGroups
     */
    public function fakeMaterialGroups($materialGroupsFields = [])
    {
        return new MaterialGroups($this->fakeMaterialGroupsData($materialGroupsFields));
    }

    /**
     * Get fake data of MaterialGroups
     *
     * @param array $postFields
     * @return array
     */
    public function fakeMaterialGroupsData($materialGroupsFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'parent_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $materialGroupsFields);
    }
}
