<?php

namespace App\Services\Chat\Interfaces;

use App\Models\Product;
use App\Services\Chat\Messaging\Filters\FilterByParam;
use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{
    public function __construct(array $attrs);
    public function filter(Builder $builder): Builder;
    public function toArray(): array;
    public static function fromArray(array $array): FilterInterface;

}
