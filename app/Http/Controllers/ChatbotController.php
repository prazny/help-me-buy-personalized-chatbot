<?php

namespace App\Http\Controllers;

use App\Events\ChatbotStartMessaging;
use App\Http\Requests\MessagingRequest;
use App\Models\Widget;
use App\Services\Chat\Chat;
use App\Services\Chat\Messaging\Dto\ChatDto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use OAuthProvider;

class ChatbotController extends Controller
{
    public function getChatbot()
    {
        return view('chat-bot.layout', [
            'widget_id' => 2
        ]);
    }

    /**
     * @throws \Exception
     */
    public function startMessaging(Widget $widget)
    {
        $chat = new Chat();
        $token = $chat->startMessaging()->start($widget);

        return response([
            'widget' => [
                'id' => $widget->id,
                'name' => $widget->name,
            ],
            'token' => $token
        ]);
    }

    /**
     * @throws \Exception
     */
    public function messaging(Request $request)
    {
        $token = $request->token;
        $chat = new Chat();
        $arr = $chat->messaging()
            ->start($token)
            ->response($request->answer)
            ->getResponse()
            ->toArray();

        return array_merge($arr, (new ChatDto($token))->getChat());
    }
}
