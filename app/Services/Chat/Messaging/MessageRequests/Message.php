<?php

namespace App\Services\Chat\Messaging\MessageRequests;

use App\Services\Chat\Interfaces\MessageRequestInterface;
use App\Services\Chat\Messaging\Dto\ChatDto;
use App\Services\Chat\Messaging\Filters\FilerByProductName;
use App\Services\Chat\Messaging\Filters\FilterByCategory;
use App\Services\Chat\Messaging\Filters\FilterByParam;

class Message extends MessageRequest implements MessageRequestInterface
{
    public function __construct(ChatDto $chatDto, array $story, array $answer)
    {
        parent::__construct($chatDto, $story, $answer);
    }

    public function process(): bool
    {
        return true;
    }
}
