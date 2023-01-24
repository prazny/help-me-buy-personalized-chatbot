<?php

namespace App\Services\Chat\Messaging\MessageResponses;

use App\Models\Product;
use App\Services\Chat\Interfaces\MessageResponseInterface;
use App\Services\Chat\Messaging\Dto\ChatDto;
use App\Services\Chat\Response;
use DB;

class ShowProducts extends MessageResponse implements MessageResponseInterface
{
    public function __construct(ChatDto $chatDto, array $story)
    {
        parent::__construct($chatDto, $story);
    }

    public function getResponse(): Response
    {
        $products = Product::query();
        //$products->file;
        foreach ($this->chatDto->getFilters() as $filter) {
            $class = $filter[0]::fromArray($filter[1]);
            $products = $class->filter($products);
        }

        $products->limit(3);


        if ($products->count() == 0) {
            return new Response(1, 'text', $this->story['message_if_not_found'], [], 'none');
        } else {
            $response_arr = ['message' => $this->story['message_if_found'], 'products' => []];
            DB::connection()->enableQueryLog();
            foreach ($products->get() as $product) {
                $response_arr['products'][] = [
                    'name' => $product->name,
                    'img_url' => $product->img_url,
                    'url' => $product->url,
                    'price' => $product->price
                ];
            }
            $queries = DB::getQueryLog();
            \Log::warning(json_encode($queries));
            return new Response(1, 'products', $response_arr, [], 'none');
        }

    }
}
