<?php

use App\Models\ProductGroups;
use App\Repositories\ProductGroupsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductGroupsRepositoryTest extends TestCase
{
    use MakeProductGroupsTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ProductGroupsRepository
     */
    protected $productGroupsRepo;

    public function setUp()
    {
        parent::setUp();
        $this->productGroupsRepo = App::make(ProductGroupsRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateProductGroups()
    {
        $productGroups = $this->fakeProductGroupsData();
        $createdProductGroups = $this->productGroupsRepo->create($productGroups);
        $createdProductGroups = $createdProductGroups->toArray();
        $this->assertArrayHasKey('id', $createdProductGroups);
        $this->assertNotNull($createdProductGroups['id'], 'Created ProductGroups must have id specified');
        $this->assertNotNull(ProductGroups::find($createdProductGroups['id']), 'ProductGroups with given id must be in DB');
        $this->assertModelData($productGroups, $createdProductGroups);
    }

    /**
     * @test read
     */
    public function testReadProductGroups()
    {
        $productGroups = $this->makeProductGroups();
        $dbProductGroups = $this->productGroupsRepo->find($productGroups->id);
        $dbProductGroups = $dbProductGroups->toArray();
        $this->assertModelData($productGroups->toArray(), $dbProductGroups);
    }

    /**
     * @test update
     */
    public function testUpdateProductGroups()
    {
        $productGroups = $this->makeProductGroups();
        $fakeProductGroups = $this->fakeProductGroupsData();
        $updatedProductGroups = $this->productGroupsRepo->update($fakeProductGroups, $productGroups->id);
        $this->assertModelData($fakeProductGroups, $updatedProductGroups->toArray());
        $dbProductGroups = $this->productGroupsRepo->find($productGroups->id);
        $this->assertModelData($fakeProductGroups, $dbProductGroups->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteProductGroups()
    {
        $productGroups = $this->makeProductGroups();
        $resp = $this->productGroupsRepo->delete($productGroups->id);
        $this->assertTrue($resp);
        $this->assertNull(ProductGroups::find($productGroups->id), 'ProductGroups should not exist in DB');
    }
}
