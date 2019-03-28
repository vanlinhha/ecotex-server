<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductsApiTest extends TestCase
{
    use MakeProductsTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateProducts()
    {
        $products = $this->fakeProductsData();
        $this->json('POST', '/api/v1/products', $products);

        $this->assertApiResponse($products);
    }

    /**
     * @test
     */
    public function testReadProducts()
    {
        $products = $this->makeProducts();
        $this->json('GET', '/api/v1/products/'.$products->id);

        $this->assertApiResponse($products->toArray());
    }

    /**
     * @test
     */
    public function testUpdateProducts()
    {
        $products = $this->makeProducts();
        $editedProducts = $this->fakeProductsData();

        $this->json('PUT', '/api/v1/products/'.$products->id, $editedProducts);

        $this->assertApiResponse($editedProducts);
    }

    /**
     * @test
     */
    public function testDeleteProducts()
    {
        $products = $this->makeProducts();
        $this->json('DELETE', '/api/v1/products/'.$products->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/products/'.$products->id);

        $this->assertResponseStatus(404);
    }
}
