<?php

namespace App\Services\Chat\Messaging\MessageRequests;

use App\Services\Chat\Interfaces\FilterInterface;
use App\Services\Chat\Interfaces\MessageRequestInterface;
use App\Services\Chat\Messaging\Dto\ChatDto;
use App\Services\Chat\Messaging\Filters\FilerByProductName;
use App\Services\Chat\Messaging\Filters\FilterByCategory;
use App\Services\Chat\Messaging\Filters\FilterByParam;
use App\Services\Chat\Messaging\Filters\FilterByPrice;

class Choice extends MessageRequest implements MessageRequestInterface
{

    public function __construct(ChatDto $chatDto, array $story, array $answer)
    {
        parent::__construct($chatDto, $story, $answer);
    }

    public function process(): bool
    {
        $filter = match ($this->story['attribute']) {
            'param' => new FilterByParam($this->answer['values']),
            'category' => new FilterByCategory($this->answer['values']),
            'price' => new FilterByPrice($this->answer['values']),
        };

        $this->chatDto->addFilter([$filter::class, $filter->toArray()]);

        return true;
    }

}
