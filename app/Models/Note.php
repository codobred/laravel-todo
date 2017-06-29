<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'short_description',
        'content',
    ];

    public function image()
    {
        return $this->hasMany('App\Models\Image');
    }

    public function delete()
    {
        foreach ($this->image() as $image)
            $image->delete();
        parent::delete();
    }
}
