<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'note_name',
        'note_short_description',
        'note_content',
    ];
}
