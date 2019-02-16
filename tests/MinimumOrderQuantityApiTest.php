<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MinimumOrderQuantityApiTest extends TestCase
{
    use MakeMinimumOrderQuantityTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateMinimumOrderQuantity()
    {
        $minimumOrderQuantity = $this->fakeMinimumOrderQuantityData();
        $this->json('POST', '/api/v1/minimumOrderQuantities', $minimumOrderQuantity);

        $this->assertApiResponse($minimumOrderQuantity);
    }

    /**
     * @test
     */
    public function testReadMinimumOrderQuantity()
    {
        $minimumOrderQuantity = $this->makeMinimumOrderQuantity();
        $this->json('GET', '/api/v1/minimumOrderQuantities/'.$minimumOrderQuantity->id);

        $this->assertApiResponse($minimumOrderQuantity->toArray());
    }

    /**
     * @test
     */
    public function testUpdateMinimumOrderQuantity()
    {
        $minimumOrderQuantity = $this->makeMinimumOrderQuantity();
        $editedMinimumOrderQuantity = $this->fakeMinimumOrderQuantityData();

        $this->json('PUT', '/api/v1/minimumOrderQuantities/'.$minimumOrderQuantity->id, $editedMinimumOrderQuantity);

        $this->assertApiResponse($editedMinimumOrderQuantity);
    }

    /**
     * @test
     */
    public function testDeleteMinimumOrderQuantity()
    {
        $minimumOrderQuantity = $this->makeMinimumOrderQuantity();
        $this->json('DELETE', '/api/v1/minimumOrderQuantities/'.$minimumOrderQuantity->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/minimumOrderQuantities/'.$minimumOrderQuantity->id);

        $this->assertResponseStatus(404);
    }
}
