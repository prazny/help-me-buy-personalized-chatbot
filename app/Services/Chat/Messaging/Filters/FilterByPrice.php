<?php

namespace App\Services\Chat\Messaging\Filters;

use App\Services\Chat\Interfaces\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class FilterByPrice extends Filter implements FilterInterface
{
    private array $prices = [];

    public function __construct(array $attrs)
    {
        parent::__construct($attrs);
        foreach ($attrs as $attr) {
            $this->prices[] = explode("-", $attr);
        }
    }

    public function filter(Builder $builder): Builder
    {
        foreach($this->prices as $price) {
            \Log::warning(json_encode($price));
            $builder->whereBetween('price',  [$price[0], $price[1]]);
        }
        return $builder;
    }

    public static function fromArray(array $array): FilterByPrice
    {
        return new FilterByPrice($array);
    }
}
