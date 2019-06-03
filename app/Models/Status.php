<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //一个用户可以有多条微博
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
