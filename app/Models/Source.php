<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    public function products(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Product::class, 'source');
    }
}
