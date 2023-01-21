<?php

namespace App\Services\Chat\Interfaces;

use App\Services\Chat\Messaging\Dto\ChatDto;
use App\Services\Chat\Response;

interface MessageResponseInterface
{
    public function __construct(ChatDto $chatDto, array $story);

    public function getResponse(): Response;

}
