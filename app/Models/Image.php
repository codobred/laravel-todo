<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'note_id',
        'link',
    ];

    public $timestamps = false;
}
