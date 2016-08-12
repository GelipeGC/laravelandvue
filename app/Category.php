<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function notes()
    {
    	return $this->hasMany('App\Note');
    }
}
