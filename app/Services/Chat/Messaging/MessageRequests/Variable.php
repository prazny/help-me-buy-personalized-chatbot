<?php

namespace App\Services\Chat\Messaging\MessageRequests;

use App\Services\Chat\Interfaces\MessageRequestInterface;
use App\Services\Chat\Messaging\Dto\ChatDto;

class Variable extends MessageRequest implements MessageRequestInterface
{
    public function __construct(ChatDto $chatDto, array $story, array $answer)
    {
        parent::__construct($chatDto, $story, $answer);
    }

    public function process(): bool
    {
        return $this->saveVariables();
    }

    private function saveVariables(): bool
    {
        $this->chatDto->addVariable("__{$this->story['var_name']}__", $this->answer['values'][0]);
        return true;
    }
}
