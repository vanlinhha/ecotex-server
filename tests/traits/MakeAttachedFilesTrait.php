<?php

use Faker\Factory as Faker;
use App\Models\AttachedFiles;
use App\Repositories\AttachedFilesRepository;

trait MakeAttachedFilesTrait
{
    /**
     * Create fake instance of AttachedFiles and save it in database
     *
     * @param array $attachedFilesFields
     * @return AttachedFiles
     */
    public function makeAttachedFiles($attachedFilesFields = [])
    {
        /** @var AttachedFilesRepository $attachedFilesRepo */
        $attachedFilesRepo = App::make(AttachedFilesRepository::class);
        $theme = $this->fakeAttachedFilesData($attachedFilesFields);
        return $attachedFilesRepo->create($theme);
    }

    /**
     * Get fake instance of AttachedFiles
     *
     * @param array $attachedFilesFields
     * @return AttachedFiles
     */
    public function fakeAttachedFiles($attachedFilesFields = [])
    {
        return new AttachedFiles($this->fakeAttachedFilesData($attachedFilesFields));
    }

    /**
     * Get fake data of AttachedFiles
     *
     * @param array $postFields
     * @return array
     */
    public function fakeAttachedFilesData($attachedFilesFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'post_id' => $fake->randomDigitNotNull,
            'url' => $fake->word,
            'name' => $fake->word,
            'type' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $attachedFilesFields);
    }
}
