<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Translatable\HasTranslations;

class Provider extends Authenticatable implements HasMedia
{
    use Notifiable, SoftDeletes, HasTranslations, HasMediaTrait;

    public $translatable = ['name', 'description' , 'responsible_name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
        'cities' => 'array',
        'services' => 'array',
    ];

    /**
     * check if user is active
     */
    public function getIsActiveAttribute()
    {
        return ($this->status) ? true : false;
    }

    /**
     * register media conversion
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(130)
            ->height(130);
    }

    /**
     * register media collection
     */
    public function registerMediaCollections()
    {
        $this->addMediaCollection('image')->singleFile();
    }

    /**
     * Get the services for the provider.
     */
    public function services()
    {
        return $this->hasMany('App\Service');
    }

    /**
     * Get Provider Cities
     */
    public function cities()
    {
        return $this->belongsToMany('App\City');
    }
}
