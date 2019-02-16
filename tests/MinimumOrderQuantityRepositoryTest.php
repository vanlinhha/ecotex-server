<?php

use App\Models\MinimumOrderQuantity;
use App\Repositories\MinimumOrderQuantityRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MinimumOrderQuantityRepositoryTest extends TestCase
{
    use MakeMinimumOrderQuantityTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var MinimumOrderQuantityRepository
     */
    protected $minimumOrderQuantityRepo;

    public function setUp()
    {
        parent::setUp();
        $this->minimumOrderQuantityRepo = App::make(MinimumOrderQuantityRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateMinimumOrderQuantity()
    {
        $minimumOrderQuantity = $this->fakeMinimumOrderQuantityData();
        $createdMinimumOrderQuantity = $this->minimumOrderQuantityRepo->create($minimumOrderQuantity);
        $createdMinimumOrderQuantity = $createdMinimumOrderQuantity->toArray();
        $this->assertArrayHasKey('id', $createdMinimumOrderQuantity);
        $this->assertNotNull($createdMinimumOrderQuantity['id'], 'Created MinimumOrderQuantity must have id specified');
        $this->assertNotNull(MinimumOrderQuantity::find($createdMinimumOrderQuantity['id']), 'MinimumOrderQuantity with given id must be in DB');
        $this->assertModelData($minimumOrderQuantity, $createdMinimumOrderQuantity);
    }

    /**
     * @test read
     */
    public function testReadMinimumOrderQuantity()
    {
        $minimumOrderQuantity = $this->makeMinimumOrderQuantity();
        $dbMinimumOrderQuantity = $this->minimumOrderQuantityRepo->find($minimumOrderQuantity->id);
        $dbMinimumOrderQuantity = $dbMinimumOrderQuantity->toArray();
        $this->assertModelData($minimumOrderQuantity->toArray(), $dbMinimumOrderQuantity);
    }

    /**
     * @test update
     */
    public function testUpdateMinimumOrderQuantity()
    {
        $minimumOrderQuantity = $this->makeMinimumOrderQuantity();
        $fakeMinimumOrderQuantity = $this->fakeMinimumOrderQuantityData();
        $updatedMinimumOrderQuantity = $this->minimumOrderQuantityRepo->update($fakeMinimumOrderQuantity, $minimumOrderQuantity->id);
        $this->assertModelData($fakeMinimumOrderQuantity, $updatedMinimumOrderQuantity->toArray());
        $dbMinimumOrderQuantity = $this->minimumOrderQuantityRepo->find($minimumOrderQuantity->id);
        $this->assertModelData($fakeMinimumOrderQuantity, $dbMinimumOrderQuantity->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteMinimumOrderQuantity()
    {
        $minimumOrderQuantity = $this->makeMinimumOrderQuantity();
        $resp = $this->minimumOrderQuantityRepo->delete($minimumOrderQuantity->id);
        $this->assertTrue($resp);
        $this->assertNull(MinimumOrderQuantity::find($minimumOrderQuantity->id), 'MinimumOrderQuantity should not exist in DB');
    }
}
