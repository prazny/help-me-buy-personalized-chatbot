<?php

namespace App\Services\Chat\Messaging\Filters;

use App\Services\Chat\Interfaces\FilterInterface;
use Illuminate\Database\Query\Builder;

class FilterByCategory extends Filter implements FilterInterface
{
    private array $categories_id = [];

    public function __construct(array $attrs)
    {
        parent::__construct($attrs);
        foreach ($attrs as $param_id) {
            $this->categories_id[] = $param_id;
        }
    }

    public function filter(Builder $builder): Builder
    {
        return $builder->whereIn('category_id', $this->categories_id);
    }
}
