<?php

use App\Models\Bookmarks;
use App\Repositories\BookmarksRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookmarksRepositoryTest extends TestCase
{
    use MakeBookmarksTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var BookmarksRepository
     */
    protected $bookmarksRepo;

    public function setUp()
    {
        parent::setUp();
        $this->bookmarksRepo = App::make(BookmarksRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateBookmarks()
    {
        $bookmarks = $this->fakeBookmarksData();
        $createdBookmarks = $this->bookmarksRepo->create($bookmarks);
        $createdBookmarks = $createdBookmarks->toArray();
        $this->assertArrayHasKey('id', $createdBookmarks);
        $this->assertNotNull($createdBookmarks['id'], 'Created Bookmarks must have id specified');
        $this->assertNotNull(Bookmarks::find($createdBookmarks['id']), 'Bookmarks with given id must be in DB');
        $this->assertModelData($bookmarks, $createdBookmarks);
    }

    /**
     * @test read
     */
    public function testReadBookmarks()
    {
        $bookmarks = $this->makeBookmarks();
        $dbBookmarks = $this->bookmarksRepo->find($bookmarks->id);
        $dbBookmarks = $dbBookmarks->toArray();
        $this->assertModelData($bookmarks->toArray(), $dbBookmarks);
    }

    /**
     * @test update
     */
    public function testUpdateBookmarks()
    {
        $bookmarks = $this->makeBookmarks();
        $fakeBookmarks = $this->fakeBookmarksData();
        $updatedBookmarks = $this->bookmarksRepo->update($fakeBookmarks, $bookmarks->id);
        $this->assertModelData($fakeBookmarks, $updatedBookmarks->toArray());
        $dbBookmarks = $this->bookmarksRepo->find($bookmarks->id);
        $this->assertModelData($fakeBookmarks, $dbBookmarks->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteBookmarks()
    {
        $bookmarks = $this->makeBookmarks();
        $resp = $this->bookmarksRepo->delete($bookmarks->id);
        $this->assertTrue($resp);
        $this->assertNull(Bookmarks::find($bookmarks->id), 'Bookmarks should not exist in DB');
    }
}
