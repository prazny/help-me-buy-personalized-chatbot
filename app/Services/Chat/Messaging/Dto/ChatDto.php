<?php

namespace App\Services\Chat\Messaging\Dto;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ChatDto
{
    private static int $tokenLen = 16;

    private string $token;
    private array $chat;


    public function __construct($token)
    {
        $this->token = $token;
        $this->readChat();

    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getCurrentStoryNo(): int
    {
        return max($this->chat['next_story_no'] - 1, 0);
    }

    public function getCurrentStory(): array
    {
        return $this->chat['stories'][$this->getCurrentStoryNo()];
    }

    public function getNextStoryNo(): int
    {
        return $this->chat['next_story_no'];
    }

    public function getNextStory(): array
    {
        $nextStory = $this->chat['stories'][$this->getNextStoryNo()];
        $this->chat['next_story_no'] = $this->chat['next_story_no'] + 1;
        $this->saveChat();
        return $nextStory;
    }

    public function getStory(int $no): array
    {
        return $this->chat['stories'][$no];
    }

    public function getFilters(): array
    {
        return $this->chat['filters'];
    }

    public function getVariables(): array
    {
        return $this->chat['variables'];
    }

    public function getStoriesCount(): int
    {
        return count($this->chat['stories']);
    }

    public function isFirstStory(): bool
    {
        return $this->getNextStoryNo() == 0;
    }

    public function isLastStory(): bool
    {
        return $this->getStoriesCount() == $this->getNextStoryNo();
    }

    public function reset(): bool
    {
        $this->chat['answers'] = [];
        $this->chat['filters'] = [];
        $this->chat['variables'] = [];
        $this->chat['next_story_no'] = 0;

        $this->saveChat();
        return true;
    }

    public static function create(int $widget_id, array $stories): ChatDto
    {
        $token = self::generateToken();

        $array = [
            'widget_id' => $widget_id,
            'stories' => $stories,
            'answers' => [],
            'filters' => [],
            'variables' => [],
            'next_story_no' => 0,
        ];

        Cache::put("chat_{$token}", $array, now()->addHours(10));

        return new ChatDto($token);
    }

    public function addFilter(array $filter): void
    {
        $this->chat['filters'][] = $filter;
        $this->saveChat();
    }

    public function addVariable(string $key, string $value): void
    {
        $this->chat['variables'][$key] = $value;
        $this->saveChat();
    }

    private function saveChat(): void
    {
        Cache::put("chat_" . $this->token, $this->chat, now()->addHours(10));
        $this->readChat();
    }

    public function getChat(): array
    {
        return $this->chat;
    }

    private function readChat(): void
    {
        $this->chat = Cache::get("chat_" . $this->token);
    }

    /**
     * @throws \Exception
     */
    private static function generateToken(): string
    {
        return bin2hex(random_bytes(self::$tokenLen));
    }


}
