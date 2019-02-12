<?php

use Faker\Factory as Faker;
use App\Models\SegmentGroups;
use App\Repositories\SegmentGroupsRepository;

trait MakeSegmentGroupsTrait
{
    /**
     * Create fake instance of SegmentGroups and save it in database
     *
     * @param array $segmentGroupsFields
     * @return SegmentGroups
     */
    public function makeSegmentGroups($segmentGroupsFields = [])
    {
        /** @var SegmentGroupsRepository $segmentGroupsRepo */
        $segmentGroupsRepo = App::make(SegmentGroupsRepository::class);
        $theme = $this->fakeSegmentGroupsData($segmentGroupsFields);
        return $segmentGroupsRepo->create($theme);
    }

    /**
     * Get fake instance of SegmentGroups
     *
     * @param array $segmentGroupsFields
     * @return SegmentGroups
     */
    public function fakeSegmentGroups($segmentGroupsFields = [])
    {
        return new SegmentGroups($this->fakeSegmentGroupsData($segmentGroupsFields));
    }

    /**
     * Get fake data of SegmentGroups
     *
     * @param array $postFields
     * @return array
     */
    public function fakeSegmentGroupsData($segmentGroupsFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $segmentGroupsFields);
    }
}
