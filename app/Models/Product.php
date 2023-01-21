<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['source_type', 'source_id', 'category_id', 'name', 'price', 'url', 'img_url'];

    public function source(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    public function paramValues(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(ParamValue::class, 'param_value_product', 'product_id', 'param_value_id');
    }

    public function category() {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
}
