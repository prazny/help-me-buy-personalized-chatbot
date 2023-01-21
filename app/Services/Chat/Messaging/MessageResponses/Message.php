<?php

namespace App\Services\Chat\Messaging\MessageResponses;

use App\Services\Chat\Interfaces\MessageResponseInterface;
use App\Services\Chat\Messaging\Dto\ChatDto;
use App\Services\Chat\Response;

class Message extends MessageResponse implements MessageResponseInterface
{
    public function __construct(ChatDto $chatDto, array $story)
    {
        parent::__construct($chatDto, $story);
    }

    public function getResponse(): Response
    {
        return new Response(1, 'text', $this->story['message'], [], 'none');
    }
}
