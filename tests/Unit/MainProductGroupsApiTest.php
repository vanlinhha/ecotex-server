<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MainProductGroupsApiTest extends TestCase
{
    use MakeMainProductGroupsTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateMainProductGroups()
    {
        $mainProductGroups = $this->fakeMainProductGroupsData();
        $this->json('POST', '/api/v1/mainProductGroups', $mainProductGroups);

        $this->assertApiResponse($mainProductGroups);
    }

    /**
     * @test
     */
    public function testReadMainProductGroups()
    {
        $mainProductGroups = $this->makeMainProductGroups();
        $this->json('GET', '/api/v1/mainProductGroups/'.$mainProductGroups->id);

        $this->assertApiResponse($mainProductGroups->toArray());
    }

    /**
     * @test
     */
    public function testUpdateMainProductGroups()
    {
        $mainProductGroups = $this->makeMainProductGroups();
        $editedMainProductGroups = $this->fakeMainProductGroupsData();

        $this->json('PUT', '/api/v1/mainProductGroups/'.$mainProductGroups->id, $editedMainProductGroups);

        $this->assertApiResponse($editedMainProductGroups);
    }

    /**
     * @test
     */
    public function testDeleteMainProductGroups()
    {
        $mainProductGroups = $this->makeMainProductGroups();
        $this->json('DELETE', '/api/v1/mainProductGroups/'.$mainProductGroups->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/mainProductGroups/'.$mainProductGroups->id);

        $this->assertResponseStatus(404);
    }
}
