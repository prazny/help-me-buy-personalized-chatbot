<?php

namespace App\Services\Chat\Messaging;

use App\Models\Product;
use App\Models\Widget;
use App\Services\Chat\Messaging\Dto\ChatDto;
use Illuminate\Support\Facades\Cache;

class StartMessaging
{
    public function start(Widget $widget): string
    {
        $chatDto = ChatDto::create($widget->id, $widget->stories);

        return $chatDto->getToken();
    }
}
