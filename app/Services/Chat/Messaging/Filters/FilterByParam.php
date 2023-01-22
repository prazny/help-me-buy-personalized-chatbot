<?php

namespace App\Services\Chat\Messaging\Filters;

use App\Models\Product;
use App\Services\Chat\Interfaces\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class FilterByParam extends Filter implements FilterInterface
{
    private array $params_id = [];

    public function __construct(array $attrs)
    {
        parent::__construct($attrs);
        foreach ($attrs as $param_id) {
            $this->params_id[] = $param_id;
        }
    }

    public function filter(Builder $builder): Builder
    {
        return $builder->whereHas('paramValues', function($q) {
            $q->whereIn('id', $this->params_id);
        });
    }

    public static function fromArray(array $array): FilterByParam
    {
        return new FilterByParam($array);
    }
}
