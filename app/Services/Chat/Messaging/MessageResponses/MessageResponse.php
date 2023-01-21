<?php

namespace App\Services\Chat\Messaging\MessageResponses;

use App\Services\Chat\Messaging\Dto\ChatDto;
use App\Services\Chat\Response;

abstract class MessageResponse
{
    protected array $story;
    protected ChatDto $chatDto;

    public function __construct(ChatDto $chatDto, array $story)
    {
        $this->story = $story;
        $this->chatDto = $chatDto;
    }

}
