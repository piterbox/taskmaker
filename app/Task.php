<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'name', 'description', 'state', 'time', 'seconds', 'time_left', 'user_id'
    ];

    public function user(){
    	return $this->belongsTo('User');
    }
}
