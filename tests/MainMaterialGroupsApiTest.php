<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MainMaterialGroupsApiTest extends TestCase
{
    use MakeMainMaterialGroupsTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateMainMaterialGroups()
    {
        $mainMaterialGroups = $this->fakeMainMaterialGroupsData();
        $this->json('POST', '/api/v1/mainMaterialGroups', $mainMaterialGroups);

        $this->assertApiResponse($mainMaterialGroups);
    }

    /**
     * @test
     */
    public function testReadMainMaterialGroups()
    {
        $mainMaterialGroups = $this->makeMainMaterialGroups();
        $this->json('GET', '/api/v1/mainMaterialGroups/'.$mainMaterialGroups->id);

        $this->assertApiResponse($mainMaterialGroups->toArray());
    }

    /**
     * @test
     */
    public function testUpdateMainMaterialGroups()
    {
        $mainMaterialGroups = $this->makeMainMaterialGroups();
        $editedMainMaterialGroups = $this->fakeMainMaterialGroupsData();

        $this->json('PUT', '/api/v1/mainMaterialGroups/'.$mainMaterialGroups->id, $editedMainMaterialGroups);

        $this->assertApiResponse($editedMainMaterialGroups);
    }

    /**
     * @test
     */
    public function testDeleteMainMaterialGroups()
    {
        $mainMaterialGroups = $this->makeMainMaterialGroups();
        $this->json('DELETE', '/api/v1/mainMaterialGroups/'.$mainMaterialGroups->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/mainMaterialGroups/'.$mainMaterialGroups->id);

        $this->assertResponseStatus(404);
    }
}
