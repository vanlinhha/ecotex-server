<?php

use Faker\Factory as Faker;
use App\Models\MainSegments;
use App\Repositories\MainSegmentsRepository;

trait MakeMainSegmentsTrait
{
    /**
     * Create fake instance of MainSegments and save it in database
     *
     * @param array $mainSegmentsFields
     * @return MainSegments
     */
    public function makeMainSegments($mainSegmentsFields = [])
    {
        /** @var MainSegmentsRepository $mainSegmentsRepo */
        $mainSegmentsRepo = App::make(MainSegmentsRepository::class);
        $theme = $this->fakeMainSegmentsData($mainSegmentsFields);
        return $mainSegmentsRepo->create($theme);
    }

    /**
     * Get fake instance of MainSegments
     *
     * @param array $mainSegmentsFields
     * @return MainSegments
     */
    public function fakeMainSegments($mainSegmentsFields = [])
    {
        return new MainSegments($this->fakeMainSegmentsData($mainSegmentsFields));
    }

    /**
     * Get fake data of MainSegments
     *
     * @param array $postFields
     * @return array
     */
    public function fakeMainSegmentsData($mainSegmentsFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'user_id' => $fake->randomDigitNotNull,
            'segment_id' => $fake->randomDigitNotNull,
            'percent' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $mainSegmentsFields);
    }
}
