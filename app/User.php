<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','mobile', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * check if user is active
     */
    public function getIsActiveAttribute()
    {
        return ($this->status) ? true : false;
    }

    /**
     * get role label
     */
    public function getRoleLabelAttribute()
    {
        return config('roles.list')[$this->role];
    }

    /**
     * check if user is client
     */
    public function getIsClientAttribute()
    {
        if ( ! $this->isActive ) {
            return false;
        }
        return ($this->role == 1) ? true : false;
    }

    /**
     * check if user is Manager
     */
    public function getIsManagerAttribute()
    {
        if ( ! $this->isActive ) {
            return false;
        }
        return ($this->role == 2) ? true : false;
    }

    /**
     * check if user is client
     */
    public function getIsAdminAttribute()
    {
        if ( ! $this->isActive ) {
            return false;
        }
        return ($this->role == 3) ? true : false;
    }

    /**
     * Scope a query to only include active services.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where(['status' => 1]);
    }

    /**
     * get user orders
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
