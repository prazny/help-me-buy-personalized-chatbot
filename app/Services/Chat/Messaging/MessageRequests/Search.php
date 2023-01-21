<?php

namespace App\Services\Chat\Messaging\MessageRequests;

use App\Services\Chat\Interfaces\MessageRequestInterface;
use App\Services\Chat\Messaging\Dto\ChatDto;
use App\Services\Chat\Messaging\Filters\FilerByProductName;

class Search extends MessageRequest implements MessageRequestInterface
{
    public function __construct(ChatDto $chatDto, array $story, array $answer)
    {
        parent::__construct($chatDto, $story, $answer);
    }

    public function process(): bool
    {
        $filter = match ($this->story['attribute']) {
            'name' => new FilerByProductName($this->answer['values']),
        };

        $this->chatDto->addFilter([$filter::class, $filter->toArray()]);

        return true;
    }
}
