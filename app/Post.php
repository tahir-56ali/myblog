<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [

        'user_id',
        'category_id',
        'photo_id',
        'title',
        'body'

    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function photo()
    {
        return $this->belongsTo('App\Photos');
    }
}
