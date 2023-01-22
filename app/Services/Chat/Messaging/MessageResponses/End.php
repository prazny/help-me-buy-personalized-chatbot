<?php

namespace App\Services\Chat\Messaging\MessageResponses;

use App\Services\Chat\Interfaces\MessageResponseInterface;
use App\Services\Chat\Messaging\Dto\ChatDto;
use App\Services\Chat\Response;

class End extends MessageResponse implements MessageResponseInterface
{
    private Response $response;

    public function __construct(ChatDto $chatDto, array $story)
    {
        parent::__construct($chatDto, $story);
    }

    public function getResponse(): Response
    {
        return new Response(1, 'text', $this->story['question'], [1 => $this->story['value']], 'single');
    }
}
