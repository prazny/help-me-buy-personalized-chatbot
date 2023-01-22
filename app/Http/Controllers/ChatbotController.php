<?php

namespace App\Http\Controllers;

use App\Events\ChatbotStartMessaging;
use App\Http\Requests\MessagingRequest;
use App\Models\Widget;
use App\Services\Chat\Chat;
use App\Services\Chat\Messaging\Dto\ChatDto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ChatbotController extends Controller
{
    public function getChatbot(Widget $widget)
    {
        $chatBot = \View::make('chat-bot.layout', [
            'widget_id' => $widget->id,
            'variables' => $widget->styles,
        ]);
        $response = response()->make($chatBot, 200);
        $front_url = config('front.front_url');
        $response->header('Content-Security-Policy', "frame-ancestors {$front_url} {$widget->domain}");
        return $response;
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
