<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SegmentGroupsApiTest extends TestCase
{
    use MakeSegmentGroupsTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateSegmentGroups()
    {
        $segmentGroups = $this->fakeSegmentGroupsData();
        $this->json('POST', '/api/v1/segmentGroups', $segmentGroups);

        $this->assertApiResponse($segmentGroups);
    }

    /**
     * @test
     */
    public function testReadSegmentGroups()
    {
        $segmentGroups = $this->makeSegmentGroups();
        $this->json('GET', '/api/v1/segmentGroups/'.$segmentGroups->id);

        $this->assertApiResponse($segmentGroups->toArray());
    }

    /**
     * @test
     */
    public function testUpdateSegmentGroups()
    {
        $segmentGroups = $this->makeSegmentGroups();
        $editedSegmentGroups = $this->fakeSegmentGroupsData();

        $this->json('PUT', '/api/v1/segmentGroups/'.$segmentGroups->id, $editedSegmentGroups);

        $this->assertApiResponse($editedSegmentGroups);
    }

    /**
     * @test
     */
    public function testDeleteSegmentGroups()
    {
        $segmentGroups = $this->makeSegmentGroups();
        $this->json('DELETE', '/api/v1/segmentGroups/'.$segmentGroups->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/segmentGroups/'.$segmentGroups->id);

        $this->assertResponseStatus(404);
    }
}
