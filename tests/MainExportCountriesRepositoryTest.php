<?php

use App\Models\MainExportCountries;
use App\Repositories\MainExportCountriesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MainExportCountriesRepositoryTest extends TestCase
{
    use MakeMainExportCountriesTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var MainExportCountriesRepository
     */
    protected $mainExportCountriesRepo;

    public function setUp()
    {
        parent::setUp();
        $this->mainExportCountriesRepo = App::make(MainExportCountriesRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateMainExportCountries()
    {
        $mainExportCountries = $this->fakeMainExportCountriesData();
        $createdMainExportCountries = $this->mainExportCountriesRepo->create($mainExportCountries);
        $createdMainExportCountries = $createdMainExportCountries->toArray();
        $this->assertArrayHasKey('id', $createdMainExportCountries);
        $this->assertNotNull($createdMainExportCountries['id'], 'Created MainExportCountries must have id specified');
        $this->assertNotNull(MainExportCountries::find($createdMainExportCountries['id']), 'MainExportCountries with given id must be in DB');
        $this->assertModelData($mainExportCountries, $createdMainExportCountries);
    }

    /**
     * @test read
     */
    public function testReadMainExportCountries()
    {
        $mainExportCountries = $this->makeMainExportCountries();
        $dbMainExportCountries = $this->mainExportCountriesRepo->find($mainExportCountries->id);
        $dbMainExportCountries = $dbMainExportCountries->toArray();
        $this->assertModelData($mainExportCountries->toArray(), $dbMainExportCountries);
    }

    /**
     * @test update
     */
    public function testUpdateMainExportCountries()
    {
        $mainExportCountries = $this->makeMainExportCountries();
        $fakeMainExportCountries = $this->fakeMainExportCountriesData();
        $updatedMainExportCountries = $this->mainExportCountriesRepo->update($fakeMainExportCountries, $mainExportCountries->id);
        $this->assertModelData($fakeMainExportCountries, $updatedMainExportCountries->toArray());
        $dbMainExportCountries = $this->mainExportCountriesRepo->find($mainExportCountries->id);
        $this->assertModelData($fakeMainExportCountries, $dbMainExportCountries->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteMainExportCountries()
    {
        $mainExportCountries = $this->makeMainExportCountries();
        $resp = $this->mainExportCountriesRepo->delete($mainExportCountries->id);
        $this->assertTrue($resp);
        $this->assertNull(MainExportCountries::find($mainExportCountries->id), 'MainExportCountries should not exist in DB');
    }
}
