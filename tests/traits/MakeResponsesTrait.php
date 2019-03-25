<?php

use Faker\Factory as Faker;
use App\Models\Responses;
use App\Repositories\ResponsesRepository;

trait MakeResponsesTrait
{
    /**
     * Create fake instance of Responses and save it in database
     *
     * @param array $responsesFields
     * @return Responses
     */
    public function makeResponses($responsesFields = [])
    {
        /** @var ResponsesRepository $responsesRepo */
        $responsesRepo = App::make(ResponsesRepository::class);
        $theme = $this->fakeResponsesData($responsesFields);
        return $responsesRepo->create($theme);
    }

    /**
     * Get fake instance of Responses
     *
     * @param array $responsesFields
     * @return Responses
     */
    public function fakeResponses($responsesFields = [])
    {
        return new Responses($this->fakeResponsesData($responsesFields));
    }

    /**
     * Get fake data of Responses
     *
     * @param array $postFields
     * @return array
     */
    public function fakeResponsesData($responsesFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'product_post_id' => $fake->randomDigitNotNull,
            'owner_id' => $fake->randomDigitNotNull,
            'accepted_quantity' => $fake->randomDigitNotNull,
            'suggest_quantity' => $fake->word,
            'accepted_price' => $fake->randomDigitNotNull,
            'suggest_price' => $fake->word,
            'accepted_delivery' => $fake->randomDigitNotNull,
            'suggest_delivery' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $responsesFields);
    }
}
