<?php

use App\Models\MaterialGroups;
use App\Repositories\MaterialGroupsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MaterialGroupsRepositoryTest extends TestCase
{
    use MakeMaterialGroupsTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var MaterialGroupsRepository
     */
    protected $materialGroupsRepo;

    public function setUp()
    {
        parent::setUp();
        $this->materialGroupsRepo = App::make(MaterialGroupsRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateMaterialGroups()
    {
        $materialGroups = $this->fakeMaterialGroupsData();
        $createdMaterialGroups = $this->materialGroupsRepo->create($materialGroups);
        $createdMaterialGroups = $createdMaterialGroups->toArray();
        $this->assertArrayHasKey('id', $createdMaterialGroups);
        $this->assertNotNull($createdMaterialGroups['id'], 'Created MaterialGroups must have id specified');
        $this->assertNotNull(MaterialGroups::find($createdMaterialGroups['id']), 'MaterialGroups with given id must be in DB');
        $this->assertModelData($materialGroups, $createdMaterialGroups);
    }

    /**
     * @test read
     */
    public function testReadMaterialGroups()
    {
        $materialGroups = $this->makeMaterialGroups();
        $dbMaterialGroups = $this->materialGroupsRepo->find($materialGroups->id);
        $dbMaterialGroups = $dbMaterialGroups->toArray();
        $this->assertModelData($materialGroups->toArray(), $dbMaterialGroups);
    }

    /**
     * @test update
     */
    public function testUpdateMaterialGroups()
    {
        $materialGroups = $this->makeMaterialGroups();
        $fakeMaterialGroups = $this->fakeMaterialGroupsData();
        $updatedMaterialGroups = $this->materialGroupsRepo->update($fakeMaterialGroups, $materialGroups->id);
        $this->assertModelData($fakeMaterialGroups, $updatedMaterialGroups->toArray());
        $dbMaterialGroups = $this->materialGroupsRepo->find($materialGroups->id);
        $this->assertModelData($fakeMaterialGroups, $dbMaterialGroups->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteMaterialGroups()
    {
        $materialGroups = $this->makeMaterialGroups();
        $resp = $this->materialGroupsRepo->delete($materialGroups->id);
        $this->assertTrue($resp);
        $this->assertNull(MaterialGroups::find($materialGroups->id), 'MaterialGroups should not exist in DB');
    }
}
