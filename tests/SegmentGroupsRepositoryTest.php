<?php

use App\Models\SegmentGroups;
use App\Repositories\SegmentGroupsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SegmentGroupsRepositoryTest extends TestCase
{
    use MakeSegmentGroupsTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var SegmentGroupsRepository
     */
    protected $segmentGroupsRepo;

    public function setUp()
    {
        parent::setUp();
        $this->segmentGroupsRepo = App::make(SegmentGroupsRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateSegmentGroups()
    {
        $segmentGroups = $this->fakeSegmentGroupsData();
        $createdSegmentGroups = $this->segmentGroupsRepo->create($segmentGroups);
        $createdSegmentGroups = $createdSegmentGroups->toArray();
        $this->assertArrayHasKey('id', $createdSegmentGroups);
        $this->assertNotNull($createdSegmentGroups['id'], 'Created SegmentGroups must have id specified');
        $this->assertNotNull(SegmentGroups::find($createdSegmentGroups['id']), 'SegmentGroups with given id must be in DB');
        $this->assertModelData($segmentGroups, $createdSegmentGroups);
    }

    /**
     * @test read
     */
    public function testReadSegmentGroups()
    {
        $segmentGroups = $this->makeSegmentGroups();
        $dbSegmentGroups = $this->segmentGroupsRepo->find($segmentGroups->id);
        $dbSegmentGroups = $dbSegmentGroups->toArray();
        $this->assertModelData($segmentGroups->toArray(), $dbSegmentGroups);
    }

    /**
     * @test update
     */
    public function testUpdateSegmentGroups()
    {
        $segmentGroups = $this->makeSegmentGroups();
        $fakeSegmentGroups = $this->fakeSegmentGroupsData();
        $updatedSegmentGroups = $this->segmentGroupsRepo->update($fakeSegmentGroups, $segmentGroups->id);
        $this->assertModelData($fakeSegmentGroups, $updatedSegmentGroups->toArray());
        $dbSegmentGroups = $this->segmentGroupsRepo->find($segmentGroups->id);
        $this->assertModelData($fakeSegmentGroups, $dbSegmentGroups->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteSegmentGroups()
    {
        $segmentGroups = $this->makeSegmentGroups();
        $resp = $this->segmentGroupsRepo->delete($segmentGroups->id);
        $this->assertTrue($resp);
        $this->assertNull(SegmentGroups::find($segmentGroups->id), 'SegmentGroups should not exist in DB');
    }
}
