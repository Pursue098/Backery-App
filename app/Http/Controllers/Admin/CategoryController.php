<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Intervention\Image\ImageManagerStatic as Image;

use App\Category;
use App\Product;
use App\Helper\FillableDropdown;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $FillableDropdown = new FillableDropdown();
        $active = $FillableDropdown->orderActiveKeyValue($default = 1);

        $categoriesData = Category::orderBy('created_at', 'asc')->where('parent_id', null)->paginate(10);
        $sidebar_items = array(
            "Category List" => array('url' => URL::route('categories.index'), 'icon' => '<i class="fa fa-users"></i>'),
            'Add New' => array('url' => URL::route('categories.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );

        return view('admin/category.list',  compact('categoriesData', 'active', 'sidebar_items'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function listSubCategories($id)
    {

        $FillableDropdown = new FillableDropdown();
        $active = $FillableDropdown->orderActiveKeyValue($default = 1);


        $subCategoriesData = Category::orderBy('created_at', 'asc')
            ->where('parent_id', $id)
            ->paginate(10);


        if($subCategoriesData->count() > 0){

            if (isset($subCategoriesData[0]->id)){

                $category_id = $subCategoriesData[0]->id;
            }
        }


        if (isset($category_id)){
            $sidebar_items = array(
                "Category List" => array('url' => URL::route('categories.index'), 'icon' => '<i class="fa fa-users"></i>'),
                'Add Category' => array('url' => URL::route('categories.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
                'Edit Category' => array('url' => URL::route('categories.edit', ['id'=>$id]), 'icon' => '<i class="fa fa-plus-circle"></i>'),
                'Its products' => array('url' => URL::route('categories.show', ['id'=>$id]), 'icon' => '<i class="fa fa-plus-circle"></i>'),
            );
        } else{
            $sidebar_items = array(
                "Category List" => array('url' => URL::route('categories.index'), 'icon' => '<i class="fa fa-users"></i>'),
                'Add Category' => array('url' => URL::route('categories.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
                'Edit Category' => array('url' => URL::route('categories.edit', ['id'=>$id]), 'icon' => '<i class="fa fa-plus-circle"></i>'),
            );
        }

        $default_category = Category::orderBy('created_at', 'asc')
            ->where('id', $id)
            ->get();

//        dd($active);
        return view('admin/category.listSubCategories', compact('subCategoriesData', 'active', 'default_category', 'sidebar_items'));


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
            "Category List" => array('url' => URL::route('categories.index'), 'icon' => '<i class="fa fa-users"></i>'),
            'Add Category' => array('url' => URL::route('categories.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
            'Edit Category' => array('url' => URL::route('categories.edit', ['id'=>$id]), 'icon' => '<i class="fa fa-plus-circle"></i>'),
            'Its products' => array('url' => URL::route('categories.show', ['id'=>$id]), 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );

        $FillableDropdown = new FillableDropdown();
        $active = $FillableDropdown->orderActiveKeyValue($default = 1);

        $category = Category::find($id);

        if ($category) {
            $products = $category->products;

            if ( ! $products->isEmpty()) {

                $products = $category->products;

                return view('admin/category.listProduct', compact('products', 'active', 'category', 'sidebar_items'));
            }
            else{
                return redirect()->back()->withErrors(["This category havn't product."]);
            }
        }else{
            return redirect()->back()->withErrors(['Category no longer exist.']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sidebar_items = array(
            "Category List" => array('url' => URL::route('categories.index'), 'icon' => '<i class="fa fa-users"></i>'),
            'Add New' => array('url' => URL::route('categories.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );

        $FillableDropdown = new FillableDropdown();
        $active = $FillableDropdown->active($default = false);

        $category = Category::all()->pluck('name', 'id');
        $category = array_add($category, 'null', 'parent');

        $category = Category::all();
        if(! empty($category)){
            $category = $category->pluck('name', 'id')->prepend('Select Category','')->put('NULL','None');

        }

        $categoryParentData = Category::select('name', 'id')
            ->where('parent_id', null)
            ->where('active', 1)
            ->get();

        $categoryChildData = Category::select('name', 'id')
            ->whereNotNull('parent_id')
            ->where('active', 1)
            ->get();


        return view('admin/category.create', compact('category', 'categoryParentData', 'categoryChildData', 'active', 'sidebar_items'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'           => 'required',
            'parent_id'      => 'required',
        ]);


        if ($validator->fails()) {

            return redirect()->route('categories.create')->withInput()->withErrors($validator);
        }

        // store

        if(!empty($request->image)){

            $img = Image::make('assets/images/staticImage/'.$request->image);

            $name = md5(uniqid() . microtime());

            $img->save('assets/images/usersImages/category/'.$name. '.png');

            $full_name = $name. '.png';

        } else{

            $full_name = null;

        }
        if($request->parent_id == 'NULL'){

            $request->parent_id = null;
//            dd($request->parent_id);
        }


//        dd($request->name);
        $data = [
            'name'          => $request->name,
            'parent_id'     => $request->parent_id,
            'description'   => $request->description,
            'image'         => $full_name,
            'active'        => $request->active
        ];

        Category::create($data);
        return redirect()->route('categories.index');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sidebar_items = array(
            "Category List" => array('url' => URL::route('categories.index'), 'icon' => '<i class="fa fa-product-hunt" aria-hidden="true"></i>'),
            'Add Category' => array('url' => URL::route('categories.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
            'It products' => array('url' => URL::route('categories.show', ['id'=>$id]), 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );
//
        $FillableDropdown = new FillableDropdown();
//        $active = $FillableDropdown->active($default = false);
        $activeField = $FillableDropdown->orderActiveKeyValue($default = 1);

        $category = Category::findOrFail($id);
        $categories = Category::all()->pluck('name', 'id');
        $categories = array_add($categories, '', 'parent');

        if($category){

            $parent = $category->parent()->get();

            if(count($parent) > 0){
                if($parent[0]->id){
                    $parentCategoryId = $parent[0]->id;
                }
            }else{
                $parentCategoryId = $id;

            }

            if(isset($category->active)){
                $activeSlected = $category->active;
            }else{
                $activeSlected = 0;

            }

        }

        $categoryParentData = Category::select('name', 'id')
            ->where('parent_id', null)
            ->get();

        $categoryChildData = Category::select('name', 'id')
            ->whereNotNull('parent_id')
            ->get();

//        dd($activeField);
//        dd($activeField, $activeSlected);

        return view('admin/category.edit', compact('sidebar_items', 'category', 'categories', 'parentCategoryId', 'activeSlected',
            'categoryParentData', 'categoryChildData', 'activeField'));

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
            'name'           => 'required',
            'active'         => 'required',
            'parent_id'      => 'required',

        ]);

        if ($validator->fails()) {

            session()->flash('categoryError','Please select category. ');
            return response()->json([
                'selectCategory' => 'Please select category.'
            ], 500);

//            return redirect()->route('categories.edit', ['id' => $id])->withInput()->withErrors($validator);
        }

        if($request->parent_id == 'NULL'){

            $request->parent_id = null;
//            dd($request->parent_id);
        }
        elseif($request->parent_id == $id){

            $request->parent_id = null;

        }

        if($request->ajax()){

            if(!empty($request->image) && !empty($request->invisible_image_feild)){

//                dd($request->invisible_image_feild);

                $img = Image::make('assets/images/staticImage/'.$request->image);
                $name = md5(uniqid() . microtime());
                $img->save('assets/images/usersImages/category/'.$name. '.png');
                $full_name = $name. '.png';

                if(File::isFile('assets/images/usersImages/category/'.$request->invisible_image_feild)){
                    \File::delete('assets/images/usersImages/category/'.$request->invisible_image_feild);
                }

                $data = [
                    'name'          => $request->name,
                    'parent_id'     => $request->parent_id,
                    'description'   => $request->description,
                    'image'         => $full_name,
                    'active'        => $request->active

                ];


            } elseif (isset($request->image) && !empty($request->image)) {


                $img = Image::make('assets/images/staticImage/'.$request->image);
                $name = md5(uniqid() . microtime());
                $img->save('assets/images/usersImages/category/'.$name. '.png');
                $full_name = $name. '.png';


                if(File::isFile('assets/images/usersImages/category/'.$request->invisible_image_feild)){
                    \File::delete('assets/images/usersImages/category/'.$request->invisible_image_feild);
                }

                $data = [
                    'name'          => $request->name,
                    'parent_id'     => $request->parent_id,
                    'description'   => $request->description,
                    'image'         => $full_name,
                    'active'        => $request->active

                ];
            } elseif (empty($request->image) && empty($request->invisible_image_feild)) {


                if(File::isFile('assets/images/usersImages/category/'.$request->image)){
                    \File::delete('assets/images/usersImages/category/'.$request->image);
                }

                $full_name = null;

                $data = [
                    'name'          => $request->name,
                    'parent_id'     => $request->parent_id,
                    'description'   => $request->description,
                    'image'         => $full_name,
                    'active'        => $request->active

                ];
            }
            else{

                if (isset($request->invisible_image_feild) && !empty($request->invisible_image_feild)) {

//                    dd('Azam');

                    $full_name = $request->invisible_image_feild;

                    if(File::isFile('assets/images/usersImages/category/'.$request->image)){
                        \File::delete('assets/images/usersImages/category/'.$request->image);
                    }

                    $data = [
                        'name'          => $request->name,
                        'parent_id'     => $request->parent_id,
                        'description'   => $request->description,
                        'image'         => $full_name,
                        'active'        => $request->active

                    ];
                }
                else{

                    $full_name = null;

                    $data = [
                        'name'          => $request->name,
                        'parent_id'     => $request->parent_id,
                        'description'   => $request->description,
                        'image'         => $full_name,
                        'active'        => $request->active

                    ];
                }

            }

            Category::where('id', $id)->update($data);

            $response = array(
                'status' => 'success',
                'msg' => 'Setting created successfully',
            );

            return \Response::json($response);

        } else{

            return response()->json([
                'responseText' => 'Ajax call error'
            ], 500);
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $category = Category::find($id);
        $error = ['error' =>'Can not delete this category. Product are linked with it'];


        if ($category){
            if($category->products->count(1)){

                return redirect()->back()->withErrors(['Can not delete this category. Products are linked with it.']);
            }
            else{
                $category = Category::findOrFail($id);
                $category->delete();

                return redirect()->route('categories.index');
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
        $image = $ajax_data['image'];

        if ($request->ajax()) {
            $response = array(
                'status' => 'success Ajax',
                'msg' => 'Setting created successfully',
            );

        if(File::isFile('assets/images/usersImages/category/'.$image)){
            \File::delete('assets/images/usersImages/category/'.$image);

            $ajax_data = Input::all();

            $id = $ajax_data['id'];
            $name = $ajax_data['name'];
            $description = $ajax_data['description'];
            $parent_id = $ajax_data['parent_id'];
            $full_name = null;

            $data = [
                'name'          => $name,
                'parent_id'     => $parent_id,
                'description'   => $description,
                'image'         => $full_name
            ];

            $status = Category::where('id', $id)->update($data);

            if( $status == 1){

                \File::delete('assets/images/usersImages/category/'.$image);
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
