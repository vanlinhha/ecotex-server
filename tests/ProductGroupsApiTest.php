<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductGroupsApiTest extends TestCase
{
    use MakeProductGroupsTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateProductGroups()
    {
        $productGroups = $this->fakeProductGroupsData();
        $this->json('POST', '/api/v1/productGroups', $productGroups);

        $this->assertApiResponse($productGroups);
    }

    /**
     * @test
     */
    public function testReadProductGroups()
    {
        $productGroups = $this->makeProductGroups();
        $this->json('GET', '/api/v1/productGroups/'.$productGroups->id);

        $this->assertApiResponse($productGroups->toArray());
    }

    /**
     * @test
     */
    public function testUpdateProductGroups()
    {
        $productGroups = $this->makeProductGroups();
        $editedProductGroups = $this->fakeProductGroupsData();

        $this->json('PUT', '/api/v1/productGroups/'.$productGroups->id, $editedProductGroups);

        $this->assertApiResponse($editedProductGroups);
    }

    /**
     * @test
     */
    public function testDeleteProductGroups()
    {
        $productGroups = $this->makeProductGroups();
        $this->json('DELETE', '/api/v1/productGroups/'.$productGroups->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/productGroups/'.$productGroups->id);

        $this->assertResponseStatus(404);
    }
}
