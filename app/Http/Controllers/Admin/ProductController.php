<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Intervention\Image\ImageManagerStatic as Image;

use App\Product;
use App\Flavour;
use App\Category;
use App\Helper\FillableDropdown;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productsData = Product::orderBy('created_at', 'decs')->orderBy('updated_at', 'decs')->paginate(10);
        $sidebar_items = array(
            "Products List" => array('url' => URL::route('products.index'), 'icon' => '<i class="fa fa-users"></i>'),
            'Add New' => array('url' => URL::route('products.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );

        $FillableDropdown = new FillableDropdown();
        $active = $FillableDropdown->orderActiveKeyValue($default = 1);

        $productSearchData = [];

        return view('admin/product.list',  compact('productsData', 'productSearchData', 'active', 'sidebar_items'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sidebar_items = array(
            "Products List" => array('url' => URL::route('products.index'), 'icon' => '<i class="fa fa-users"></i>'),
            'Add New' => array('url' => URL::route('products.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );

        $categories = Category::all();
        $flavours = Flavour::all();

        $FillableDropdown = new FillableDropdown();
        $active = $FillableDropdown->active($default = 1);

        if($categories){
            $categories = $categories->pluck('name', 'id');
        }
        if($flavours){
            $flavours = $flavours->pluck('name', 'id');
        }

//        dd($categories);
        return view('admin/product.create', compact('categories', 'flavours', 'active', 'sidebar_items'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate

        $validator = Validator::make($request->all(), [
            'category_id'   => 'required',
            'name'          => 'required',
            'price'         => 'required',
        ]);

        if ($validator->fails()) {

            return redirect()->route('products.create')->withInput()->withErrors($validator);
        }

        // store
        if($request->image){
            $img = Image::make('assets/images/staticImage/'.$request->image)->resize(1000, 1000);

            $name = md5(uniqid() . microtime());

            $img->save('assets/images/usersImages/product/'.$name. '.png');

            $full_name = $name. '.png';
        } else{

            $img = Image::make('assets/images/staticImage/productDefaultImage.png')->resize(1000, 1000);

            $name = md5(uniqid() . microtime());

            $img->save('assets/images/usersImages/product/'.$name. '.png');

            $full_name = $name. '.png';

        }

        $data = [
            'category_id'       => $request->category_id,
            'name'              => $request->name,
            'weight'            => $request->weight,
            'price'             => $request->price,
            'min_age'           => $request->min_age,
            'max_age'           => $request->max_age,
            'tag'               => $request->tag,
            'image'             => $full_name,
            'active'            => $request->active,

        ];

        $flavour_id = $request->flavor;
        $product = Product::create($data);

        $product->flavors()->attach($flavour_id);

        return redirect()->back()->with('message', 'Product save successfully !');
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sidebar_items = array(
            "Products List" => array('url' => URL::route('products.index'), 'icon' => '<i class="fa fa-users"></i>'),
            'Add Product' => array('url' => URL::route('products.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
            'Edit Product' => array('url' => URL::route('products.edit', ['id'=>$id]), 'icon' => '<i class="fa fa-plus-circle"></i>'),
            'Its Orders' => array('url' => URL::route('products.show', ['id'=>$id]), 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );

        $FillableDropdown = new FillableDropdown();
        $active = $FillableDropdown->orderActiveKeyValue($default = 1);

        $products = Product::find($id);

        if ($products) {
            if($products->orders->count(1)){

                $productsData = $products->orders;
                $productSearchData = [];

                return view('admin/product.listProduct', compact('productsData', 'productSearchData', 'active', 'products', 'sidebar_items'));
            }
            else{
                return redirect()->back()->withErrors(['No order associated with it.']);

            }
        }else{
            return redirect()->back()->withErrors(['Product no longer exist.']);

        }
    }


    /**
     * Search method for Order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getList(Request $request)
    {
        $order_search = $request->admin_order_search;

        $sidebar_items = array(
            "Products List" => array('url' => URL::route('products.index'), 'icon' => '<i class="fa fa-users"></i>'),
            'Add Product' => array('url' => URL::route('products.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );

        $FillableDropdown = new FillableDropdown();
        $active = $FillableDropdown->orderActiveKeyValue($default = 1);


        if(!empty($order_search)){

            $productSearchData = Product::where('id', $order_search)->take(30)->get();


            if($productSearchData->isEmpty()){

                $productSearchData = Product::where('name', $order_search)->take(30)->get();

            }
            if($productSearchData->isEmpty()){

                $category_by_id = Category::orderBy('created_at', 'asc')
                    ->select('id')
                    ->where('name', $order_search)
                    ->get();

                $category_id = array_first($category_by_id, function ($value, $key) {
                    return $value ;
                });
                $category_id = array_get($category_id, 'id');


                if ($category_id) {

                    $productSearchData = Category::find($category_id)->products()->take(30)->get();
                }

            }

            if ($productSearchData->count() > 0) {

                $productsData = [];
                return view('admin/product.list', compact('productSearchData', 'productsData', 'active', 'sidebar_items'));

            }
        }
        else{

            return redirect()->route('admin/product.index')->withErrors(["This Order does not exist"]);

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

        $FillableDropdown = new FillableDropdown();
        $activeField = $FillableDropdown->orderActiveKeyValue($default = 1);


        $sidebar_items = array(
            "Products List" => array('url' => URL::route('products.index'), 'icon' => '<i class="fa fa-users"></i>'),
            'Add New' => array('url' => URL::route('products.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
            'Its Orders' => array('url' => URL::route('products.show', ['id'=>$id]), 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );

        $product = Product::findOrFail($id);
        if(count($product->flavors) > 0){
            $selectedFlavor = $product->flavors()->first()->id;
            $flavours = collect(Flavour::all())->keyBy('id');

        } else{

            $flavours = Flavour::all();
            if(count($flavours) > 0){

                $flavours = $flavours->pluck('name', 'id');
            }
        }

        $category = Category::all();
        if($category){
            $category = $category->pluck('name', 'id');
        }

//        dd($flavours, $selectedFlavor);
        return view('admin/product.edit', compact( 'sidebar_items', 'product', 'flavours', 'selectedFlavor', 'category', 'activeField'));
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

        // validate

        $validator = Validator::make($request->all(), [
            'category_id'   => 'required',
            'name'          => 'required',
            'price'         => 'required',
            'active'        => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('products.edit', $id)
                ->withInput()
                ->withErrors($validator);
        }



        if(!empty($request->image) && !empty($request->invisible)){

            $img = Image::make('assets/images/staticImage/'.$request->image)->resize(1000, 1000);
            $name = md5(uniqid() . microtime());
            $img->save('assets/images/usersImages/product/'.$name. '.png');
            $full_name = $name. '.png';
            
            if(File::isFile('images/usersImages/product/'.$request->invisible)){
                \File::delete('images/usersImages/product/'.$request->invisible);
            }

            $data = [
                'category_id'       => $request->category_id,
                'name'              => $request->name,
                'weight'            => $request->weight,
                'price'             => $request->price,
                'min_age'           => $request->min_age,
                'max_age'           => $request->max_age,
                'tag'               => $request->tag,
                'image'             => $full_name,
                'active'            => $request->active,

            ];
        }elseif(empty($request->image) && !empty($request->invisible)){

            $full_name = $request->invisible;
            $data = [
                'category_id'       => $request->category_id,
                'name'              => $request->name,
                'weight'            => $request->weight,
                'price'             => $request->price,
                'min_age'           => $request->min_age,
                'max_age'           => $request->max_age,
                'tag'               => $request->tag,
                'image'             => $full_name,
                'active'            => $request->active,

            ];
        }elseif(!empty($request->image) && empty($request->invisible)){

            $img = Image::make('assets/images/staticImage/'.$request->image)->resize(1000, 1000);
            $name = md5(uniqid() . microtime());
            $img->save('assets/images/usersImages/product/'.$name. '.png');
            $full_name = $name. '.png';

            if(File::isFile('images/usersImages/product/'.$request->invisible)){
                \File::delete('images/usersImages/product/'.$request->invisible);
            }

            $data = [
                'category_id'       => $request->category_id,
                'name'              => $request->name,
                'weight'            => $request->weight,
                'price'             => $request->price,
                'min_age'           => $request->min_age,
                'max_age'           => $request->max_age,
                'tag'               => $request->tag,
                'image'             => $full_name,
                'active'            => $request->active,

            ];
        }
        else{

            $data = [
                'category_id'       => $request->category_id,
                'name'              => $request->name,
                'weight'            => $request->weight,
                'price'             => $request->price,
                'min_age'           => $request->min_age,
                'max_age'           => $request->max_age,
                'tag'               => $request->tag,
                'active'            => $request->active,

            ];
//            return redirect()->back()->withErrors(['Select Product image']);

        }

        $flavour_id = $request->flavor;

        $product = Product::findOrFail($id);
        if(count($product) > 0){

            Product::where('id', $id)->update($data);

            $old_flavor = $product->flavors()->first();
//        dd($old_flavor->id);
            if(isset($old_flavor)){
                $product->flavors()->updateExistingPivot($old_flavor->id, ['flavour_id' =>$flavour_id, 'product_id' =>$id]);

            }

        }


        return redirect()->back()->with('message', 'Product save successfully !');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $product = Product::find($id);
//        dd($product);

        if ($product){
//            dd($product->order);
            if($product->orders->count(1)){
                return redirect()->back()->withErrors(['Can not delete this Product. Orders are associated with it.']);
            }
            else{


                $product = Product::findOrFail($id);
                $product->flavors()->detach($id);
                $product->delete();

                return redirect()->route('products.index');
            }
        }
        else
        {
            return false;
        }
    }


    /**
     * Remove the specified resource from directory.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyImageFromDir(Request $request, $id)
    {
        $ajax_data = Input::all();
        $image_name = $ajax_data['image_name'];


        if ($request->ajax()) {
            $response = array(
                'status' => 'success Ajax',
                'msg' => 'Setting created successfully',
            );

            if(File::isFile('images/usersImages/product/'.$image_name)){

                $ajax_data = Input::all();

                $category_id = $ajax_data['category_id'];
                $name = $ajax_data['name'];
                $weight = $ajax_data['weight'];
                $flavor = $ajax_data['flavor'];
                $price = $ajax_data['price'];
                $active = $ajax_data['active'];
                $max_age = $ajax_data['max_age'];
                $min_age = $ajax_data['min_age'];
                $tag = $ajax_data['tag'];
                $product_id = $ajax_data['product_id'];
                $full_name = null;
                
                $data = [
                    'category_id'   => $category_id,
                    'name'          => $name,
                    'weight'        => $weight,
                    'flavor'        => $flavor,
                    'price'         => $price,
                    'active'        => $active,
                    'max_age'       => $max_age,
                    'min_age'       => $min_age,
                    'tag'          => $tag,
                    'image'         => $full_name,
                ];


                $status = Product::where('id', $id)->update($data);

                if( $status == 1){

                    \File::delete('images/usersImages/product/'.$image_name);
                    return Response::json($response);

                }

                return Response::json(false);

            }
            return Response::json(false);

        } else {
            $response = array(
                'status' => 'success Http',
                'msg' => 'Setting created successfully',
            );

            return ($response);

        }
    }

}
