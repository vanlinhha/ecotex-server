<?php

use App\Models\TargetGroups;
use App\Repositories\TargetGroupsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TargetGroupsRepositoryTest extends TestCase
{
    use MakeTargetGroupsTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var TargetGroupsRepository
     */
    protected $targetGroupsRepo;

    public function setUp()
    {
        parent::setUp();
        $this->targetGroupsRepo = App::make(TargetGroupsRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateTargetGroups()
    {
        $targetGroups = $this->fakeTargetGroupsData();
        $createdTargetGroups = $this->targetGroupsRepo->create($targetGroups);
        $createdTargetGroups = $createdTargetGroups->toArray();
        $this->assertArrayHasKey('id', $createdTargetGroups);
        $this->assertNotNull($createdTargetGroups['id'], 'Created TargetGroups must have id specified');
        $this->assertNotNull(TargetGroups::find($createdTargetGroups['id']), 'TargetGroups with given id must be in DB');
        $this->assertModelData($targetGroups, $createdTargetGroups);
    }

    /**
     * @test read
     */
    public function testReadTargetGroups()
    {
        $targetGroups = $this->makeTargetGroups();
        $dbTargetGroups = $this->targetGroupsRepo->find($targetGroups->id);
        $dbTargetGroups = $dbTargetGroups->toArray();
        $this->assertModelData($targetGroups->toArray(), $dbTargetGroups);
    }

    /**
     * @test update
     */
    public function testUpdateTargetGroups()
    {
        $targetGroups = $this->makeTargetGroups();
        $fakeTargetGroups = $this->fakeTargetGroupsData();
        $updatedTargetGroups = $this->targetGroupsRepo->update($fakeTargetGroups, $targetGroups->id);
        $this->assertModelData($fakeTargetGroups, $updatedTargetGroups->toArray());
        $dbTargetGroups = $this->targetGroupsRepo->find($targetGroups->id);
        $this->assertModelData($fakeTargetGroups, $dbTargetGroups->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteTargetGroups()
    {
        $targetGroups = $this->makeTargetGroups();
        $resp = $this->targetGroupsRepo->delete($targetGroups->id);
        $this->assertTrue($resp);
        $this->assertNull(TargetGroups::find($targetGroups->id), 'TargetGroups should not exist in DB');
    }
}
