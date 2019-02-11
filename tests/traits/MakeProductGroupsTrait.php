<?php

use Faker\Factory as Faker;
use App\Models\ProductGroups;
use App\Repositories\ProductGroupsRepository;

trait MakeProductGroupsTrait
{
    /**
     * Create fake instance of ProductGroups and save it in database
     *
     * @param array $productGroupsFields
     * @return ProductGroups
     */
    public function makeProductGroups($productGroupsFields = [])
    {
        /** @var ProductGroupsRepository $productGroupsRepo */
        $productGroupsRepo = App::make(ProductGroupsRepository::class);
        $theme = $this->fakeProductGroupsData($productGroupsFields);
        return $productGroupsRepo->create($theme);
    }

    /**
     * Get fake instance of ProductGroups
     *
     * @param array $productGroupsFields
     * @return ProductGroups
     */
    public function fakeProductGroups($productGroupsFields = [])
    {
        return new ProductGroups($this->fakeProductGroupsData($productGroupsFields));
    }

    /**
     * Get fake data of ProductGroups
     *
     * @param array $postFields
     * @return array
     */
    public function fakeProductGroupsData($productGroupsFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'parent_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $productGroupsFields);
    }
}
