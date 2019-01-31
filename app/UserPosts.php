<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPosts extends Model
{
    public function photos()
    {
        return $this->morphMany('App\UserPhoto', 'imageable');
    }
}
