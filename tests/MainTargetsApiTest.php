<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MainTargetsApiTest extends TestCase
{
    use MakeMainTargetsTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateMainTargets()
    {
        $mainTargets = $this->fakeMainTargetsData();
        $this->json('POST', '/api/v1/mainTargets', $mainTargets);

        $this->assertApiResponse($mainTargets);
    }

    /**
     * @test
     */
    public function testReadMainTargets()
    {
        $mainTargets = $this->makeMainTargets();
        $this->json('GET', '/api/v1/mainTargets/'.$mainTargets->id);

        $this->assertApiResponse($mainTargets->toArray());
    }

    /**
     * @test
     */
    public function testUpdateMainTargets()
    {
        $mainTargets = $this->makeMainTargets();
        $editedMainTargets = $this->fakeMainTargetsData();

        $this->json('PUT', '/api/v1/mainTargets/'.$mainTargets->id, $editedMainTargets);

        $this->assertApiResponse($editedMainTargets);
    }

    /**
     * @test
     */
    public function testDeleteMainTargets()
    {
        $mainTargets = $this->makeMainTargets();
        $this->json('DELETE', '/api/v1/mainTargets/'.$mainTargets->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/mainTargets/'.$mainTargets->id);

        $this->assertResponseStatus(404);
    }
}
