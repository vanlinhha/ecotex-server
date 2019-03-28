<?php

use Faker\Factory as Faker;
use App\Models\Products;
use App\Repositories\ProductsRepository;

trait MakeProductsTrait
{
    /**
     * Create fake instance of Products and save it in database
     *
     * @param array $productsFields
     * @return Products
     */
    public function makeProducts($productsFields = [])
    {
        /** @var ProductsRepository $productsRepo */
        $productsRepo = App::make(ProductsRepository::class);
        $theme = $this->fakeProductsData($productsFields);
        return $productsRepo->create($theme);
    }

    /**
     * Get fake instance of Products
     *
     * @param array $productsFields
     * @return Products
     */
    public function fakeProducts($productsFields = [])
    {
        return new Products($this->fakeProductsData($productsFields));
    }

    /**
     * Get fake data of Products
     *
     * @param array $postFields
     * @return array
     */
    public function fakeProductsData($productsFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'user_id' => $fake->randomDigitNotNull,
            'product_group_id' => $fake->randomDigitNotNull,
            'name' => $fake->word,
            'is_main_product' => $fake->randomDigitNotNull,
            'minimum_order_quantity_id' => $fake->randomDigitNotNull,
            'lead_time' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $productsFields);
    }
}
