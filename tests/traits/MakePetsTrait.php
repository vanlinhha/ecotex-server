<?php

use Faker\Factory as Faker;
use App\Models\Pets;
use App\Repositories\PetsRepository;

trait MakePetsTrait
{
    /**
     * Create fake instance of Pets and save it in database
     *
     * @param array $petsFields
     * @return Pets
     */
    public function makePets($petsFields = [])
    {
        /** @var PetsRepository $petsRepo */
        $petsRepo = App::make(PetsRepository::class);
        $theme = $this->fakePetsData($petsFields);
        return $petsRepo->create($theme);
    }

    /**
     * Get fake instance of Pets
     *
     * @param array $petsFields
     * @return Pets
     */
    public function fakePets($petsFields = [])
    {
        return new Pets($this->fakePetsData($petsFields));
    }

    /**
     * Get fake data of Pets
     *
     * @param array $postFields
     * @return array
     */
    public function fakePetsData($petsFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'category' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $petsFields);
    }
}
