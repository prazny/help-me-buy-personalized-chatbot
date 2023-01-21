<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Param extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public $timestamps = false;

    public function values() {
        return $this->hasMany(ParamValue::class, 'param_id');
    }
}
