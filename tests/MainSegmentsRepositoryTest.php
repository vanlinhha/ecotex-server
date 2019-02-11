<?php

use App\Models\MainSegments;
use App\Repositories\MainSegmentsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MainSegmentsRepositoryTest extends TestCase
{
    use MakeMainSegmentsTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var MainSegmentsRepository
     */
    protected $mainSegmentsRepo;

    public function setUp()
    {
        parent::setUp();
        $this->mainSegmentsRepo = App::make(MainSegmentsRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateMainSegments()
    {
        $mainSegments = $this->fakeMainSegmentsData();
        $createdMainSegments = $this->mainSegmentsRepo->create($mainSegments);
        $createdMainSegments = $createdMainSegments->toArray();
        $this->assertArrayHasKey('id', $createdMainSegments);
        $this->assertNotNull($createdMainSegments['id'], 'Created MainSegments must have id specified');
        $this->assertNotNull(MainSegments::find($createdMainSegments['id']), 'MainSegments with given id must be in DB');
        $this->assertModelData($mainSegments, $createdMainSegments);
    }

    /**
     * @test read
     */
    public function testReadMainSegments()
    {
        $mainSegments = $this->makeMainSegments();
        $dbMainSegments = $this->mainSegmentsRepo->find($mainSegments->id);
        $dbMainSegments = $dbMainSegments->toArray();
        $this->assertModelData($mainSegments->toArray(), $dbMainSegments);
    }

    /**
     * @test update
     */
    public function testUpdateMainSegments()
    {
        $mainSegments = $this->makeMainSegments();
        $fakeMainSegments = $this->fakeMainSegmentsData();
        $updatedMainSegments = $this->mainSegmentsRepo->update($fakeMainSegments, $mainSegments->id);
        $this->assertModelData($fakeMainSegments, $updatedMainSegments->toArray());
        $dbMainSegments = $this->mainSegmentsRepo->find($mainSegments->id);
        $this->assertModelData($fakeMainSegments, $dbMainSegments->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteMainSegments()
    {
        $mainSegments = $this->makeMainSegments();
        $resp = $this->mainSegmentsRepo->delete($mainSegments->id);
        $this->assertTrue($resp);
        $this->assertNull(MainSegments::find($mainSegments->id), 'MainSegments should not exist in DB');
    }
}
