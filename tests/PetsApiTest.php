<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PetsApiTest extends TestCase
{
    use MakePetsTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreatePets()
    {
        $pets = $this->fakePetsData();
        $this->json('POST', '/api/v1/pets', $pets);

        $this->assertApiResponse($pets);
    }

    /**
     * @test
     */
    public function testReadPets()
    {
        $pets = $this->makePets();
        $this->json('GET', '/api/v1/pets/'.$pets->id);

        $this->assertApiResponse($pets->toArray());
    }

    /**
     * @test
     */
    public function testUpdatePets()
    {
        $pets = $this->makePets();
        $editedPets = $this->fakePetsData();

        $this->json('PUT', '/api/v1/pets/'.$pets->id, $editedPets);

        $this->assertApiResponse($editedPets);
    }

    /**
     * @test
     */
    public function testDeletePets()
    {
        $pets = $this->makePets();
        $this->json('DELETE', '/api/v1/pets/'.$pets->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/pets/'.$pets->id);

        $this->assertResponseStatus(404);
    }
}
