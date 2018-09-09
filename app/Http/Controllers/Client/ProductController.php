<?php

namespace App\Http\Controllers\Client;

use App\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Intervention\Image\ImageManagerStatic as Image;

use App\Product;
use App\Flavour;
use App\Configuration;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

        $products = Product::orderBy('created_at', 'asc')->where('id', $id)->get();

        $branch = Branch::all();
//        if($branch){
//            $branch = $branch->pluck('name', 'id');
//        }

        $flavour = Flavour::orderBy('created_at', 'asc')->get();

        if($flavour){
            $flavours = $flavour;
        }

        $remarksLimit = Configuration::select('value')->where('key', 'remarks_value')->get();

        if($remarksLimit){
            if(isset($remarksLimit[0]->value)){
                $remarksLimits = $remarksLimit[0]->value;

            }
        }


        if (!empty($products) && !empty($branch) && !empty($flavours) && !empty($remarksLimits)){
            $array_response = Response::json(array('products'=>$products,'branch'=>$branch, 
                'flavours'=>$flavours, 'remarksLimits'=>$remarksLimits));

            return $array_response;
        }elseif (!empty($products) && !empty($branch) && !empty($flavours)){
            $array_response = Response::json(array('products'=>$products,'branch'=>$branch,
                'flavours'=>$flavours));

            return $array_response;
        }elseif (!empty($products) && !empty($branch)){
            $array_response = Response::json(array('products'=>$products,'branch'=>$branch));

            return $array_response;
        }elseif (!empty($products)){
            $array_response = Response::json(array('products'=>$products));

            return $array_response;
        }else{

            $response = array(
                'status' => 'failed',
            );
            return \Response::json($response);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
