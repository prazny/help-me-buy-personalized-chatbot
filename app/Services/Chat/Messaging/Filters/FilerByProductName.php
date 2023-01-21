<?php

namespace App\Services\Chat\Messaging\Filters;

use App\Services\Chat\Interfaces\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class FilerByProductName extends Filter implements FilterInterface
{
    private array $names = [];

    public function __construct(array $attrs)
    {
        parent::__construct($attrs);
        foreach ($attrs as $param_id) {
            $this->names[] = $param_id;
        }
    }

    public function filter(Builder $builder): Builder
    {
        return $builder->where('name', 'like', "%{$this->names[0]}%");
    }
}
