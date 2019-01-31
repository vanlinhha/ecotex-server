<?php

use App\Models\Pets;
use App\Repositories\PetsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PetsRepositoryTest extends TestCase
{
    use MakePetsTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var PetsRepository
     */
    protected $petsRepo;

    public function setUp()
    {
        parent::setUp();
        $this->petsRepo = App::make(PetsRepository::class);
    }

    /**
     * @test create
     */
    public function testCreatePets()
    {
        $pets = $this->fakePetsData();
        $createdPets = $this->petsRepo->create($pets);
        $createdPets = $createdPets->toArray();
        $this->assertArrayHasKey('id', $createdPets);
        $this->assertNotNull($createdPets['id'], 'Created Pets must have id specified');
        $this->assertNotNull(Pets::find($createdPets['id']), 'Pets with given id must be in DB');
        $this->assertModelData($pets, $createdPets);
    }

    /**
     * @test read
     */
    public function testReadPets()
    {
        $pets = $this->makePets();
        $dbPets = $this->petsRepo->find($pets->id);
        $dbPets = $dbPets->toArray();
        $this->assertModelData($pets->toArray(), $dbPets);
    }

    /**
     * @test update
     */
    public function testUpdatePets()
    {
        $pets = $this->makePets();
        $fakePets = $this->fakePetsData();
        $updatedPets = $this->petsRepo->update($fakePets, $pets->id);
        $this->assertModelData($fakePets, $updatedPets->toArray());
        $dbPets = $this->petsRepo->find($pets->id);
        $this->assertModelData($fakePets, $dbPets->toArray());
    }

    /**
     * @test delete
     */
    public function testDeletePets()
    {
        $pets = $this->makePets();
        $resp = $this->petsRepo->delete($pets->id);
        $this->assertTrue($resp);
        $this->assertNull(Pets::find($pets->id), 'Pets should not exist in DB');
    }
}
