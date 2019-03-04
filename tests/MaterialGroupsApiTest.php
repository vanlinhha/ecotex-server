<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MaterialGroupsApiTest extends TestCase
{
    use MakeMaterialGroupsTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateMaterialGroups()
    {
        $materialGroups = $this->fakeMaterialGroupsData();
        $this->json('POST', '/api/v1/materialGroups', $materialGroups);

        $this->assertApiResponse($materialGroups);
    }

    /**
     * @test
     */
    public function testReadMaterialGroups()
    {
        $materialGroups = $this->makeMaterialGroups();
        $this->json('GET', '/api/v1/materialGroups/'.$materialGroups->id);

        $this->assertApiResponse($materialGroups->toArray());
    }

    /**
     * @test
     */
    public function testUpdateMaterialGroups()
    {
        $materialGroups = $this->makeMaterialGroups();
        $editedMaterialGroups = $this->fakeMaterialGroupsData();

        $this->json('PUT', '/api/v1/materialGroups/'.$materialGroups->id, $editedMaterialGroups);

        $this->assertApiResponse($editedMaterialGroups);
    }

    /**
     * @test
     */
    public function testDeleteMaterialGroups()
    {
        $materialGroups = $this->makeMaterialGroups();
        $this->json('DELETE', '/api/v1/materialGroups/'.$materialGroups->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/materialGroups/'.$materialGroups->id);

        $this->assertResponseStatus(404);
    }
}
