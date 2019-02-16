<?php

use Faker\Factory as Faker;
use App\Models\MinimumOrderQuantity;
use App\Repositories\MinimumOrderQuantityRepository;

trait MakeMinimumOrderQuantityTrait
{
    /**
     * Create fake instance of MinimumOrderQuantity and save it in database
     *
     * @param array $minimumOrderQuantityFields
     * @return MinimumOrderQuantity
     */
    public function makeMinimumOrderQuantity($minimumOrderQuantityFields = [])
    {
        /** @var MinimumOrderQuantityRepository $minimumOrderQuantityRepo */
        $minimumOrderQuantityRepo = App::make(MinimumOrderQuantityRepository::class);
        $theme = $this->fakeMinimumOrderQuantityData($minimumOrderQuantityFields);
        return $minimumOrderQuantityRepo->create($theme);
    }

    /**
     * Get fake instance of MinimumOrderQuantity
     *
     * @param array $minimumOrderQuantityFields
     * @return MinimumOrderQuantity
     */
    public function fakeMinimumOrderQuantity($minimumOrderQuantityFields = [])
    {
        return new MinimumOrderQuantity($this->fakeMinimumOrderQuantityData($minimumOrderQuantityFields));
    }

    /**
     * Get fake data of MinimumOrderQuantity
     *
     * @param array $postFields
     * @return array
     */
    public function fakeMinimumOrderQuantityData($minimumOrderQuantityFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $minimumOrderQuantityFields);
    }
}
