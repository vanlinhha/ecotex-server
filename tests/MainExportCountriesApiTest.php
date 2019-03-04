<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MainExportCountriesApiTest extends TestCase
{
    use MakeMainExportCountriesTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateMainExportCountries()
    {
        $mainExportCountries = $this->fakeMainExportCountriesData();
        $this->json('POST', '/api/v1/mainExportCountries', $mainExportCountries);

        $this->assertApiResponse($mainExportCountries);
    }

    /**
     * @test
     */
    public function testReadMainExportCountries()
    {
        $mainExportCountries = $this->makeMainExportCountries();
        $this->json('GET', '/api/v1/mainExportCountries/'.$mainExportCountries->id);

        $this->assertApiResponse($mainExportCountries->toArray());
    }

    /**
     * @test
     */
    public function testUpdateMainExportCountries()
    {
        $mainExportCountries = $this->makeMainExportCountries();
        $editedMainExportCountries = $this->fakeMainExportCountriesData();

        $this->json('PUT', '/api/v1/mainExportCountries/'.$mainExportCountries->id, $editedMainExportCountries);

        $this->assertApiResponse($editedMainExportCountries);
    }

    /**
     * @test
     */
    public function testDeleteMainExportCountries()
    {
        $mainExportCountries = $this->makeMainExportCountries();
        $this->json('DELETE', '/api/v1/mainExportCountries/'.$mainExportCountries->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/mainExportCountries/'.$mainExportCountries->id);

        $this->assertResponseStatus(404);
    }
}
