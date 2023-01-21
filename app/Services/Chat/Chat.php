<?php

namespace App\Services\Chat;

use App\Models\Widget;
use App\Services\Chat\Messaging\Messaging;
use App\Services\Chat\Messaging\StartMessaging;
use Illuminate\Support\Facades\Cache;

class Chat
{
    public function __construct()
    {

    }

    public function startMessaging(): StartMessaging
    {
        return new StartMessaging();
    }

    public function messaging(): Messaging
    {
        return new Messaging();
    }

}
