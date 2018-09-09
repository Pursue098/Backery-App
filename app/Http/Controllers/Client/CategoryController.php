<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Intervention\Image\ImageManagerStatic as Image;

use App\Category;
use App\Product;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $categoryData = Category::where('parent_id', null)->where('active', 1)->get();
        
        return $categoryData;

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
    public function show($category_id)
    {

        $categoryData = Category::orderBy('created_at', 'asc')->where('parent_id', $category_id)->get();

        $category1 = Category::orderBy('created_at', 'asc')->select('id', 'name')->where('id', $category_id)->get();

        $product_images = Product::orderBy('created_at', 'asc')->select('image')->where('category_id', $category_id)->get();

        $category = Category::find($category_id);

        $child_branch = array();

        if(count($category1)) {
            $cat[] = $category->getAllSiblings($category1, $child_branch);
        }

        $collection = collect($cat);
//        dd('$collection', $collection);
//        $breadcrumb[] = $cat;

        if ($category) {
            $products = $category->products;
            if (! $products->isEmpty()) {

                $products = $category->products;
            }
        }


        if(isset($product_images)){

            foreach ($product_images as $image){

                if (!isset($image->image)){
                    $image->image = 'images.png';
                }
            }
        }

        if (! $products->isEmpty() || ! $categoryData->isEmpty()){
            $array_response = Response::json(array('sub_categories'=>$categoryData,'category_products'=>$products, 'collection'=>$collection, 'product_images'=>$product_images));

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
