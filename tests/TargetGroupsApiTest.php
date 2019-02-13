<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TargetGroupsApiTest extends TestCase
{
    use MakeTargetGroupsTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateTargetGroups()
    {
        $targetGroups = $this->fakeTargetGroupsData();
        $this->json('POST', '/api/v1/targetGroups', $targetGroups);

        $this->assertApiResponse($targetGroups);
    }

    /**
     * @test
     */
    public function testReadTargetGroups()
    {
        $targetGroups = $this->makeTargetGroups();
        $this->json('GET', '/api/v1/targetGroups/'.$targetGroups->id);

        $this->assertApiResponse($targetGroups->toArray());
    }

    /**
     * @test
     */
    public function testUpdateTargetGroups()
    {
        $targetGroups = $this->makeTargetGroups();
        $editedTargetGroups = $this->fakeTargetGroupsData();

        $this->json('PUT', '/api/v1/targetGroups/'.$targetGroups->id, $editedTargetGroups);

        $this->assertApiResponse($editedTargetGroups);
    }

    /**
     * @test
     */
    public function testDeleteTargetGroups()
    {
        $targetGroups = $this->makeTargetGroups();
        $this->json('DELETE', '/api/v1/targetGroups/'.$targetGroups->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/targetGroups/'.$targetGroups->id);

        $this->assertResponseStatus(404);
    }
}
