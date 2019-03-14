<?php

use App\Models\ProductPosts;
use App\Repositories\ProductPostsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductPostsRepositoryTest extends TestCase
{
    use MakeProductPostsTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ProductPostsRepository
     */
    protected $productPostsRepo;

    public function setUp()
    {
        parent::setUp();
        $this->productPostsRepo = App::make(ProductPostsRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateProductPosts()
    {
        $productPosts = $this->fakeProductPostsData();
        $createdProductPosts = $this->productPostsRepo->create($productPosts);
        $createdProductPosts = $createdProductPosts->toArray();
        $this->assertArrayHasKey('id', $createdProductPosts);
        $this->assertNotNull($createdProductPosts['id'], 'Created ProductPosts must have id specified');
        $this->assertNotNull(ProductPosts::find($createdProductPosts['id']), 'ProductPosts with given id must be in DB');
        $this->assertModelData($productPosts, $createdProductPosts);
    }

    /**
     * @test read
     */
    public function testReadProductPosts()
    {
        $productPosts = $this->makeProductPosts();
        $dbProductPosts = $this->productPostsRepo->find($productPosts->id);
        $dbProductPosts = $dbProductPosts->toArray();
        $this->assertModelData($productPosts->toArray(), $dbProductPosts);
    }

    /**
     * @test update
     */
    public function testUpdateProductPosts()
    {
        $productPosts = $this->makeProductPosts();
        $fakeProductPosts = $this->fakeProductPostsData();
        $updatedProductPosts = $this->productPostsRepo->update($fakeProductPosts, $productPosts->id);
        $this->assertModelData($fakeProductPosts, $updatedProductPosts->toArray());
        $dbProductPosts = $this->productPostsRepo->find($productPosts->id);
        $this->assertModelData($fakeProductPosts, $dbProductPosts->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteProductPosts()
    {
        $productPosts = $this->makeProductPosts();
        $resp = $this->productPostsRepo->delete($productPosts->id);
        $this->assertTrue($resp);
        $this->assertNull(ProductPosts::find($productPosts->id), 'ProductPosts should not exist in DB');
    }
}
