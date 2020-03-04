<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{

	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

    /**
     * Get all of the model's comments.
     */
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }
}
