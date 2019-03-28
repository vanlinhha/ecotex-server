<?php

use App\Models\Products;
use App\Repositories\ProductsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductsRepositoryTest extends TestCase
{
    use MakeProductsTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ProductsRepository
     */
    protected $productsRepo;

    public function setUp()
    {
        parent::setUp();
        $this->productsRepo = App::make(ProductsRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateProducts()
    {
        $products = $this->fakeProductsData();
        $createdProducts = $this->productsRepo->create($products);
        $createdProducts = $createdProducts->toArray();
        $this->assertArrayHasKey('id', $createdProducts);
        $this->assertNotNull($createdProducts['id'], 'Created Products must have id specified');
        $this->assertNotNull(Products::find($createdProducts['id']), 'Products with given id must be in DB');
        $this->assertModelData($products, $createdProducts);
    }

    /**
     * @test read
     */
    public function testReadProducts()
    {
        $products = $this->makeProducts();
        $dbProducts = $this->productsRepo->find($products->id);
        $dbProducts = $dbProducts->toArray();
        $this->assertModelData($products->toArray(), $dbProducts);
    }

    /**
     * @test update
     */
    public function testUpdateProducts()
    {
        $products = $this->makeProducts();
        $fakeProducts = $this->fakeProductsData();
        $updatedProducts = $this->productsRepo->update($fakeProducts, $products->id);
        $this->assertModelData($fakeProducts, $updatedProducts->toArray());
        $dbProducts = $this->productsRepo->find($products->id);
        $this->assertModelData($fakeProducts, $dbProducts->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteProducts()
    {
        $products = $this->makeProducts();
        $resp = $this->productsRepo->delete($products->id);
        $this->assertTrue($resp);
        $this->assertNull(Products::find($products->id), 'Products should not exist in DB');
    }
}
