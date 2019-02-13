<?php

use App\Models\MainTargets;
use App\Repositories\MainTargetsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MainTargetsRepositoryTest extends TestCase
{
    use MakeMainTargetsTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var MainTargetsRepository
     */
    protected $mainTargetsRepo;

    public function setUp()
    {
        parent::setUp();
        $this->mainTargetsRepo = App::make(MainTargetsRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateMainTargets()
    {
        $mainTargets = $this->fakeMainTargetsData();
        $createdMainTargets = $this->mainTargetsRepo->create($mainTargets);
        $createdMainTargets = $createdMainTargets->toArray();
        $this->assertArrayHasKey('id', $createdMainTargets);
        $this->assertNotNull($createdMainTargets['id'], 'Created MainTargets must have id specified');
        $this->assertNotNull(MainTargets::find($createdMainTargets['id']), 'MainTargets with given id must be in DB');
        $this->assertModelData($mainTargets, $createdMainTargets);
    }

    /**
     * @test read
     */
    public function testReadMainTargets()
    {
        $mainTargets = $this->makeMainTargets();
        $dbMainTargets = $this->mainTargetsRepo->find($mainTargets->id);
        $dbMainTargets = $dbMainTargets->toArray();
        $this->assertModelData($mainTargets->toArray(), $dbMainTargets);
    }

    /**
     * @test update
     */
    public function testUpdateMainTargets()
    {
        $mainTargets = $this->makeMainTargets();
        $fakeMainTargets = $this->fakeMainTargetsData();
        $updatedMainTargets = $this->mainTargetsRepo->update($fakeMainTargets, $mainTargets->id);
        $this->assertModelData($fakeMainTargets, $updatedMainTargets->toArray());
        $dbMainTargets = $this->mainTargetsRepo->find($mainTargets->id);
        $this->assertModelData($fakeMainTargets, $dbMainTargets->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteMainTargets()
    {
        $mainTargets = $this->makeMainTargets();
        $resp = $this->mainTargetsRepo->delete($mainTargets->id);
        $this->assertTrue($resp);
        $this->assertNull(MainTargets::find($mainTargets->id), 'MainTargets should not exist in DB');
    }
}
