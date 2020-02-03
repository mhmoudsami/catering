<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;

class Order extends Model
{
	/**
	 * traits user by this model
	 */
    use SoftDeletes , Actionable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // 'date','name', 'email','mobile','location','notes','persons_count',
        // 'city_id','service_id',
    ];

	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'integer',
        'date' => 'date',
        'persons_count' => 'integer',
        'service_capacity' => 'integer',
        'service_price' => 'double',
        'service_extra_person_price' => 'double',
        'percentage_amount' => 'double',
        'subtotal' => 'double',
        'total' => 'double',
    ];

	/**
	 * get order provider
	 */
	public function provider()
	{
		return $this->belongsTo('App\Provider');
	}

	/**
	 * get order service
	 */
	public function service()
	{
		return $this->belongsTo('App\Service');
	}

	/**
	 * get order service
	 */
	public function user()
	{
		return $this->belongsTo('App\User');
	}

	/**
	 * get order service
	 */
	public function City()
	{
		return $this->belongsTo('App\City');
	}

	/**
	 * get order comments
	 */
	public function comments()
	{
		return $this->hasMany('App\OrderNote' , 'order_id' , 'id');
	}
}
