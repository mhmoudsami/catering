<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
	use SoftDeletes;

    /**
     * Get the owning commentable model.
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * get user
     */
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
