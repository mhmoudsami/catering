<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes, HasTranslations;

    public $translatable = ['name'];

    /**
     * Get City Providers
     */
    public function providers()
    {
        return $this->belongsToMany('App\Proivder');
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
}
