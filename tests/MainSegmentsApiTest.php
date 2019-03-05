<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MainSegmentGroupsApiTest extends TestCase
{
    use MakeMainSegmentGroupsTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateMainSegmentGroups()
    {
        $mainSegmentGroups = $this->fakeMainSegmentGroupsData();
        $this->json('POST', '/api/v1/mainSegmentGroups', $mainSegmentGroups);

        $this->assertApiResponse($mainSegmentGroups);
    }

    /**
     * @test
     */
    public function testReadMainSegmentGroups()
    {
        $mainSegmentGroups = $this->makeMainSegmentGroups();
        $this->json('GET', '/api/v1/mainSegmentGroups/'.$mainSegmentGroups->id);

        $this->assertApiResponse($mainSegmentGroups->toArray());
    }

    /**
     * @test
     */
    public function testUpdateMainSegmentGroups()
    {
        $mainSegmentGroups = $this->makeMainSegmentGroups();
        $editedMainSegmentGroups = $this->fakeMainSegmentGroupsData();

        $this->json('PUT', '/api/v1/mainSegmentGroups/'.$mainSegmentGroups->id, $editedMainSegmentGroups);

        $this->assertApiResponse($editedMainSegmentGroups);
    }

    /**
     * @test
     */
    public function testDeleteMainSegmentGroups()
    {
        $mainSegmentGroups = $this->makeMainSegmentGroups();
        $this->json('DELETE', '/api/v1/mainSegmentGroups/'.$mainSegmentGroups->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/mainSegmentGroups/'.$mainSegmentGroups->id);

        $this->assertResponseStatus(404);
    }
}
