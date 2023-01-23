<?php

namespace App\Models;

use App\enums\FileSourceExtensionEnum;
use App\enums\FileSourceTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class FileSource extends Source implements Parsable, HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $fillable = ['name', 'type', 'path'];
    protected $casts = [
        'type' => FileSourceTypeEnum::class,
        'extension' => FileSourceExtensionEnum::class,
        'errors' => 'array'
    ];

    public function products(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Product::class, 'source');
    }

    public function widgets()
    {
        return $this->morphToMany(Widget::class, 'source', 'widget_source');
    }

}
