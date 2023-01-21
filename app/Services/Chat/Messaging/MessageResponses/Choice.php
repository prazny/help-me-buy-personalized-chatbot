<?php

namespace App\Services\Chat\Messaging\MessageResponses;

use App\Models\Param;
use App\Models\ParamValue;
use App\Models\ProductCategory;
use App\Services\Chat\Interfaces\MessageResponseInterface;
use App\Services\Chat\Messaging\Dto\ChatDto;
use App\Services\Chat\Response;
use Exception;

class Choice extends MessageResponse implements MessageResponseInterface
{
    private string $question;

    public function __construct(ChatDto $chatDto, array $story)
    {
        parent::__construct($chatDto, $story);
        $this->question = $story['question'];
    }

    /**
     * @throws Exception
     */
    public function getResponse(): Response
    {
        return match ($this->story['attribute']) {
            'param' => $this->getResponseForParam(),
            'category' => $this->getResponseForCategory(),
            'price' => $this->getResponseForPrice(),
            default => throw new Exception(),
        };
    }

    private function getResponseForParam(): Response
    {
        $param = Param::findOrFail($this->story['param_name']);
        $param_values_id = explode(',', $this->story['values']);
        $paramValues = ParamValue::whereIn('id', $param_values_id)->get();

        $response_values = [];
        foreach($paramValues as $value) {
            $response_values[$value->id] = $value->value;
        }

        return new Response(1, 'text', $this->question, $response_values, 'single');
    }

    private function getResponseForCategory(): Response
    {
        $categories_id = explode(',', $this->story['values']);
        $categories = ProductCategory::whereIn('id', $categories_id)->get();
        $response_values = [];
        foreach($categories as $category) {
            $response_values[$category->id] = $category->name;
        }
        return new Response(1, $this->question, $response_values, 'single');
    }

    private function getResponseForPrice(): Response
    {
        $prices = [];
        foreach($this->story as $key => $value) {
            if (preg_match("/^price_from_[0-9]{1,4}$/",$key)){
                $int_val =  preg_replace('/[^0-9]/', '', $key);
                $prices[$int_val]['from'] = $value;
            }
            if (preg_match("/^price_to_[0-9]{1,4}$/",$key)){
                $int_val =  preg_replace('/[^0-9]/', '', $key);
                $prices[$int_val]['to'] = $value;
            }
        }

        $response_values = [];
        foreach($prices as $price) {
            $response_values["{$price['from']}-{$price['to']}"] = "{$price['from']} - {$price['to']}";
        }

        return new Response(1, $this->question, $response_values, 'single');
    }
}
