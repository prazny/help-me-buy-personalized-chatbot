<?php

namespace App\Services\Chat\Messaging\Filters;

abstract class Filter
{
    protected array $attrs;

    public function __construct(array $attrs)
    {
        $this->attrs = $attrs;
    }

    public function toArray(): array
    {
        return $this->attrs;
    }

    public static function fromArray(array $array): FilterByParam
    {
        return new FilterByParam($array);

    }
}
