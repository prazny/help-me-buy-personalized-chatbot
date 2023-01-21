<?php

namespace App\Services\Chat\Messaging\Filters;

use App\Services\Chat\Interfaces\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class FilterByPrice extends Filter implements FilterInterface
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
        return $builder->where('price', '<' , $this->params_id[0])->where('price', '>', $this->params_id[1]);
    }
}
