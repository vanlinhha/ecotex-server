<?php

use Faker\Factory as Faker;
use App\Models\MainExportCountries;
use App\Repositories\MainExportCountriesRepository;

trait MakeMainExportCountriesTrait
{
    /**
     * Create fake instance of MainExportCountries and save it in database
     *
     * @param array $mainExportCountriesFields
     * @return MainExportCountries
     */
    public function makeMainExportCountries($mainExportCountriesFields = [])
    {
        /** @var MainExportCountriesRepository $mainExportCountriesRepo */
        $mainExportCountriesRepo = App::make(MainExportCountriesRepository::class);
        $theme = $this->fakeMainExportCountriesData($mainExportCountriesFields);
        return $mainExportCountriesRepo->create($theme);
    }

    /**
     * Get fake instance of MainExportCountries
     *
     * @param array $mainExportCountriesFields
     * @return MainExportCountries
     */
    public function fakeMainExportCountries($mainExportCountriesFields = [])
    {
        return new MainExportCountries($this->fakeMainExportCountriesData($mainExportCountriesFields));
    }

    /**
     * Get fake data of MainExportCountries
     *
     * @param array $postFields
     * @return array
     */
    public function fakeMainExportCountriesData($mainExportCountriesFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'user_id' => $fake->randomDigitNotNull,
            'country_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $mainExportCountriesFields);
    }
}
