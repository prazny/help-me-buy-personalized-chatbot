<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParamValue extends Model
{
    use HasFactory;
    protected $fillable = ['value'];
    public $timestamps = false;


    public function param(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Param::class);
    }
}
