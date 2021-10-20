<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    public function profile(){

        return $this->hasOne(Profile::class, 'auhtor_id', 'id');
        // return $this->hasOne(Profile::class,'id','author_id');
    }
}
