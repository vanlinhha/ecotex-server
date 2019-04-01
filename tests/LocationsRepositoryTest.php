<?php

use App\Models\Locations;
use App\Repositories\LocationsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LocationsRepositoryTest extends TestCase
{
    use MakeLocationsTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var LocationsRepository
     */
    protected $locationsRepo;

    public function setUp()
    {
        parent::setUp();
        $this->locationsRepo = App::make(LocationsRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateLocations()
    {
        $locations = $this->fakeLocationsData();
        $createdLocations = $this->locationsRepo->create($locations);
        $createdLocations = $createdLocations->toArray();
        $this->assertArrayHasKey('id', $createdLocations);
        $this->assertNotNull($createdLocations['id'], 'Created Locations must have id specified');
        $this->assertNotNull(Locations::find($createdLocations['id']), 'Locations with given id must be in DB');
        $this->assertModelData($locations, $createdLocations);
    }

    /**
     * @test read
     */
    public function testReadLocations()
    {
        $locations = $this->makeLocations();
        $dbLocations = $this->locationsRepo->find($locations->id);
        $dbLocations = $dbLocations->toArray();
        $this->assertModelData($locations->toArray(), $dbLocations);
    }

    /**
     * @test update
     */
    public function testUpdateLocations()
    {
        $locations = $this->makeLocations();
        $fakeLocations = $this->fakeLocationsData();
        $updatedLocations = $this->locationsRepo->update($fakeLocations, $locations->id);
        $this->assertModelData($fakeLocations, $updatedLocations->toArray());
        $dbLocations = $this->locationsRepo->find($locations->id);
        $this->assertModelData($fakeLocations, $dbLocations->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteLocations()
    {
        $locations = $this->makeLocations();
        $resp = $this->locationsRepo->delete($locations->id);
        $this->assertTrue($resp);
        $this->assertNull(Locations::find($locations->id), 'Locations should not exist in DB');
    }
}
