<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoleTypesApiTest extends TestCase
{
    use MakeRoleTypesTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateRoleTypes()
    {
        $roleTypes = $this->fakeRoleTypesData();
        $this->json('POST', '/api/v1/roleTypes', $roleTypes);

        $this->assertApiResponse($roleTypes);
    }

    /**
     * @test
     */
    public function testReadRoleTypes()
    {
        $roleTypes = $this->makeRoleTypes();
        $this->json('GET', '/api/v1/roleTypes/'.$roleTypes->id);

        $this->assertApiResponse($roleTypes->toArray());
    }

    /**
     * @test
     */
    public function testUpdateRoleTypes()
    {
        $roleTypes = $this->makeRoleTypes();
        $editedRoleTypes = $this->fakeRoleTypesData();

        $this->json('PUT', '/api/v1/roleTypes/'.$roleTypes->id, $editedRoleTypes);

        $this->assertApiResponse($editedRoleTypes);
    }

    /**
     * @test
     */
    public function testDeleteRoleTypes()
    {
        $roleTypes = $this->makeRoleTypes();
        $this->json('DELETE', '/api/v1/roleTypes/'.$roleTypes->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/roleTypes/'.$roleTypes->id);

        $this->assertResponseStatus(404);
    }
}
