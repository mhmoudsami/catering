<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model implements HasMedia
{
	use SoftDeletes, HasTranslations, HasMediaTrait;

    /**
     * translatable
     */
	public $translatable = ['name', 'description'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'requirements' => 'array',
    ];

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
     * Get the provider that owns the service.
     */
    public function provider()
    {
        return $this->belongsTo('App\Provider');
    }

    /**
     * Get Service Requirements
     */
    public function requirements()
    {
        return $this->belongsToMany('App\Requirement' , 'requirement_service');
    }
}
