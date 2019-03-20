<?php

use Faker\Factory as Faker;
use App\Models\ProductPosts;
use App\Repositories\ProductPostsRepository;

trait MakeProductPostsTrait
{
    /**
     * Create fake instance of ProductPosts and save it in database
     *
     * @param array $productPostsFields
     * @return ProductPosts
     */
    public function makeProductPosts($productPostsFields = [])
    {
        /** @var ProductPostsRepository $productPostsRepo */
        $productPostsRepo = App::make(ProductPostsRepository::class);
        $theme = $this->fakeProductPostsData($productPostsFields);
        return $productPostsRepo->create($theme);
    }

    /**
     * Get fake instance of ProductPosts
     *
     * @param array $productPostsFields
     * @return ProductPosts
     */
    public function fakeProductPosts($productPostsFields = [])
    {
        return new ProductPosts($this->fakeProductPostsData($productPostsFields));
    }

    /**
     * Get fake data of ProductPosts
     *
     * @param array $postFields
     * @return array
     */
    public function fakeProductPostsData($productPostsFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'product_group_id' => $fake->randomDigitNotNull,
            'quantity' => $fake->randomDigitNotNull,
            'target_price' => $fake->randomDigitNotNull,
            'specification' => $fake->text,
            'type_id' => $fake->randomDigitNotNull,
            'incoterm' => $fake->randomDigitNotNull,
            'creator_id' => $fake->randomDigitNotNull,
            'title' => $fake->text,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $productPostsFields);
    }
}
