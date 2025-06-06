<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    protected $fillable = [
        'name',
        'country',
        'specialty',
        'description',
        'photo_path',
        'preview_path',
        'file_path',
    ];
}
