<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
	protected $hidden =['created_at'];
	//protected $visible = ['id', 'note','category_id',];
	protected $fillable = ['note', 'category_id'];

   public function categories()
   {
   	 return $this->belongsTo('App\Category');
   }
}
