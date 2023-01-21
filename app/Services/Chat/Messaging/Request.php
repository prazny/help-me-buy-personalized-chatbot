<?php

namespace App\Services\Chat\Messaging;

use App\Services\Chat\Messaging\Dto\ChatDto;
use App\Services\Chat\Messaging\MessageRequests\Choice;
use App\Services\Chat\Messaging\MessageRequests\Message;
use App\Services\Chat\Messaging\MessageRequests\Search;
use App\Services\Chat\Messaging\MessageRequests\ShowProducts;
use App\Services\Chat\Messaging\MessageRequests\Variable;
use Exception;

class Request
{
    private array $answer;
    private ChatDto $chatDto;

    public function __construct(array $answer)
    {
        $this->answer = $answer;
    }

    public function process(ChatDto $chatDto): bool
    {
        $this->chatDto = $chatDto;
        if ($this->chatDto->isFirstStory()) return true;

        $currentStory = $this->chatDto->getCurrentStory();


        return match ($currentStory['type']) {
            'choice' => (new Choice($this->chatDto, $currentStory, $this->answer))->process(),
            'message' => (new Message($this->chatDto, $currentStory, $this->answer))->process(),
            'search' => (new Search($this->chatDto, $currentStory, $this->answer))->process(),
            'variable' => (new Variable($this->chatDto, $currentStory, $this->answer))->process(),
            'show-products' => (new ShowProducts($this->chatDto, $currentStory, $this->answer))->process(),
            default => throw new Exception(),
        };
    }

}
