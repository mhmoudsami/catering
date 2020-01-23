<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Provider;
use App\Http\Resources\Provider as ProviderResource;
use App\Http\Resources\ProviderCollection;

class ProviderController extends Controller
{
	/**
	 * get all providers
	 */
    public function index()
    {
    	// active providers
    	$providers = Provider::active();

    	// eager load with active services
    	$providers->with([
    		'services' => function($query){
    			$query->active()->orderBy('order' , 'desc');
    		}
    	]);

    	// and only providers who have active services
    	$providers->whereHas('services' , function($query){
    		$query->active();
    	});

    	// by default return all providers from any city
    	// if request has cities ? filter providers who have active cities that matchs user selected cities
    	if ( $cities = request('cities') ) {
	    	$providers->whereHas('cities' , function($query)use($cities){
	    		$query->active()->whereIn('cities.id'  , $cities);
	    	});
    	}

    	return new ProviderCollection($providers->paginate(8));
    }
}
