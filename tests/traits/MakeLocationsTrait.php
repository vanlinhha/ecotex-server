<?php

use Faker\Factory as Faker;
use App\Models\Locations;
use App\Repositories\LocationsRepository;

trait MakeLocationsTrait
{
    /**
     * Create fake instance of Locations and save it in database
     *
     * @param array $locationsFields
     * @return Locations
     */
    public function makeLocations($locationsFields = [])
    {
        /** @var LocationsRepository $locationsRepo */
        $locationsRepo = App::make(LocationsRepository::class);
        $theme = $this->fakeLocationsData($locationsFields);
        return $locationsRepo->create($theme);
    }

    /**
     * Get fake instance of Locations
     *
     * @param array $locationsFields
     * @return Locations
     */
    public function fakeLocations($locationsFields = [])
    {
        return new Locations($this->fakeLocationsData($locationsFields));
    }

    /**
     * Get fake data of Locations
     *
     * @param array $postFields
     * @return array
     */
    public function fakeLocationsData($locationsFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'user_id' => $fake->randomDigitNotNull,
            'is_headquater' => $fake->randomDigitNotNull,
            'address' => $fake->word,
            'zip_code' => $fake->word,
            'city' => $fake->word,
            'country_id' => $fake->randomDigitNotNull,
            'phone' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $locationsFields);
    }
}
