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

    public function notes()
    {
        return $this->belongsTo('App\Models\Note');
    }

    public function delete()
    {
        dd(123);
        @unlink(public_path($this->link));
        parent::delete();
    }
}
