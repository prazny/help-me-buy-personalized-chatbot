<?php

namespace App\Services\Chat\Messaging\MessageResponses;

use App\Services\Chat\Interfaces\MessageResponseInterface;
use App\Services\Chat\Messaging\Dto\ChatDto;
use App\Services\Chat\Response;
use Exception;

class Search extends MessageResponse implements MessageResponseInterface
{
    public function __construct(ChatDto $chatDto, array $story)
    {
        parent::__construct($chatDto, $story);
    }

    /**
     * @throws Exception
     */
    public function getResponse(): Response
    {
        return match ($this->story['attribute']) {
            'name' => $this->getResponseForName(),
            default => throw new Exception(),
        };
    }

    private function getResponseForName(): Response
    {
        return new Response(1, 'text', $this->story['question'], [], 'text');
    }
}
