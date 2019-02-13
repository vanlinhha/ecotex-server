<?php

use App\Models\RoleTypes;
use App\Repositories\RoleTypesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoleTypesRepositoryTest extends TestCase
{
    use MakeRoleTypesTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var RoleTypesRepository
     */
    protected $roleTypesRepo;

    public function setUp()
    {
        parent::setUp();
        $this->roleTypesRepo = App::make(RoleTypesRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateRoleTypes()
    {
        $roleTypes = $this->fakeRoleTypesData();
        $createdRoleTypes = $this->roleTypesRepo->create($roleTypes);
        $createdRoleTypes = $createdRoleTypes->toArray();
        $this->assertArrayHasKey('id', $createdRoleTypes);
        $this->assertNotNull($createdRoleTypes['id'], 'Created RoleTypes must have id specified');
        $this->assertNotNull(RoleTypes::find($createdRoleTypes['id']), 'RoleTypes with given id must be in DB');
        $this->assertModelData($roleTypes, $createdRoleTypes);
    }

    /**
     * @test read
     */
    public function testReadRoleTypes()
    {
        $roleTypes = $this->makeRoleTypes();
        $dbRoleTypes = $this->roleTypesRepo->find($roleTypes->id);
        $dbRoleTypes = $dbRoleTypes->toArray();
        $this->assertModelData($roleTypes->toArray(), $dbRoleTypes);
    }

    /**
     * @test update
     */
    public function testUpdateRoleTypes()
    {
        $roleTypes = $this->makeRoleTypes();
        $fakeRoleTypes = $this->fakeRoleTypesData();
        $updatedRoleTypes = $this->roleTypesRepo->update($fakeRoleTypes, $roleTypes->id);
        $this->assertModelData($fakeRoleTypes, $updatedRoleTypes->toArray());
        $dbRoleTypes = $this->roleTypesRepo->find($roleTypes->id);
        $this->assertModelData($fakeRoleTypes, $dbRoleTypes->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteRoleTypes()
    {
        $roleTypes = $this->makeRoleTypes();
        $resp = $this->roleTypesRepo->delete($roleTypes->id);
        $this->assertTrue($resp);
        $this->assertNull(RoleTypes::find($roleTypes->id), 'RoleTypes should not exist in DB');
    }
}
