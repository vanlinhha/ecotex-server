<?php

use App\Models\Responses;
use App\Repositories\ResponsesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ResponsesRepositoryTest extends TestCase
{
    use MakeResponsesTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ResponsesRepository
     */
    protected $responsesRepo;

    public function setUp()
    {
        parent::setUp();
        $this->responsesRepo = App::make(ResponsesRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateResponses()
    {
        $responses = $this->fakeResponsesData();
        $createdResponses = $this->responsesRepo->create($responses);
        $createdResponses = $createdResponses->toArray();
        $this->assertArrayHasKey('id', $createdResponses);
        $this->assertNotNull($createdResponses['id'], 'Created Responses must have id specified');
        $this->assertNotNull(Responses::find($createdResponses['id']), 'Responses with given id must be in DB');
        $this->assertModelData($responses, $createdResponses);
    }

    /**
     * @test read
     */
    public function testReadResponses()
    {
        $responses = $this->makeResponses();
        $dbResponses = $this->responsesRepo->find($responses->id);
        $dbResponses = $dbResponses->toArray();
        $this->assertModelData($responses->toArray(), $dbResponses);
    }

    /**
     * @test update
     */
    public function testUpdateResponses()
    {
        $responses = $this->makeResponses();
        $fakeResponses = $this->fakeResponsesData();
        $updatedResponses = $this->responsesRepo->update($fakeResponses, $responses->id);
        $this->assertModelData($fakeResponses, $updatedResponses->toArray());
        $dbResponses = $this->responsesRepo->find($responses->id);
        $this->assertModelData($fakeResponses, $dbResponses->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteResponses()
    {
        $responses = $this->makeResponses();
        $resp = $this->responsesRepo->delete($responses->id);
        $this->assertTrue($resp);
        $this->assertNull(Responses::find($responses->id), 'Responses should not exist in DB');
    }
}
