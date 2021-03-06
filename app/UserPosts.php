<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPosts extends Model
{
    public function photos()
    {
        return $this->morphMany('App\UserPhoto', 'imageable');
    }

    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }
}
