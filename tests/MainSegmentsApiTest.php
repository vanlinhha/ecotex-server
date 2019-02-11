<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MainSegmentsApiTest extends TestCase
{
    use MakeMainSegmentsTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateMainSegments()
    {
        $mainSegments = $this->fakeMainSegmentsData();
        $this->json('POST', '/api/v1/mainSegments', $mainSegments);

        $this->assertApiResponse($mainSegments);
    }

    /**
     * @test
     */
    public function testReadMainSegments()
    {
        $mainSegments = $this->makeMainSegments();
        $this->json('GET', '/api/v1/mainSegments/'.$mainSegments->id);

        $this->assertApiResponse($mainSegments->toArray());
    }

    /**
     * @test
     */
    public function testUpdateMainSegments()
    {
        $mainSegments = $this->makeMainSegments();
        $editedMainSegments = $this->fakeMainSegmentsData();

        $this->json('PUT', '/api/v1/mainSegments/'.$mainSegments->id, $editedMainSegments);

        $this->assertApiResponse($editedMainSegments);
    }

    /**
     * @test
     */
    public function testDeleteMainSegments()
    {
        $mainSegments = $this->makeMainSegments();
        $this->json('DELETE', '/api/v1/mainSegments/'.$mainSegments->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/mainSegments/'.$mainSegments->id);

        $this->assertResponseStatus(404);
    }
}
