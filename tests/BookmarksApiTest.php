<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookmarksApiTest extends TestCase
{
    use MakeBookmarksTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateBookmarks()
    {
        $bookmarks = $this->fakeBookmarksData();
        $this->json('POST', '/api/v1/bookmarks', $bookmarks);

        $this->assertApiResponse($bookmarks);
    }

    /**
     * @test
     */
    public function testReadBookmarks()
    {
        $bookmarks = $this->makeBookmarks();
        $this->json('GET', '/api/v1/bookmarks/'.$bookmarks->id);

        $this->assertApiResponse($bookmarks->toArray());
    }

    /**
     * @test
     */
    public function testUpdateBookmarks()
    {
        $bookmarks = $this->makeBookmarks();
        $editedBookmarks = $this->fakeBookmarksData();

        $this->json('PUT', '/api/v1/bookmarks/'.$bookmarks->id, $editedBookmarks);

        $this->assertApiResponse($editedBookmarks);
    }

    /**
     * @test
     */
    public function testDeleteBookmarks()
    {
        $bookmarks = $this->makeBookmarks();
        $this->json('DELETE', '/api/v1/bookmarks/'.$bookmarks->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/bookmarks/'.$bookmarks->id);

        $this->assertResponseStatus(404);
    }
}
