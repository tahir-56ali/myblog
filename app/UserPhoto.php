<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPhoto extends Model
{
    public function imageable()
    {
        return $this->morphTo();
    }
}
