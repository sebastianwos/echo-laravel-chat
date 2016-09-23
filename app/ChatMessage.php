<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = ['user_id', 'message'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y/m/d H:i:s');
    }
}
