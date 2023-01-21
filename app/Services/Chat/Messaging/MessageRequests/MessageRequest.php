<?php

namespace App\Services\Chat\Messaging\MessageRequests;

use App\Services\Chat\Messaging\Dto\ChatDto;

abstract class MessageRequest
{
    protected ChatDto $chatDto;
    protected array $story;
    protected array $answer;

    public function __construct(ChatDto $chatDto, array $story, array $answer)
    {
        $this->chatDto = $chatDto;
        $this->story = $story;
        $this->answer = $answer;
    }

}
