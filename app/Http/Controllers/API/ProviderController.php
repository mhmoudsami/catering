<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service;
use App\Provider;
use App\Http\Resources\Provider as ProviderResource;
use App\Http\Resources\Service as ServiceResource;
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

    /**
     * get single provider
     */
    public function show($provider)
    {
        $provider = Provider::where('id' , $provider);

        // eager load with active services
        $provider->with([
            'services' => function($query){
                $query->active()->orderBy('order' , 'desc');
            }
        ]);

        $provider = $provider->active()->first();


        if ( ! $provider ) {
            throw new \Exception("Error Processing Request", 1);
            
        }

        return new ProviderResource($provider);
    }

    /**
     * get provider services
     */
    public function services($provider)
    {
        $services = Service::where(['provider_id' => $provider])->active()->get();


        return ServiceResource::collection($services);
    }

    /**
     * get provider single service details
     */
    public function service($provider , $service)
    {
        $service = Service::where(['provider_id' => $provider , 'id' => $service])->active();

        $service->with([
            'requirements' => function($query){
                $query->active()->orderBy('order' , 'desc');
            }
        ]);

        $service = $service->first();

        return new ServiceResource($service);
    }
}
