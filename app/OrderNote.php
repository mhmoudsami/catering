<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderNote extends Model
{
    use SoftDeletes;

    /**
     * get note order relationship
     */
    public function order()
    {
    	return $this->belongsTo('App\Order');
    }

    /**
     * get note order relationship
     */
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
