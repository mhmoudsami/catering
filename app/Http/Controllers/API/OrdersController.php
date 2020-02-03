<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;

use App\Http\Requests\StoreOrder;
use App\User;
use App\Order;
use App\Http\Resources\Order as OrderResource;

class OrdersController extends Controller
{
	/**
	 * create new order
	 */
    public function store(StoreOrder $request)
    {
    	# validate request
    	$validated = $request->validated();

    	# create the new order
    	$order = $request->store($validated);

    	# if order was not created 
    	if ( ! $order ) {
            return response()->json([
                'status'    =>  false,
                'message' => 'order was not created , please try again later',
            ]);
    	}

    	# order was created
        return response()->json([
            "status"    =>  true,
            "status_code" => Response::HTTP_OK,
            "order" => new OrderResource($order),
        ]);
    }
}
