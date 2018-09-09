<?php

namespace App\Http\Controllers\Client;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Intervention\Image\ImageManagerStatic as Image;

use Carbon\Carbon;

use App\Order;
use App\Branch;
use App\Product;
use App\User;
use App\Flavour;
use App\Configuration;
use App\Mail\OrderShipped;

class OrderController extends Controller
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

        if(isset($request->formData['product_name'])){

            $product_name = $request->formData['product_name'];
        }else{

            $product_name = '';
        }

        if(isset($request->formData['cust_name'])){

            $cust_name = $request->formData['cust_name'];

        } else{
            $cust_name = '';
        }

        if(isset($request->formData['cust_email'])){

            $cust_email = $request->formData['cust_email'];
        }else{

            $cust_email = '';
        }

        if(isset($request->formData['cust_phone'])){

            $cust_phone = $request->formData['cust_phone'];
        }else{

            $cust_phone = '';
        }

        if(isset($request->formData['cust_address'])){

            $cust_address = $request->formData['cust_address'];
        }else{

            $cust_address = '';
        }

        if(isset($request->data['product_price'])){

            $product_price = $request->data['product_price'];
        }else{

            $product_price = 0;
        }

        if(isset($request->data['advance_price'])){

            $advance_price = $request->data['advance_price'];
        }else{

            $advance_price = 0;
        }

        if(isset($request->data['order_delivery_date'])){

            $delivery_date = $request->data['order_delivery_date'];
        }else{

            $delivery_date = '';
        }
        if(isset($request->data['order_delivery_time'])){

            $delivery_time = $request->data['order_delivery_time'];
        }else{

            $delivery_time = '';
        }

        if(isset($request->data['file_name'])){

            $file_name = $request->data['file_name'];

        }else{

            $file_name = null;
        }

        if(isset($request->formData['flavor1'])){

            $flavor1_id = $request->formData['flavor1'];
            $flavor1 = DB::table('flavours')->select('name')->where('id', $flavor1_id)->get();

        } else{
            $flavor1_id = null;
            $flavor1 = null;
        }

        if(isset($request->formData['flavor2'])){

            $flavor2_id = $request->formData['flavor2'];
            $flavor2 = DB::table('flavours')->select('name')->where('id', $flavor2_id)->get();

        } else{
            $flavor2_id = null;
            $flavor2 = null;
        }

        if(isset($request->data['priority'])){

            $priority = $request->data['priority'];

        } else{
            $priority = 1;
        }

        if(isset($request->formData['order_status'])){

            $order_status = $request->formData['order_status'];

        } else{
            $order_status = 0;
        }

        if(isset($request->data['weight'])){

            $weight = $request->data['weight'];

        } else{
            $weight = null;
        }

        if(isset($request->data['quantity'])){

            $quantity = $request->data['quantity'];

        } else {
            $quantity = 1;
        }
       
        if(isset($request->data['paymentType'])){

            $paymentType = $request->data['paymentType'];

        } else {
            $paymentType = 2;
        }
        
        if(isset($request->data['remarks'])){

            $remarks = $request->data['remarks'];

        } else {
            $remarks = null;
        }


//        $token_code = str_random(20);// Will return something like 53ef6b
        $token_code = mt_rand(15, 0xffffffffeeee);
//        $count = strlen ( $code );

        $dt = new \DateTime($delivery_date); // <== instance from another API
        $carbon = Carbon::instance($dt);
        $delivery_date = $carbon->toDateTimeString();

        $branchCode = Configuration::where('key', 'branch_id')->select('id', 'value')->get();
        $branchCode = $branchCode[0]->value;

        $env_branch_id = env('BRANCH_ID');

        $branch_id = Configuration::get();

        if (!isset($branch_id[0]->value)){

            if (isset($env_branch_id)){

                $branch_id = $env_branch_id;
            }else{
                $branch_id = 1;
            }
        }else{
            $branch_id = $branch_id[0]->value;
        }


        if(!empty($request->data['product_id'])) {

            $active = 1;
        }else{

            $active = 0;
        }

        $authentication = \App::make('authenticator');
        $user = $authentication->getLoggedUser();

        if (isset($user)) {

            $user_id = $user->id;
        } else {
            $user_id = 0;

        }

        $data = [
            'cust_name'             => $cust_name,
            'cust_email'            => $cust_email,
            'cust_address'          => $cust_address,
            'cust_phone'            => $cust_phone,
            'weight'                => $weight,
            'quantity'              => $quantity,
            'price'                 => $product_price,
            'advance_price'         => $advance_price,
            'payment_type'          => $paymentType,
            'order_status'          => $order_status,
            'delivery_date'         => $delivery_date,
            'delivery_time'         => $delivery_time,
            'token_code'            => $token_code,
            'remarks'               => $remarks,
            'branch_id'             => $branch_id,
            'branch_code'           => $branchCode,
            'user_id'               => $user_id,
            'active'                => $active,
            'priority'              => $priority,

        ];

        if(!empty($request->data['product_id']) && !empty($request->data['normalForm']) ){
            $product_id = $request->data['product_id'];
            $order = Order::create($data);

            if($order){
                $order_product = $order->products()->attach($product_id);

                if ( isset($flavor1_id) &&  isset($flavor2_id)){

                    if($flavor1_id == $flavor2_id){

                        $order_flavor  = $order->flavors()->attach([$flavor1_id]);
                    } else{
                        $order_flavor  = $order->flavors()->attach([$flavor1_id, $flavor2_id]);
                    }

                } elseif (isset($flavor1_id) ){

                    if (isset($flavor2_id) ){

                        $order_flavor  = $order->flavors()->attach([$flavor1_id, $flavor2_id]);
                    }else{

                        $order_flavor  = $order->flavors()->attach($flavor1_id);
                    }

                } elseif (isset($flavor2_id) ){

                    if (isset($flavor1_id) ){

                        $order_flavor  = $order->flavors()->attach([$flavor1_id, $flavor2_id]);
                    }else{

                        $order_flavor  = $order->flavors()->attach($flavor2_id);
                    }

                }

            }

            if(! isset($order_product) && ! isset($order_flavor)){

                $order = Order::orderBy('created_at', 'desc')->first();
                $product = Product::find($product_id);

                $image_path = asset(config('images.product_image_path'));

                $view = View::make('client.base.viewRender',  compact('order', 'product', 'image_path', 'flavor1', 'flavor2'));


                $response = array(
                    'status' => 'success',
                    'page' => $view->render(),
                    'order' => $order,
                    'product' => $product,
                );
                return \Response::json($response);
            }else{

                $response = array(
                    'status' => 'failed',
                );
                return \Response::json($response);
            }
        }else{

            // store
            if($file_name){
                $img = Image::make('assets/images/staticImage/'.$file_name)->resize(1000, 1000);

                $name = md5(uniqid() . microtime());

                $img->save('assets/images/usersImages/product/'.$name. '.png');

                $full_name = $name. '.png';
            } else{
                $full_name = null;

            }

            $custom_category = Category::where('parent_id', null)->where('active', 0)->first();

            $custom_category_id = $custom_category->id;

            $product_data = [
                'category_id'       => $custom_category_id,
                'name'              => $product_name,
                'weight'            => $weight,
                'price'             => $product_price,
                'image'             => $full_name,
                'active'            => 0,
            ];

            $data = [
                'cust_name'             => $cust_name,
                'cust_email'            => $cust_email,
                'cust_address'          => $cust_address,
                'cust_phone'            => $cust_phone,
                'weight'                => $weight,
                'quantity'              => $quantity,
                'price'                 => $product_price,
                'advance_price'         => $advance_price,
                'payment_type'          => $paymentType,
                'order_status'          => $order_status,
                'delivery_date'         => $delivery_date,
                'delivery_time'         => $delivery_time,
                'token_code'            => $token_code,
                'remarks'               => $remarks,
                'branch_id'             => $branch_id,
                'branch_code'           => $branchCode,
                'user_id'               => $user_id,
                'active'                => $active,
                'priority'              => $priority,
                'image'                 => $full_name,

            ];

            $product = Product::create($product_data);

            if (isset($product)){

                $product_id = Product::orderBy('created_at', 'desc')->first();
                $product_id = $product_id->id;

            }

            $order = Order::create($data);

            if($order && isset($product_id)){

                $order_product = $order->products()->attach($product_id);

                if ( isset($flavor1_id) &&  isset($flavor2_id)){

                    if($flavor1_id == $flavor2_id){

                        $order_flavor  = $order->flavors()->attach([$flavor1_id]);
                    } else{
                        $order_flavor  = $order->flavors()->attach([$flavor1_id, $flavor2_id]);
                    }

                } elseif (isset($flavor1_id) ){

                    if (isset($flavor2_id) ){

                        $order_flavor  = $order->flavors()->attach([$flavor1_id, $flavor2_id]);
                    }else{

                        $order_flavor  = $order->flavors()->attach($flavor1_id);
                    }

                } elseif (isset($flavor2_id) ){

                    if (isset($flavor1_id) ){

                        $order_flavor  = $order->flavors()->attach([$flavor1_id, $flavor2_id]);
                    }else{

                        $order_flavor  = $order->flavors()->attach($flavor2_id);
                    }

                }

            }
            $order = Order::orderBy('created_at', 'desc')->first();
            $product = Product::find($product_id);

            $page = View::make('client.base.viewRender',  compact('order', 'data', 'product', 'flavor1', 'flavor2'));

            $response = array(
                'status' => 'success',
                'order' => $order,
                'product' => $product,
                'page' => $page->render(),
            );
            return \Response::json($response);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
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
