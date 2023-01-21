<?php

namespace App\Services\Chat\Interfaces;

use App\Services\Chat\Messaging\Dto\ChatDto;

interface MessageRequestInterface
{
    public function __construct(ChatDto $chatDto, array $story, array $answer);
    public function process(): bool;

}
