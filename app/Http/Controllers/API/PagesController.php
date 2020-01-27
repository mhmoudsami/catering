<?php

namespace App\Http\Controllers\api;

use App\Page;
use App\Http\Resources\Page as PageResource;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use App\Transformers\PageTransformer;
use Illuminate\Http\Response;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::active()->orderBy('order' , 'DESC')->get();

        return PageResource::collection($pages);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $page = Page::active()->first();

        return new PageResource($page); 
    }
}
