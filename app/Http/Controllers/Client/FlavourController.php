<?php

namespace App\Http\Controllers\Client;

use App\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Response;


use App\Flavour;
use App\Product;
use App\Configuration;

class FlavourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $branch = Branch::all();
        $flavour = Flavour::orderBy('created_at', 'asc')->get();
        $product = Product::orderBy('created_at', 'asc')->get();

        $remarksLimit = Configuration::select('value')->where('key', 'remarks_value')->get();

        if($remarksLimit){
            $remarksLimits = $remarksLimit[0]->value;
        }

        if (!empty($branch) && !empty($flavour) && !empty($remarksLimits)){
            $array_response = Response::json(array('products'=>$product, 'branch'=>$branch, 'flavours'=>$flavour,
                'remarksLimits'=>$remarksLimits));

            return $array_response;

        }else{

            $response = array(
                'status' => 'failed',
            );
            return \Response::json($response);
        }
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    
    }

}
