<?php

use App\Models\MainProductGroups;
use App\Repositories\MainProductGroupsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MainProductGroupsRepositoryTest extends TestCase
{
    use MakeMainProductGroupsTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var MainProductGroupsRepository
     */
    protected $mainProductGroupsRepo;

    public function setUp()
    {
        parent::setUp();
        $this->mainProductGroupsRepo = App::make(MainProductGroupsRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateMainProductGroups()
    {
        $mainProductGroups = $this->fakeMainProductGroupsData();
        $createdMainProductGroups = $this->mainProductGroupsRepo->create($mainProductGroups);
        $createdMainProductGroups = $createdMainProductGroups->toArray();
        $this->assertArrayHasKey('id', $createdMainProductGroups);
        $this->assertNotNull($createdMainProductGroups['id'], 'Created MainProductGroups must have id specified');
        $this->assertNotNull(MainProductGroups::find($createdMainProductGroups['id']), 'MainProductGroups with given id must be in DB');
        $this->assertModelData($mainProductGroups, $createdMainProductGroups);
    }

    /**
     * @test read
     */
    public function testReadMainProductGroups()
    {
        $mainProductGroups = $this->makeMainProductGroups();
        $dbMainProductGroups = $this->mainProductGroupsRepo->find($mainProductGroups->id);
        $dbMainProductGroups = $dbMainProductGroups->toArray();
        $this->assertModelData($mainProductGroups->toArray(), $dbMainProductGroups);
    }

    /**
     * @test update
     */
    public function testUpdateMainProductGroups()
    {
        $mainProductGroups = $this->makeMainProductGroups();
        $fakeMainProductGroups = $this->fakeMainProductGroupsData();
        $updatedMainProductGroups = $this->mainProductGroupsRepo->update($fakeMainProductGroups, $mainProductGroups->id);
        $this->assertModelData($fakeMainProductGroups, $updatedMainProductGroups->toArray());
        $dbMainProductGroups = $this->mainProductGroupsRepo->find($mainProductGroups->id);
        $this->assertModelData($fakeMainProductGroups, $dbMainProductGroups->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteMainProductGroups()
    {
        $mainProductGroups = $this->makeMainProductGroups();
        $resp = $this->mainProductGroupsRepo->delete($mainProductGroups->id);
        $this->assertTrue($resp);
        $this->assertNull(MainProductGroups::find($mainProductGroups->id), 'MainProductGroups should not exist in DB');
    }
}
