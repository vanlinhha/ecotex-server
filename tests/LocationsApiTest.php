<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LocationsApiTest extends TestCase
{
    use MakeLocationsTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateLocations()
    {
        $locations = $this->fakeLocationsData();
        $this->json('POST', '/api/v1/locations', $locations);

        $this->assertApiResponse($locations);
    }

    /**
     * @test
     */
    public function testReadLocations()
    {
        $locations = $this->makeLocations();
        $this->json('GET', '/api/v1/locations/'.$locations->id);

        $this->assertApiResponse($locations->toArray());
    }

    /**
     * @test
     */
    public function testUpdateLocations()
    {
        $locations = $this->makeLocations();
        $editedLocations = $this->fakeLocationsData();

        $this->json('PUT', '/api/v1/locations/'.$locations->id, $editedLocations);

        $this->assertApiResponse($editedLocations);
    }

    /**
     * @test
     */
    public function testDeleteLocations()
    {
        $locations = $this->makeLocations();
        $this->json('DELETE', '/api/v1/locations/'.$locations->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/locations/'.$locations->id);

        $this->assertResponseStatus(404);
    }
}
