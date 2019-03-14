<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductPostsApiTest extends TestCase
{
    use MakeProductPostsTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateProductPosts()
    {
        $productPosts = $this->fakeProductPostsData();
        $this->json('POST', '/api/v1/productPosts', $productPosts);

        $this->assertApiResponse($productPosts);
    }

    /**
     * @test
     */
    public function testReadProductPosts()
    {
        $productPosts = $this->makeProductPosts();
        $this->json('GET', '/api/v1/productPosts/'.$productPosts->id);

        $this->assertApiResponse($productPosts->toArray());
    }

    /**
     * @test
     */
    public function testUpdateProductPosts()
    {
        $productPosts = $this->makeProductPosts();
        $editedProductPosts = $this->fakeProductPostsData();

        $this->json('PUT', '/api/v1/productPosts/'.$productPosts->id, $editedProductPosts);

        $this->assertApiResponse($editedProductPosts);
    }

    /**
     * @test
     */
    public function testDeleteProductPosts()
    {
        $productPosts = $this->makeProductPosts();
        $this->json('DELETE', '/api/v1/productPosts/'.$productPosts->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/productPosts/'.$productPosts->id);

        $this->assertResponseStatus(404);
    }
}
