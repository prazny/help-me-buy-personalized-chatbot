<?php

namespace App\Services\Chat\Messaging;

use App\Services\Chat\Interfaces\MessageResponseInterface;
use App\Services\Chat\Messaging\Dto\ChatDto;
use App\Services\Chat\Messaging\MessageResponses\Choice;
use App\Services\Chat\Messaging\MessageResponses\End;
use App\Services\Chat\Messaging\MessageResponses\Message;
use App\Services\Chat\Messaging\MessageResponses\Search;
use App\Services\Chat\Messaging\MessageResponses\ShowProducts;
use App\Services\Chat\Messaging\MessageResponses\Variable;
use App\Services\Chat\Response;
use Cache;
use Exception;

class Messaging
{
    private string $token;
    private ChatDto $chatDto;
    private array $answers;

    public function start(string $token): self
    {
        $this->chatDto = new ChatDto($token);
        return $this;
    }

    /**
     * @throws Exception
     */
    public function response(array $answer): MessageResponseInterface
    {
        $request = new Request($answer);
        $request->process($this->chatDto);

        // if($is_request_processed)

        //$is_last_story = $this->chatDto->isLastStory();

       /* if ($is_last_story) {
            $story = $this->chatDto->getCurrentStory();
            return new End($this->chatDto, $story);
        }*/

        $story = $this->chatDto->getNextStory();

        return match ($story['type']) {
            'choice' => new Choice($this->chatDto, $story),
            'message' => new Message($this->chatDto, $story),
            'search' => new Search($this->chatDto, $story),
            'variable' => new Variable($this->chatDto, $story),
            'show-products' => new ShowProducts($this->chatDto, $story),
            'end' => new End($this->chatDto, $story),
            default => throw new Exception(),
        };
    }

}
