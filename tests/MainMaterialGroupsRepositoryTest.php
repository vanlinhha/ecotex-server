<?php

use App\Models\MainMaterialGroups;
use App\Repositories\MainMaterialGroupsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MainMaterialGroupsRepositoryTest extends TestCase
{
    use MakeMainMaterialGroupsTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var MainMaterialGroupsRepository
     */
    protected $mainMaterialGroupsRepo;

    public function setUp()
    {
        parent::setUp();
        $this->mainMaterialGroupsRepo = App::make(MainMaterialGroupsRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateMainMaterialGroups()
    {
        $mainMaterialGroups = $this->fakeMainMaterialGroupsData();
        $createdMainMaterialGroups = $this->mainMaterialGroupsRepo->create($mainMaterialGroups);
        $createdMainMaterialGroups = $createdMainMaterialGroups->toArray();
        $this->assertArrayHasKey('id', $createdMainMaterialGroups);
        $this->assertNotNull($createdMainMaterialGroups['id'], 'Created MainMaterialGroups must have id specified');
        $this->assertNotNull(MainMaterialGroups::find($createdMainMaterialGroups['id']), 'MainMaterialGroups with given id must be in DB');
        $this->assertModelData($mainMaterialGroups, $createdMainMaterialGroups);
    }

    /**
     * @test read
     */
    public function testReadMainMaterialGroups()
    {
        $mainMaterialGroups = $this->makeMainMaterialGroups();
        $dbMainMaterialGroups = $this->mainMaterialGroupsRepo->find($mainMaterialGroups->id);
        $dbMainMaterialGroups = $dbMainMaterialGroups->toArray();
        $this->assertModelData($mainMaterialGroups->toArray(), $dbMainMaterialGroups);
    }

    /**
     * @test update
     */
    public function testUpdateMainMaterialGroups()
    {
        $mainMaterialGroups = $this->makeMainMaterialGroups();
        $fakeMainMaterialGroups = $this->fakeMainMaterialGroupsData();
        $updatedMainMaterialGroups = $this->mainMaterialGroupsRepo->update($fakeMainMaterialGroups, $mainMaterialGroups->id);
        $this->assertModelData($fakeMainMaterialGroups, $updatedMainMaterialGroups->toArray());
        $dbMainMaterialGroups = $this->mainMaterialGroupsRepo->find($mainMaterialGroups->id);
        $this->assertModelData($fakeMainMaterialGroups, $dbMainMaterialGroups->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteMainMaterialGroups()
    {
        $mainMaterialGroups = $this->makeMainMaterialGroups();
        $resp = $this->mainMaterialGroupsRepo->delete($mainMaterialGroups->id);
        $this->assertTrue($resp);
        $this->assertNull(MainMaterialGroups::find($mainMaterialGroups->id), 'MainMaterialGroups should not exist in DB');
    }
}
