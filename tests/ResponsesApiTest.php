<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ResponsesApiTest extends TestCase
{
    use MakeResponsesTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateResponses()
    {
        $responses = $this->fakeResponsesData();
        $this->json('POST', '/api/v1/responses', $responses);

        $this->assertApiResponse($responses);
    }

    /**
     * @test
     */
    public function testReadResponses()
    {
        $responses = $this->makeResponses();
        $this->json('GET', '/api/v1/responses/'.$responses->id);

        $this->assertApiResponse($responses->toArray());
    }

    /**
     * @test
     */
    public function testUpdateResponses()
    {
        $responses = $this->makeResponses();
        $editedResponses = $this->fakeResponsesData();

        $this->json('PUT', '/api/v1/responses/'.$responses->id, $editedResponses);

        $this->assertApiResponse($editedResponses);
    }

    /**
     * @test
     */
    public function testDeleteResponses()
    {
        $responses = $this->makeResponses();
        $this->json('DELETE', '/api/v1/responses/'.$responses->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/responses/'.$responses->id);

        $this->assertResponseStatus(404);
    }
}
