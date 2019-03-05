<?php

use Faker\Factory as Faker;
use App\Models\MainSegmentGroups;
use App\Repositories\MainSegmentGroupsRepository;

trait MakeMainSegmentGroupsTrait
{
    /**
     * Create fake instance of MainSegmentGroups and save it in database
     *
     * @param array $mainSegmentGroupsFields
     * @return MainSegmentGroups
     */
    public function makeMainSegmentGroups($mainSegmentGroupsFields = [])
    {
        /** @var MainSegmentGroupsRepository $mainSegmentGroupsRepo */
        $mainSegmentGroupsRepo = App::make(MainSegmentGroupsRepository::class);
        $theme = $this->fakeMainSegmentGroupsData($mainSegmentGroupsFields);
        return $mainSegmentGroupsRepo->create($theme);
    }

    /**
     * Get fake instance of MainSegmentGroups
     *
     * @param array $mainSegmentGroupsFields
     * @return MainSegmentGroups
     */
    public function fakeMainSegmentGroups($mainSegmentGroupsFields = [])
    {
        return new MainSegmentGroups($this->fakeMainSegmentGroupsData($mainSegmentGroupsFields));
    }

    /**
     * Get fake data of MainSegmentGroups
     *
     * @param array $postFields
     * @return array
     */
    public function fakeMainSegmentGroupsData($mainSegmentGroupsFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'user_id' => $fake->randomDigitNotNull,
            'segment_group_id' => $fake->randomDigitNotNull,
            'percent' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $mainSegmentGroupsFields);
    }
}
