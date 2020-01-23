<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\City;
use App\Requirement;
use App\Http\Resources\City as CityResource;
use App\Http\Resources\Requirement as RequirementResource;

class AppController extends Controller
{
	/**
	 * get required app data for bootstraping
	 */
    public function index()
    {
    	$cities = City::where(['status' => 1])->get();
    	$requirements = Requirement::where(['status' => 1])->get();

    	$collection = collect([
    		'app_url' => config('app.url'),
    		'settings' => nova_get_settings(),
    		'cities'   => CityResource::collection($cities),
    		'requirements'   => RequirementResource::collection($requirements),
            'gender' => config('gender.list'),
    	]);

    	return $collection;
    }
}
