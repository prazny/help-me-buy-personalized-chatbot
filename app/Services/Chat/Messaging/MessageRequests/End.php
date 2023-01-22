<?php

namespace App\Services\Chat\Messaging\MessageRequests;

use App\Services\Chat\Interfaces\MessageRequestInterface;
use App\Services\Chat\Messaging\Dto\ChatDto;

class End extends MessageRequest implements MessageRequestInterface
{
    public function __construct(ChatDto $chatDto, array $story, array $answer)
    {
        parent::__construct($chatDto, $story, $answer);
    }

    public function process(): bool
    {
        $this->chatDto->reset();
        return true;
    }
}
