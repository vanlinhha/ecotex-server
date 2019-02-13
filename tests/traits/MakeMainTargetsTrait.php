<?php

use Faker\Factory as Faker;
use App\Models\MainTargets;
use App\Repositories\MainTargetsRepository;

trait MakeMainTargetsTrait
{
    /**
     * Create fake instance of MainTargets and save it in database
     *
     * @param array $mainTargetsFields
     * @return MainTargets
     */
    public function makeMainTargets($mainTargetsFields = [])
    {
        /** @var MainTargetsRepository $mainTargetsRepo */
        $mainTargetsRepo = App::make(MainTargetsRepository::class);
        $theme = $this->fakeMainTargetsData($mainTargetsFields);
        return $mainTargetsRepo->create($theme);
    }

    /**
     * Get fake instance of MainTargets
     *
     * @param array $mainTargetsFields
     * @return MainTargets
     */
    public function fakeMainTargets($mainTargetsFields = [])
    {
        return new MainTargets($this->fakeMainTargetsData($mainTargetsFields));
    }

    /**
     * Get fake data of MainTargets
     *
     * @param array $postFields
     * @return array
     */
    public function fakeMainTargetsData($mainTargetsFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'user_id' => $fake->randomDigitNotNull,
            'target_group_id' => $fake->randomDigitNotNull,
            'percent' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $mainTargetsFields);
    }
}
