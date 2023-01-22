<?php

namespace App\Services\Chat\Messaging\Filters;

use App\Services\Chat\Interfaces\FilterInterface;

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

}
