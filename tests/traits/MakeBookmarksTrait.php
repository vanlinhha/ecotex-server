<?php

use Faker\Factory as Faker;
use App\Models\Bookmarks;
use App\Repositories\BookmarksRepository;

trait MakeBookmarksTrait
{
    /**
     * Create fake instance of Bookmarks and save it in database
     *
     * @param array $bookmarksFields
     * @return Bookmarks
     */
    public function makeBookmarks($bookmarksFields = [])
    {
        /** @var BookmarksRepository $bookmarksRepo */
        $bookmarksRepo = App::make(BookmarksRepository::class);
        $theme = $this->fakeBookmarksData($bookmarksFields);
        return $bookmarksRepo->create($theme);
    }

    /**
     * Get fake instance of Bookmarks
     *
     * @param array $bookmarksFields
     * @return Bookmarks
     */
    public function fakeBookmarks($bookmarksFields = [])
    {
        return new Bookmarks($this->fakeBookmarksData($bookmarksFields));
    }

    /**
     * Get fake data of Bookmarks
     *
     * @param array $postFields
     * @return array
     */
    public function fakeBookmarksData($bookmarksFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'user_id' => $fake->randomDigitNotNull,
            'follower_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $bookmarksFields);
    }
}
