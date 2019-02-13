<?php

use Faker\Factory as Faker;
use App\Models\TargetGroups;
use App\Repositories\TargetGroupsRepository;

trait MakeTargetGroupsTrait
{
    /**
     * Create fake instance of TargetGroups and save it in database
     *
     * @param array $targetGroupsFields
     * @return TargetGroups
     */
    public function makeTargetGroups($targetGroupsFields = [])
    {
        /** @var TargetGroupsRepository $targetGroupsRepo */
        $targetGroupsRepo = App::make(TargetGroupsRepository::class);
        $theme = $this->fakeTargetGroupsData($targetGroupsFields);
        return $targetGroupsRepo->create($theme);
    }

    /**
     * Get fake instance of TargetGroups
     *
     * @param array $targetGroupsFields
     * @return TargetGroups
     */
    public function fakeTargetGroups($targetGroupsFields = [])
    {
        return new TargetGroups($this->fakeTargetGroupsData($targetGroupsFields));
    }

    /**
     * Get fake data of TargetGroups
     *
     * @param array $postFields
     * @return array
     */
    public function fakeTargetGroupsData($targetGroupsFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $targetGroupsFields);
    }
}
