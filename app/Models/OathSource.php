<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OathSource extends Source implements Parsable
{
    use HasFactory;
    protected $fillable = ['name', 'client_id', 'client_secret', 'access_token', 'refresh_token'];
}
