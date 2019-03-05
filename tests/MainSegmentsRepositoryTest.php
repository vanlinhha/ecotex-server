<?php

use App\Models\MainSegmentGroups;
use App\Repositories\MainSegmentGroupsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MainSegmentGroupsRepositoryTest extends TestCase
{
    use MakeMainSegmentGroupsTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var MainSegmentGroupsRepository
     */
    protected $mainSegmentGroupsRepo;

    public function setUp()
    {
        parent::setUp();
        $this->mainSegmentGroupsRepo = App::make(MainSegmentGroupsRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateMainSegmentGroups()
    {
        $mainSegmentGroups = $this->fakeMainSegmentGroupsData();
        $createdMainSegmentGroups = $this->mainSegmentGroupsRepo->create($mainSegmentGroups);
        $createdMainSegmentGroups = $createdMainSegmentGroups->toArray();
        $this->assertArrayHasKey('id', $createdMainSegmentGroups);
        $this->assertNotNull($createdMainSegmentGroups['id'], 'Created MainSegmentGroups must have id specified');
        $this->assertNotNull(MainSegmentGroups::find($createdMainSegmentGroups['id']), 'MainSegmentGroups with given id must be in DB');
        $this->assertModelData($mainSegmentGroups, $createdMainSegmentGroups);
    }

    /**
     * @test read
     */
    public function testReadMainSegmentGroups()
    {
        $mainSegmentGroups = $this->makeMainSegmentGroups();
        $dbMainSegmentGroups = $this->mainSegmentGroupsRepo->find($mainSegmentGroups->id);
        $dbMainSegmentGroups = $dbMainSegmentGroups->toArray();
        $this->assertModelData($mainSegmentGroups->toArray(), $dbMainSegmentGroups);
    }

    /**
     * @test update
     */
    public function testUpdateMainSegmentGroups()
    {
        $mainSegmentGroups = $this->makeMainSegmentGroups();
        $fakeMainSegmentGroups = $this->fakeMainSegmentGroupsData();
        $updatedMainSegmentGroups = $this->mainSegmentGroupsRepo->update($fakeMainSegmentGroups, $mainSegmentGroups->id);
        $this->assertModelData($fakeMainSegmentGroups, $updatedMainSegmentGroups->toArray());
        $dbMainSegmentGroups = $this->mainSegmentGroupsRepo->find($mainSegmentGroups->id);
        $this->assertModelData($fakeMainSegmentGroups, $dbMainSegmentGroups->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteMainSegmentGroups()
    {
        $mainSegmentGroups = $this->makeMainSegmentGroups();
        $resp = $this->mainSegmentGroupsRepo->delete($mainSegmentGroups->id);
        $this->assertTrue($resp);
        $this->assertNull(MainSegmentGroups::find($mainSegmentGroups->id), 'MainSegmentGroups should not exist in DB');
    }
}
