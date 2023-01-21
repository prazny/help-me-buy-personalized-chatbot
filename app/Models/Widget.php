<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'styles', 'domain', 'stories'];

    protected $casts = [
        'stories' => 'array',
        'styles' => 'array',
    ];

    public function fileSources() {
        return $this->morphedByMany(FileSource::class, 'source', 'widget_source');
    }
}
