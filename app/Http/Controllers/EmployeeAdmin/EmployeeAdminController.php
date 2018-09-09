<?php

namespace App\Http\Controllers\EmployeeAdmin;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;

use Carbon\Carbon;

use App\Order;
use App\Branch;
use App\Flavour;
use App\Product;
use App\Configuration;

use App\Helper\FillableDropdown;


class EmployeeAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $sidebar_items = array(
            "Order List" => array('url' => URL::route('v1.employee_admin.order.index'), 'icon' => '<i class="fa fa-users"></i>'),
            'Add New' => array('url' => URL::route('v1.employee_admin.order.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );

        $FillableDropdown = new FillableDropdown();
        $orderStatus_4 = $FillableDropdown->orderStatusKeyValue($default = 4);
        $orderStatus_3 = $FillableDropdown->orderStatusKeyValue($default = 3);
        $priority = $FillableDropdown->orderPriorityKeyValue($default = 3);
        $priority_4 = $FillableDropdown->orderPriorityKeyValue($default = 4);
        $order_status_key = 'all';
        $priority_4_key = 'all';

        $orderSearchData = [];

        $ajax_data = Input::all();
        $url = $request->path();

        $authentication = \App::make('authenticator');
        $authentication_helper = \App::make('authentication_helper');

        $branch_ids = array();
        $branch_id = null;
        $managerPermissions = '_manager';
        $adminPermissions = '_superadmin';

        $user = $authentication->getLoggedUser();

        if (isset($user)){


            $perm    = $user->permissions;
            $user_id = $user->id;

            if (isset($perm)){

                foreach($perm as $key=> $val)
                {
                    $permission_name = $key;
                }
            }
            $authentication_helper->hasPermission($perm);
            if (isset($permission_name) && isset($user_id)){

                if ($permission_name == $adminPermissions){

                    $branches = Branch::all();
                    if(! empty($branches)){
                        $branches = $branches->pluck('name', 'id')->prepend('All Branches','all');
                    }

                    if(! empty($branches)){
                        $result = Branch::all()->pluck('id');
                    }

                    if (isset($result) && count($result) > 0){

                        if(isset($result) && count($result) > 1) {
                            foreach($result as $key)
                            {
                                $branch_ids[] = $key;
                            }
                        }else{
                            $branch_id = $result[0]->branch_id;
                        }
                    }else{
                        $ordersData1 = null;
                    }

                }elseif($permission_name == $managerPermissions){

                    $user = User::find($user_id);

                    if ($user) {

                        if (isset($user->branches)) {

                            if ($user->branches()->count() > 0) {
                                $result = $user->branches()->select('branch_id')->get();
                                $branches = $user->branches();

                                if(isset($branches) && $branches->count() > 1){

                                    $branches = $branches->pluck('name', 'id')->prepend('All Branches','all');

                                }else{

                                    $branches = null;
                                }

                            }
                        }
                    }

                    if (isset($result) && count($result) > 0){

                        if(isset($result) && count($result) > 1) {
                            foreach($result as $key)
                            {
                                $branch_ids[] = $key->branch_id;

                            }
                        }else{
                            $branch_id = $result[0]->branch_id;
                        }
                    }else{
                        $ordersData1 = null;
                    }
                }
            }

//            dd($branches);
            if(isset($branch_ids) && count($branch_ids) > 1){

                    $b_id = substr($url, strrpos($url, '/') + 1);

                    if(isset($b_id) && $b_id  == 'all') {

                        $ordersData1 = Order::orderBy('created_at', 'decs')
                            ->whereIn('branch_id', $branch_ids)
                            ->orderBy('priority', 'asc')
                            ->paginate(10);

                        $returnHTML = view('employeeAdmin/orders.orderViewRender1', compact('ordersData1', 'orderSearchData', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();
                        return $returnHTML;

                    }elseif(isset($b_id) && is_numeric($b_id)){

                        $ordersData1 = Order::orderBy('created_at', 'decs')
                            ->where('branch_id', $b_id)
                            ->orderBy('priority', 'asc')
                            ->paginate(10);

                        $returnHTML = view('employeeAdmin/orders.orderViewRender1', compact('ordersData1', 'orderSearchData', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();
                        return $returnHTML;

                    }else{

                        $ordersData1 = Order::orderBy('created_at', 'decs')
                            ->whereIn('branch_id', $branch_ids)
                            ->orderBy('priority', 'asc')
                            ->paginate(10);

                        return view('employeeAdmin/orders.list',  compact('ordersData1', 'orderSearchData', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'));
                    }

                } 
            else{

                    $b_id = substr($url, strrpos($url, '/') + 1);

                    if(isset($b_id) && $b_id  == 'all') {

                        $ordersData1 = Order::orderBy('created_at', 'decs')
                            ->where('branch_id', $branch_id)
                            ->orderBy('priority', 'asc')
                            ->paginate(10);

                        $returnHTML = view('employeeAdmin/orders.orderViewRender1', compact('ordersData1', 'orderSearchData', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();
                        return $returnHTML;

                    }elseif(isset($b_id) && is_numeric($b_id)) {

                        $ordersData1 = Order::orderBy('created_at', 'decs')
                            ->where('branch_id', $b_id)
                            ->orderBy('priority', 'asc')
                            ->paginate(10);

                        $returnHTML = view('employeeAdmin/orders.orderViewRender1', compact('ordersData1', 'orderSearchData', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();
                        return $returnHTML;

                    }else {

                        $ordersData1 = Order::where('branch_id', $branch_id)
                            ->orderBy('priority', 'asc')
                            ->paginate(10);

                        return view('employeeAdmin/orders.list', compact('ordersData1', 'orderSearchData', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'));
                    }

                }
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
            "orders List" => array('url' => URL::route('v1.employee_admin.order.index'), 'icon' => '<i class="fa fa-users"></i>'),
            'Add New' => array('url' => URL::route('v1.employee_admin.order.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );
        $products = Product::all();
        $branch = Branch::all();
        $user = User::all();
        $flavour = Flavour::all();

        if(! empty($products)){
            $product = Product::all()->pluck('name', 'id');
        }

        if(! empty($branch)){
            $branch = Branch::all()->pluck('name', 'id');
        }
        if(! empty($user)){
            $user = User::all()->pluck('email', 'id');
        }
        if(! empty($flavour)){
            $flavour = Flavour::all()->pluck('name', 'id');
            $flavour = Flavour::all()->pluck('name', 'id')->prepend('Select Flavor','');

        }

        $FillableDropdown = new FillableDropdown();
        $priority = $FillableDropdown->priority($default = false);
        $orderStatus = $FillableDropdown->orderStatus($default = 3);
        $orderType = $FillableDropdown->orderType($default = false);
        $paymentStatus = $FillableDropdown->paymentStatus($default = false);
        $paymentType = $FillableDropdown->paymentType($default = false);
        $active = $FillableDropdown->active($default = false);

        return view('employeeAdmin/orders.create',
            compact('sidebar_items', 'branch', 'product', 'user',
                'flavour', 'priority', 'orderStatus', 'active', 'orderType',
                'paymentStatus', 'paymentType'));
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
            'product_id'            => 'required',
            'cust_name'             => 'required',
            'weight'                => 'required',
            'quantity'              => 'required',
            'price'                 => 'required',
            'order_status'          => 'required',
            'branch_id'             => 'required',
            'priority'              => 'required',
        ]);

        if ($validator->fails()) {

            return redirect()->route('v1.employee_admin.order.create')->withInput()->withErrors($validator);
        }

        // store

        if(!empty($request->delivery_date)){

//            $delivery_date = Carbon::createFromFormat('Y-m-d', $request->delivery_date);
//            $delivery_date = $delivery_date->toDateTimeString();

            $dt = new \DateTime($request->delivery_date); // <== instance from another API
            $carbon = Carbon::instance($dt);
            $delivery_date = $carbon->toDateTimeString();

        } else{
            $delivery_date = null;
        }

        $token_code = mt_rand(15, 0xffffffffeeee);

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

        $authentication = \App::make('authenticator');
        $user = $authentication->getLoggedUser();

        if (isset($user)) {

            $user_id = $user->id;
        } else {
            $user_id = 0;

        }

        $data = [
            'cust_name'             => $request->cust_name,
            'cust_email'            => $request->cust_email,
            'cust_address'          => $request->cust_address,
            'cust_phone'            => $request->cust_phone,
            'weight'                => $request->weight,
            'quantity'              => $request->quantity,
            'price'                 => $request->price,
            'advance_price'         => $request->advance_price,
            'payment_type'          => $request->payment_type,
            'payment_status'        => $request->payment_status,
            'order_type'            => $request->order_type,
            'order_status'          => $request->order_status,
            'delivery_date'         => $delivery_date,
            'delivery_time'         => $request->delivery_time,
            'token_code'            => $token_code,
            'remarks'               => $request->remarks,
            'branch_id'             => $branch_id,
            'branch_code'           => $branchCode,
            'user_id'               => $user_id,
            'active'                => $request->active,
            'priority'              => $request->priority,

        ];


        $flavor1_id = $request->flavor1_id;
        $flavor2_id = $request->flavor2_id;

        $product_id = $request->product_id;


        $order = Order::create($data);

        if($order){

            $order->products()->attach($product_id);

            if ( !empty($flavor1_id) &&  !empty($flavor2_id)){

                //If both flavors are same
                if($flavor1_id == $flavor2_id){

                    $order->flavors()->attach($flavor1_id);

                }else{

                    $order->flavors()->attach($flavor1_id);
                    $order->flavors()->attach($flavor2_id);

                }

            } elseif (!empty($flavor1_id) ){


                if (!empty($flavor2_id) ){


//                    $order->flavors()->attach([$flavor1_id, $flavor2_id]);
                    $order->flavors()->attach($flavor1_id);
                    $order->flavors()->attach($flavor2_id);

                }else{


                    $order->flavors()->attach($flavor1_id);

                }


            } elseif (!empty($flavor2_id) ){

                if (!empty($flavor1_id) ){

                    $order->flavors()->attach($flavor1_id);
                    $order->flavors()->attach($flavor2_id);
                }else{

                    $order->flavors()->attach($flavor2_id);
                }

            }

        }

        return redirect()->route('v1.employee_admin.order.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $authentication = \App::make('authenticator');
        $authentication_helper = \App::make('authentication_helper');

        $branch_ids = array();
        $branch_id = null;
        $managerPermissions = '_manager';
        $adminPermissions = '_superadmin';

        $user = $authentication->getLoggedUser();

        if (isset($user)){

            $perm    = $user->permissions;
            $user_id = $user->id;

            if (isset($perm)){

                foreach($perm as $key=> $val)
                {
                    $permission_name = $key;
                }
            }

            $authentication_helper->hasPermission($perm);

            if (isset($permission_name) && isset($user_id)){

                if ($permission_name == $adminPermissions){

                    $branches = Branch::all();
                    if(! empty($branches)){
                        $branches = $branches->pluck('name', 'id')->prepend('All Branches','all');
                    }

                    if(! empty($branches)){
                        $result = Branch::all()->pluck('id');
                    }

                    if (isset($result) && count($result) > 0){

                        if(isset($result) && count($result) > 1) {
                            foreach($result as $key)
                            {
                                $branch_ids[] = $key;
                            }
                        }else{
                            $branch_id = $result[0]->branch_id;
                        }
                    }else{
                        $ordersData1 = null;
                    }

                }elseif($permission_name == $managerPermissions){

                    $user = User::find($user_id);

                    if ($user) {

                        if (isset($user->branches)) {

                            if ($user->branches()->count() > 0) {
                                $result = $user->branches()->select('branch_id')->get();
                                $branches = $user->branches();

                                if(isset($branches) && $branches->count() > 1){

                                    $branches = $branches->pluck('name', 'id')->prepend('All Branches','all');

                                }else{

                                    $branches = null;
                                }

                            }
                        }
                    }

                    if (isset($result) && count($result) > 0){

                        if(isset($result) && count($result) > 1) {
                            foreach($result as $key)
                            {
                                $branch_ids[] = $key->branch_id;

                            }
                        }else{
                            $branch_id = $result[0]->branch_id;
                        }
                    }else{
                        $ordersData1 = null;
                    }
                }
            }


            $ajax_data = Input::all();
            $url = $request->path();
            if(isset($url)){

                $b_id = substr($url, strrpos($url, '/') + 1);
            }


            $sidebar_items = array(
                "Order List" => array('url' => URL::route('v1.employee_admin.order.index'), 'icon' => '<i class="fa fa-users"></i>'),
                'Add New' => array('url' => URL::route('v1.employee_admin.order.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
            );

            $FillableDropdown = new FillableDropdown();
            $orderStatus_4 = $FillableDropdown->orderStatusKeyValue($default = 4);
            $orderStatus_3 = $FillableDropdown->orderStatusKeyValue($default = 3);
            $priority = $FillableDropdown->orderPriorityKeyValue($default = 3);
            $priority_4 = $FillableDropdown->orderPriorityKeyValue($default = 4);
            $order_status_key = 'all';
            $priority_4_key = 'all';

            $orderSearchData = [];


            if(isset($branch_ids) && count($branch_ids) > 1){


                if(isset($request->branch_id) && $request->branch_id == 'all'){

                    if (isset($request->order_status)) {

                        if (isset($request->order_status) && $request->order_status == 'all') {

                            $ordersData1 = Order::orderBy('created_at', 'decs')
                                ->orderBy('priority', 'asc')
                                ->whereIn('branch_id', $branch_ids)
                                ->paginate(20);

                            $request->session()->put('selection', 'status');

                            $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_4', 'orderStatus_3', 'order_status_key', 'sidebar_items'))->render();
                            return $returnHTML;

                        }else{
                            $ordersData1 = Order::orderBy('created_at', 'decs')
                                ->orderBy('priority', 'asc')
                                ->where('order_status', $request->order_status)
                                ->whereIn('branch_id', $branch_ids)
                                ->paginate(20);

                            $request->session()->put('selection', 'status');

                            $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_4', 'orderStatus_3', 'order_status_key', 'sidebar_items'))->render();
                            return $returnHTML;
                        }
                    }else{

                        $request->session()->put('selection', 'branch');

                        $ordersData1 = Order::orderBy('created_at', 'decs')
                            ->orderBy('priority', 'asc')
                            ->whereIn('branch_id', $branch_ids)
                            ->paginate(20);

                        $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_4', 'orderStatus_3', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;
                    }

                }
                elseif(isset($request->branch_id)) {

                    if (isset($request->order_status)) {

                        if (isset($request->order_status) && $request->order_status == 'all') {

                            $ordersData1 = Order::orderBy('created_at', 'decs')
                                ->orderBy('priority', 'asc')
                                ->where('branch_id', $request->branch_id)
                                ->paginate(20);

                            $request->session()->put('selection', 'status');

                            $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_4', 'orderStatus_3', 'order_status_key', 'sidebar_items'))->render();
                            return $returnHTML;

                        }else{

                            $ordersData1 = Order::orderBy('created_at', 'decs')
                                ->orderBy('priority', 'asc')
                                ->where('order_status', $request->order_status)
                                ->Where('branch_id', $request->branch_id)
                                ->paginate(20);

                            $request->session()->put('selection', 'status');

                            $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_4', 'orderStatus_3', 'order_status_key', 'sidebar_items'))->render();
                            return $returnHTML;
                        }
                    }else{

                        $request->session()->put('selection', 'branch');

                        $ordersData1 = Order::orderBy('created_at', 'decs')
                            ->orderBy('priority', 'asc')
                            ->where('branch_id', $request->branch_id)
                            ->paginate(20);

                        $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_4', 'orderStatus_3', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;
                    }
                }
                elseif (isset($request->order_status)) {

                    if (isset($request->order_status) && $request->order_status == 'all') {

                        $ordersData1 = Order::orderBy('created_at', 'decs')
                            ->orderBy('priority', 'asc')
                            ->whereIn('branch_id', $branch_ids)
                            ->paginate(20);

                        $request->session()->put('selection', 'status');

                        $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_4', 'orderStatus_3', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;

                    }else{
                        $ordersData1 = Order::orderBy('created_at', 'decs')
                            ->orderBy('priority', 'asc')
                            ->where('order_status', $request->order_status)
                            ->whereIn('branch_id', $branch_ids)
                            ->paginate(20);

                        $request->session()->put('selection', 'status');

                        $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_4', 'orderStatus_3', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;
                    }
                }
                elseif(isset($b_id)) {

                    $value = $request->session()->get('selection');

                    if($value == 'branch'){

                        if(isset($b_id) && $b_id  == 'all'){

                            $ordersData1 = Order::orderBy('created_at', 'decs')
                                ->orderBy('priority', 'asc')
                                ->whereIn('branch_id', $branch_ids)
                                ->paginate(20);

                            $returnHTML = view('employeeAdmin/orders.orderViewRender1', compact('ordersData1', 'orderSearchData', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_4', 'orderStatus_3', 'order_status_key', 'sidebar_items'))->render();
                            return $returnHTML;
                        }
                        elseif(isset($b_id)){

                            $branch_id = $b_id;

                            $ordersData1 = Order::orderBy('created_at', 'decs')
                                ->orderBy('priority', 'asc')
                                ->where('branch_id', $branch_id)
                                ->paginate(20);

                            $returnHTML = view('employeeAdmin/orders.orderViewRender1', compact('ordersData1', 'orderSearchData', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_4', 'orderStatus_3', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }

                    }elseif ($value == 'status'){

                        if(isset($b_id) && $b_id  == 'all'){

                            $ordersData1 = Order::orderBy('created_at', 'decs')
                                ->orderBy('priority', 'asc')
                                ->whereIn('branch_id', $branch_ids)
                                ->paginate(20);

                            $returnHTML = view('employeeAdmin/orders.orderViewRender1', compact('ordersData1', 'orderSearchData', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_4', 'orderStatus_3', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }
                        elseif(isset($b_id)){

                            $status_key = $b_id;

                            $ordersData1 = Order::orderBy('created_at', 'decs')
                                ->orderBy('priority', 'asc')
                                ->where('order_status', $status_key)
                                ->whereIn('branch_id', $branch_ids)
                                ->paginate(20);

                            $returnHTML = view('employeeAdmin/orders.orderViewRender1', compact('ordersData1', 'orderSearchData', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_4', 'orderStatus_3', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }
                    }


                }

            }
            elseif(isset($branch_id)){

                if(isset($request->branch_id)) {

                    if (isset($request->order_status)) {

                        if (isset($request->order_status) && $request->order_status == 'all') {

                            $ordersData1 = Order::orderBy('created_at', 'decs')
                                ->orderBy('priority', 'asc')
                                ->where('branch_id', $branch_id)
                                ->paginate(20);

                            $request->session()->put('selection', 'status');

                            $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_4', 'orderStatus_3', 'order_status_key', 'sidebar_items'))->render();
                            return $returnHTML;

                        }else{
                            $ordersData1 = Order::orderBy('created_at', 'decs')
                                ->orderBy('priority', 'asc')
                                ->where('order_status', $request->order_status)
                                ->Where('branch_id', $request->branch_id)
                                ->paginate(20);

                            $request->session()->put('selection', 'status');

                            $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_4', 'orderStatus_3', 'order_status_key', 'sidebar_items'))->render();
                            return $returnHTML;
                        }
                    }else{

                        $request->session()->put('selection', 'branch');

                        $ordersData1 = Order::orderBy('created_at', 'decs')
                            ->orderBy('priority', 'asc')
                            ->where('branch_id', $request->branch_id)
                            ->paginate(20);

                        $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_4', 'orderStatus_3', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;
                    }
                }
                elseif (isset($request->order_status)) {


                    if (isset($request->order_status) && $request->order_status == 'all') {

                        $ordersData1 = Order::orderBy('created_at', 'decs')
                            ->orderBy('priority', 'asc')
                            ->where('branch_id', $branch_id)
                            ->paginate(20);

                        $request->session()->put('selection', 'status');

                        $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_4', 'orderStatus_3', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;

                    }else{

                        $ordersData1 = Order::orderBy('created_at', 'decs')
                            ->orderBy('priority', 'asc')
                            ->where('order_status', $request->order_status)
                            ->where('branch_id', $branch_id)
                            ->paginate(20);

                        $request->session()->put('selection', 'status');

                        $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_4', 'orderStatus_3', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;
                    }
                }
                elseif(isset($b_id)) {

                    $value = $request->session()->get('selection');

                    if($value == 'branch'){

                        if(isset($b_id) && $b_id  == 'all'){

                            $ordersData1 = Order::orderBy('created_at', 'decs')
                                ->orderBy('priority', 'asc')
                                ->where('branch_id', $branch_id)
                                ->paginate(20);

                            $returnHTML = view('employeeAdmin/orders.orderViewRender1', compact('ordersData1', 'orderSearchData', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_4', 'orderStatus_3', 'order_status_key', 'sidebar_items'))->render();
                            return $returnHTML;
                        }
                        elseif(isset($b_id)){

                            $branch_id = $b_id;

                            $ordersData1 = Order::orderBy('created_at', 'decs')
                                ->orderBy('priority', 'asc')
                                ->where('branch_id', $branch_id)
                                ->paginate(20);

                            $returnHTML = view('employeeAdmin/orders.orderViewRender1', compact('ordersData1', 'orderSearchData', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_4', 'orderStatus_3', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }

                    }elseif ($value == 'status'){

                        if(isset($b_id) && $b_id  == 'all'){

                            $ordersData1 = Order::orderBy('created_at', 'decs')
                                ->orderBy('priority', 'asc')
                                ->where('branch_id', $branch_id)
                                ->paginate(20);

                            $returnHTML = view('employeeAdmin/orders.orderViewRender1', compact('ordersData1', 'orderSearchData', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_4', 'orderStatus_3', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }
                        elseif(isset($b_id)){

                            $status_key = $b_id;

                            $ordersData1 = Order::orderBy('created_at', 'decs')
                                ->orderBy('priority', 'asc')
                                ->where('order_status', $status_key)
                                ->where('branch_id', $branch_id)
                                ->paginate(20);

                            $returnHTML = view('employeeAdmin/orders.orderViewRender1', compact('ordersData1', 'orderSearchData', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_4', 'orderStatus_3', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }
                    }


                }

            } else{
                return 'No result found';
            }

        }

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOrderByPriority(Request $request)
    {

        $authentication = \App::make('authenticator');
        $authentication_helper = \App::make('authentication_helper');

        $branch_ids = array();
        $branch_id = null;
        $managerPermissions = '_manager';
        $adminPermissions = '_superadmin';

        $user = $authentication->getLoggedUser();

        if (isset($user)){

            $perm    = $user->permissions;
            $user_id = $user->id;

            if (isset($perm)){

                foreach($perm as $key=> $val)
                {
                    $permission_name = $key;
                }
            }

            $authentication_helper->hasPermission($perm);

            if (isset($permission_name) && isset($user_id)){

                if ($permission_name == $adminPermissions){

                    $branches = Branch::all();
                    if(! empty($branches)){
                        $branches = $branches->pluck('name', 'id')->prepend('All Branches','all');
                    }

                    if(! empty($branches)){
                        $result = Branch::all()->pluck('id');
                    }

                    if (isset($result) && count($result) > 0){

                        if(isset($result) && count($result) > 1) {
                            foreach($result as $key)
                            {
                                $branch_ids[] = $key;
                            }
                        }else{
                            $branch_id = $result[0]->branch_id;
                        }
                    }else{
                        $ordersData1 = null;
                    }

                }elseif($permission_name == $managerPermissions){

                    $user = User::find($user_id);

                    if ($user) {

                        if (isset($user->branches)) {

                            if ($user->branches()->count() > 0) {
                                $result = $user->branches()->select('branch_id')->get();
                                $branches = $user->branches();

                                if(isset($branches) && $branches->count() > 1){

                                    $branches = $branches->pluck('name', 'id')->prepend('All Branches','all');

                                }else{

                                    $branches = null;
                                }

                            }
                        }
                    }

                    if (isset($result) && count($result) > 0){

                        if(isset($result) && count($result) > 1) {
                            foreach($result as $key)
                            {
                                $branch_ids[] = $key->branch_id;

                            }
                        }else{
                            $branch_id = $result[0]->branch_id;
                        }
                    }else{
                        $ordersData1 = null;
                    }
                }
            }

        $ajax_data = Input::all();
        $url = $request->path();

        if(isset($request->page)){

            if(isset($url)){
                $b_id = substr($url, strrpos($url, '/') + 1);
            }
        }

        $branches = Branch::all();
        if(! empty($branches)){
            $branches = $branches->pluck('name', 'id')->prepend('All Branches','all');

        }

        $FillableDropdown = new FillableDropdown();
        $orderStatus_4 = $FillableDropdown->orderStatusKeyValue($default = 4);
        $orderStatus_3 = $FillableDropdown->orderStatusKeyValue($default = 3);
        $priority = $FillableDropdown->orderPriorityKeyValue($default = 3);
        $priority_4 = $FillableDropdown->orderPriorityKeyValue($default = 4);
        $order_status_key = 'all';
        $priority_4_key = 'all';

        $orderSearchData = [];

        $dates = Order::select([
            DB::raw('DISTINCT DATE(created_at) as day')
        ])->groupBy('day')
            ->get();

        $sidebar_items = array(
            "Order List" => array('url' => URL::route('order.index'), 'icon' => '<i class="fa fa-users"></i>'),
            'Add New' => array('url' => URL::route('order.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );

        if(isset($branch_ids) && count($branch_ids) > 1) {
            if(isset($request->branch_id)){

                if(isset($request->branch_id) && $request->branch_id == 'all'){

                    if (isset($request->priority)) {

                        $priority_key = $request->priority;

                        if (isset($priority_key) && $priority_key == 'all') {

                            $ordersData1 = Order::orderBy('created_at', 'decs')
                                ->whereIn('branch_id', $branch_ids)
                                ->paginate(10);

                            $request->session()->put('selection', 'priority');

                            $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();
                            return $returnHTML;

                        }else{
                            $ordersData1 = Order::orderBy('created_at', 'decs')
                                ->whereIn('branch_id', $branch_ids)
                                ->where('priority', $priority_key)
                                ->paginate(10);

                            $request->session()->put('selection', 'priority');

                            $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();
                            return $returnHTML;
                        }
                    }else{

                        $request->session()->put('selection', 'branch');

                        $ordersData1 = Order::orderBy('created_at', 'decs')
                            ->whereIn('branch_id', $branch_ids)
                            ->paginate(10);

                        $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;
                    }

                }
                elseif(isset($request->branch_id)){

                    if (isset($request->priority)) {

                        $priority_key = $request->priority;

                        if (isset($priority_key) && $priority_key == 'all') {

                            $ordersData1 = Order::orderBy('created_at', 'decs')
                                ->Where('branch_id', $request->branch_id)
                                ->paginate(10);

                            $request->session()->put('selection', 'priority');

                            $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;

                        }else{

                            $ordersData1 = Order::orderBy('created_at', 'decs')
                                ->where('priority', $priority_key)
                                ->where('branch_id', $request->branch_id)
                                ->paginate(10);

                            $request->session()->put('selection', 'priority');

                            $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }
                    } else{

                        $request->session()->put('selection', 'branch');

                        $ordersData1 = Order::orderBy('created_at', 'decs')
                            ->where('branch_id', $request->branch_id)
                            ->paginate(10);

                        $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;
                    }
                }
            }
            elseif (isset($request->priority)) {

                if (isset($request->priority) && $request->priority == 'all') {

                    $ordersData1 = Order::orderBy('created_at', 'decs')
                        ->whereIn('branch_id', $branch_ids)
                        ->paginate(10);

                    $request->session()->put('selection', 'priority');

                    $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                    return $returnHTML;

                }else{

                    $ordersData1 = Order::orderBy('created_at', 'decs')
                        ->where('priority', $request->priority)
                        ->whereIn('branch_id', $branch_ids)
                        ->paginate(10);


                    $request->session()->put('selection', 'priority');

                    $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                    return $returnHTML;

                }
            }
            elseif(isset($b_id)){

                $b_id = substr($url, strrpos($url, '/') + 1);

                $value = $request->session()->get('selection');

                if($value == 'branch'){

                    if(isset($b_id) && $b_id  == 'all'){

                        $ordersData1 = Order::orderBy('created_at', 'decs')
                            ->whereIn('branch_id', $branch_ids)
                            ->paginate(10);

                        $returnHTML = view('employeeAdmin/orders.orderViewRender1', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;
                    }
                    elseif(isset($b_id)){

                        $branch_id = $b_id;

                        $ordersData1 = Order::orderBy('created_at', 'decs')
                            ->where('branch_id', $branch_id)
                            ->paginate(10);

                        $returnHTML = view('employeeAdmin/orders.orderViewRender1', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;
                    }

                }elseif ($value == 'priority'){

                    if(isset($b_id) && $b_id  == 'all'){

                        $ordersData1 = Order::orderBy('created_at', 'decs')
                            ->whereIn('branch_id', $branch_ids)
                            ->paginate(10);
                        $returnHTML = view('employeeAdmin/orders.orderViewRender1', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;
                    }
                    elseif(isset($b_id)){

                        $priority_key_key = $b_id;

                        $ordersData1 = Order::orderBy('created_at', 'decs')
                            ->where('priority', $priority_key_key)
                            ->whereIn('branch_id', $branch_ids)
                            ->paginate(10);
                        $returnHTML = view('employeeAdmin/orders.orderViewRender1', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;
                    }
                }

            }
        }
        elseif(isset($branch_id)){
            if(isset($request->branch_id)){
                    if (isset($request->priority)) {

                        if (isset($request->priority) && $request->priority == 'all') {

                            $ordersData1 = Order::orderBy('created_at', 'decs')
                                ->where('branch_id', $branch_id)
                                ->paginate(10);

                            $request->session()->put('selection', 'priority');

                            $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();
                            return $returnHTML;

                        }else{
                            $ordersData1 = Order::orderBy('created_at', 'decs')
                                ->where('priority', $request->priority)
                                ->where('branch_id', $request->branch_id)
                                ->paginate(10);

                            $request->session()->put('selection', 'priority');

                            $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();
                            return $returnHTML;
                        }
                    }else{

                        $request->session()->put('selection', 'branch');

                        $ordersData1 = Order::orderBy('created_at', 'decs')
                            ->where('branch_id', $request->branch_id)
                            ->paginate(10);

                        $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;
                    }

                }
            }
            elseif (isset($request->priority)) {

                if (isset($request->priority) && $request->priority == 'all') {

                    $ordersData1 = Order::orderBy('created_at', 'decs')
                        ->where('branch_id', $branch_id)
                        ->paginate(10);

                    $request->session()->put('selection', 'priority');

                    $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                    return $returnHTML;

                }else{
                    $ordersData1 = Order::orderBy('created_at', 'decs')
                        ->where('priority', $request->priority)
                        ->where('branch_id', $branch_id)
                        ->paginate(10);

                    $request->session()->put('selection', 'priority');

                    $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                    return $returnHTML;
                }
            }
            elseif(isset($b_id)){

                $b_id = substr($url, strrpos($url, '/') + 1);

                $value = $request->session()->get('selection');

                if($value == 'branch'){

                    if(isset($b_id) && $b_id  == 'all'){

                        $ordersData1 = Order::orderBy('created_at', 'decs')
                            ->where('branch_id', $branch_id)
                            ->paginate(10);

                        $returnHTML = view('employeeAdmin/orders.orderViewRender1', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;
                    }
                    elseif(isset($b_id)){

                        $branch_id = $b_id;

                        $ordersData1 = Order::orderBy('created_at', 'decs')
                            ->where('branch_id', $branch_id)
                            ->paginate(10);

                        $returnHTML = view('employeeAdmin/orders.orderViewRender1', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;
                    }

                }elseif ($value == 'priority'){

                    if(isset($b_id) && $b_id  == 'all'){

                        $ordersData1 = Order::orderBy('created_at', 'decs')
                            ->where('branch_id', $branch_id)
                            ->paginate(10);

                        $returnHTML = view('employeeAdmin/orders.orderViewRender1', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;
                    }
                    elseif(isset($b_id)){

                        $priority_key_key = $b_id;

                        $ordersData1 = Order::orderBy('created_at', 'decs')
                            ->where('priority', $priority_key_key)
                            ->where('branch_id', $branch_id)
                            ->paginate(10);

                        $returnHTML = view('employeeAdmin/orders.orderViewRender1', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;
                    }
                }

            }
        }
        else{
            return 'No result found';
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOrderByDate(Request $request)
    {


        $authentication = \App::make('authenticator');
        $authentication_helper = \App::make('authentication_helper');

        $branch_ids = array();
        $branch_id = null;
        $managerPermissions = '_manager';
        $adminPermissions = '_superadmin';

        $user = $authentication->getLoggedUser();

        if (isset($user)){

            $perm    = $user->permissions;
            $user_id = $user->id;

            if (isset($perm)){

                foreach($perm as $key=> $val)
                {
                    $permission_name = $key;
                }
            }

            $authentication_helper->hasPermission($perm);

            if (isset($permission_name) && isset($user_id)){

                if ($permission_name == $adminPermissions){

                    $branches = Branch::all();
                    if(! empty($branches)){
                        $branches = $branches->pluck('name', 'id')->prepend('All Branches','all');
                    }

                    if(! empty($branches)){
                        $result = Branch::all()->pluck('id');
                    }

                    if (isset($result) && count($result) > 0){

                        if(isset($result) && count($result) > 1) {
                            foreach($result as $key)
                            {
                                $branch_ids[] = $key;
                            }
                        }else{
                            $branch_id = $result[0]->branch_id;
                        }
                    }else{
                        $ordersData1 = null;
                    }

                }elseif($permission_name == $managerPermissions){

                    $user = User::find($user_id);

                    if ($user) {

                        if (isset($user->branches)) {

                            if ($user->branches()->count() > 0) {
                                $result = $user->branches()->select('branch_id')->get();
                                $branches = $user->branches();

                                if(isset($branches) && $branches->count() > 1){

                                    $branches = $branches->pluck('name', 'id')->prepend('All Branches','all');

                                }else{

                                    $branches = null;
                                }

                            }
                        }
                    }

                    if (isset($result) && count($result) > 0){

                        if(isset($result) && count($result) > 1) {
                            foreach($result as $key)
                            {
                                $branch_ids[] = $key->branch_id;

                            }
                        }else{
                            $branch_id = $result[0]->branch_id;
                        }
                    }else{
                        $ordersData1 = null;
                    }
                }
            }


        $ajax_data = Input::all();
        $url = $request->path();

        if(isset($request->page)){

            if(isset($url)){
                $b_id = substr($url, strrpos($url, '/') + 1);
            }
        }

        $branches = Branch::all();
        if(! empty($branches)){
            $branches = $branches->pluck('name', 'id')->prepend('All Branches','all');

        }

        $FillableDropdown = new FillableDropdown();
        $orderStatus_4 = $FillableDropdown->orderStatusKeyValue($default = 4);
        $orderStatus_3 = $FillableDropdown->orderStatusKeyValue($default = 3);
        $priority = $FillableDropdown->orderPriorityKeyValue($default = 3);
        $priority_4 = $FillableDropdown->orderPriorityKeyValue($default = 4);
        $order_status_key = 'all';
        $priority_4_key = 'all';

        $orderSearchData = [];

        $dates = Order::select([
            DB::raw('DISTINCT DATE(created_at) as day')
        ])->groupBy('day')
            ->get();

        $sidebar_items = array(
            "Order List" => array('url' => URL::route('order.index'), 'icon' => '<i class="fa fa-users"></i>'),
            'Add New' => array('url' => URL::route('order.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );

            if(isset($branch_ids) && count($branch_ids) > 1) {
                if(isset($request->branch_id)){

                    if(isset($request->branch_id) && $request->branch_id == 'all'){

                        if (isset($request->date)) {

                            $ordersData1 = Order::orderBy('created_at', 'decs')
                                ->whereIn('branch_id', $branch_ids)
                                ->where('created_at', 'LIKE', '%'.$request->date.'%')
                                ->paginate(10);

                            $request->session()->put('selection', 'date_value');

                            $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();
                            return $returnHTML;

                        }else{

                            $request->session()->put('selection', 'branch');

                            $ordersData1 = Order::orderBy('created_at', 'decs')
                                ->whereIn('branch_id', $branch_ids)
                                ->paginate(10);

                            $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }

                    }
                    elseif(isset($request->branch_id)){

                        if (isset($request->date)) {

                            $ordersData1 = Order::orderBy('created_at', 'decs')
                                ->where('created_at', 'LIKE', '%'.$request->date.'%')
                                ->where('branch_id', $request->branch_id)
                                ->paginate(10);

                            $request->session()->put('selection', 'date_value');

                            $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;

                        } else{

                            $request->session()->put('selection', 'branch');

                            $ordersData1 = Order::orderBy('created_at', 'decs')
                                ->where('branch_id', $request->branch_id)
                                ->paginate(10);

                            $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }
                    }
                }
                elseif (isset($request->date)) {

                    $ordersData1 = Order::orderBy('created_at', 'decs')
                        ->where('created_at', 'LIKE', '%'.$request->date.'%')
                        ->whereIn('branch_id', $branch_ids)
                        ->paginate(10);


                    $request->session()->put('selection', 'date_value');

                    $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                    return $returnHTML;

                }
                elseif(isset($b_id)){

                    $b_id = substr($url, strrpos($url, '/') + 1);

                    $value = $request->session()->get('selection');

                    if($value == 'branch'){

                        if(isset($b_id) && $b_id  == 'all'){

                            $ordersData1 = Order::orderBy('created_at', 'decs')
                                ->whereIn('branch_id', $branch_ids)
                                ->paginate(10);

                            $returnHTML = view('employeeAdmin/orders.orderViewRender1', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }
                        elseif(isset($b_id)){

                            $branch_id = $b_id;

                            $ordersData1 = Order::orderBy('created_at', 'decs')
                                ->where('branch_id', $branch_id)
                                ->paginate(10);

                            $returnHTML = view('employeeAdmin/orders.orderViewRender1', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }

                    }elseif ($value == 'date_value'){

                        if(isset($b_id)){

                            $date_value_key = $b_id;

                            $ordersData1 = Order::orderBy('created_at', 'decs')
                                ->where('created_at', 'LIKE', '%'.$date_value_key.'%')
                                ->whereIn('branch_id', $branch_ids)
                                ->paginate(10);
                            $returnHTML = view('employeeAdmin/orders.orderViewRender1', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }
                    }

                }
            }
            elseif(isset($branch_id)){
                if(isset($request->branch_id)){
                    if (isset($request->date)) {

                        $ordersData1 = Order::orderBy('created_at', 'decs')
                            ->where('created_at', 'LIKE', '%'.$request->date.'%')
                            ->where('branch_id', $request->branch_id)
                            ->paginate(10);

                        $request->session()->put('selection', 'date_value');

                        $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();
                        return $returnHTML;

                    }else{

                        $request->session()->put('selection', 'branch');

                        $ordersData1 = Order::orderBy('created_at', 'decs')
                            ->where('branch_id', $request->branch_id)
                            ->paginate(10);

                        $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;
                    }

                }
            }
            elseif (isset($request->date)) {

                $ordersData1 = Order::orderBy('created_at', 'decs')
                    ->where('created_at', 'LIKE', '%'.$request->date.'%')
                    ->where('branch_id', $branch_id)
                    ->paginate(10);

                $request->session()->put('selection', 'date_value');

                $returnHTML = view('employeeAdmin/orders.orderViewRender', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                return $returnHTML;

            }
            elseif(isset($b_id)){

                $b_id = substr($url, strrpos($url, '/') + 1);

                $value = $request->session()->get('selection');

                if($value == 'branch'){

                    if(isset($b_id) && $b_id  == 'all'){

                        $ordersData1 = Order::orderBy('created_at', 'decs')
                            ->where('branch_id', $branch_id)
                            ->paginate(10);

                        $returnHTML = view('employeeAdmin/orders.orderViewRender1', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;
                    }
                    elseif(isset($b_id)){

                        $branch_id = $b_id;

                        $ordersData1 = Order::orderBy('created_at', 'decs')
                            ->where('branch_id', $branch_id)
                            ->paginate(10);

                        $returnHTML = view('employeeAdmin/orders.orderViewRender1', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;
                    }

                }elseif ($value == 'date_value'){

                    if(isset($b_id)){

                        $date_value_key = $b_id;

                        $ordersData1 = Order::orderBy('created_at', 'decs')
                            ->where('created_at', 'LIKE', '%'.$date_value_key.'%')
                            ->where('branch_id', $branch_id)
                            ->paginate(10);

                        $returnHTML = view('employeeAdmin/orders.orderViewRender1', compact('ordersData1', 'orderSearchData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;
                    }
                }

            }
        }
        else{
            return 'No result found';
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
        $order_search = $request->employee_admin_search;

        $FillableDropdown = new FillableDropdown();
        $orderStatus_4 = $FillableDropdown->orderStatusKeyValue($default = 4);
        $orderStatus_3 = $FillableDropdown->orderStatusKeyValue($default = 3);
        $priority = $FillableDropdown->orderPriorityKeyValue($default = 3);
        $priority_4 = $FillableDropdown->orderPriorityKeyValue($default = 4);
        $order_status_key = 'all';
        $priority_4_key = 'all';

        $branches = Branch::all();
        if(! empty($branches)){
            $branches = $branches->pluck('name', 'id')->prepend('All Branches','all');

        }
        $sidebar_items = array(
            "Order List" => array('url' => URL::route('v1.employee_admin.order.index'), 'icon' => '<i class="fa fa-users"></i>'),
            'Add New' => array('url' => URL::route('v1.employee_admin.order.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );

        if(!empty($order_search)){

            $orderSearchData = Order::where('id', $order_search)->take(30)->get();


            if($orderSearchData->isEmpty()){

                $orderSearchData = Order::where('cust_name', $order_search)->take(30)->get();

            }
            if($orderSearchData->isEmpty()){

                $product_by_id = Product::orderBy('created_at', 'asc')
                    ->select('id')
                    ->where('name', $order_search)
                    ->get();

                $product_id = array_first($product_by_id, function ($value, $key) {
                    return $value ;
                });
                $product_id = array_get($product_id, 'id');


                if ($product_id) {

                    $orderSearchData = Product::find($product_id)->orders()->take(30)->get();

                }

            }

            if ($orderSearchData->count() > 0) {

                $ordersData1 = [];
                return view('employeeAdmin/orders.list', compact('orderSearchData', 'ordersData1', 'orderStatus', 'orderStatus_3', 'orderStatus_4',  'order_status_key', 'branches', 'priority', 'priority_4', 'priority_4_key', 'sidebar_items'));

            }
        }
        else{

            return redirect()->route('v1.employee_admin.order.index')->withErrors(["This Order does not exist"]);

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
        $priority = $FillableDropdown->priority($default = false);
        $orderStatus = $FillableDropdown->orderStatus($default = 3);
        $orderType = $FillableDropdown->orderType($default = false);
        $paymentStatus = $FillableDropdown->paymentStatus($default = false);
        $paymentType = $FillableDropdown->paymentType($default = false);
        $active = $FillableDropdown->active($default = false);


        $product = Product::all();
        $branch = Branch::all();
        $flavour = Flavour::all();
        $order = Order::findOrFail($id);

        if(! empty($product)){
            $product = $product->pluck('name', 'id')->prepend('Select Product','');

        }
        if(! empty($branch)){
            $branch = $branch->pluck('name', 'id');
        }
        if(! empty($user)){
            $user = $user->pluck('email', 'id');
        }
        if(! empty($flavour)){
            $flavour = $flavour->pluck('name', 'id');
        }

        return view('employeeAdmin/orders.edit',
            compact('order', 'user', 'branch', 'product', 'flavour', 'priority',
                'orderStatus', 'active', 'orderType', 'paymentStatus', 'paymentType'));
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


        if(!empty($request->delivery_date)){

            $delivery_date = $request->delivery_date;

        } else{
            $delivery_date = null;
        }

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

        $authentication = \App::make('authenticator');
        $user = $authentication->getLoggedUser();

        if (isset($user)) {

            $user_id = $user->id;
        } else {
            $user_id = 0;

        }

        $token_code = mt_rand(15, 0xffffffffeeee);


//        dd($request->new_image, $request->default_image);
        if(isset($request->new_image) && !empty($request->new_image)){

            if( isset($request->default_image) && !empty($request->default_image)){

                if(File::isFile('assets/images/usersImages/product/'.$request->new_image)){
                    \File::delete('assets/images/usersImages/product/'.$request->new_image);
                }
                if(File::isFile('assets/images/usersImages/order/'.$request->new_image)){
                    \File::delete('assets/images/usersImages/order/'.$request->new_image);
                }
                $img = Image::make('assets/images/staticImage/'.$request->new_image)->resize(1000, 1000);
                $name = md5(uniqid() . microtime());
                $img->save('assets/images/usersImages/product/'.$name. '.png');
                $img->save('assets/images/usersImages/order/'.$name. '.png');
                $full_name = $name. '.png';

                $data = [
                    'image'             => $full_name,
                ];
                $order_data = [
                    'cust_name'             => $request->cust_name,
                    'cust_email'            => $request->cust_email,
                    'cust_address'          => $request->cust_address,
                    'cust_phone'            => $request->cust_phone,
                    'weight'                => $request->weight,
                    'quantity'              => $request->quantity,
                    'price'                 => $request->price,
                    'advance_price'         => $request->advance_price,
                    'payment_type'          => $request->payment_type,
                    'payment_status'        => $request->payment_status,
                    'order_type'            => $request->order_type,
                    'order_status'          => $request->order_status,
                    'delivery_date'         => $delivery_date,
                    'delivery_time'         => $request->delivery_time,
                    'remarks'               => $request->remarks,
                    'branch_id'             => $branch_id,
                    'branch_code'           => $branchCode,
                    'user_id'               => $user_id,
                    'active'                => $request->active,
                    'priority'              => $request->priority,
                    'image'                 => $full_name,
                ];


            } else{

                if(File::isFile('assets/images/usersImages/order/'.$request->new_image)){
                    \File::delete('assets/images/usersImages/order/'.$request->new_image);
                }
                if(File::isFile('assets/images/usersImages/product/'.$request->new_image)){
                    \File::delete('assets/images/usersImages/product/'.$request->new_image);
                }

                $img = Image::make('assets/images/staticImage/'.$request->new_image)->resize(1000, 1000);
                $name = md5(uniqid() . microtime());
                $img->save('assets/images/usersImages/product/'.$name. '.png');
                $img->save('assets/images/usersImages/order/'.$name. '.png');
                $full_name = $name. '.png';

                $data = [
                    'image'             => $full_name,
                ];
                $order_data = [
                    'cust_name'             => $request->cust_name,
                    'cust_email'            => $request->cust_email,
                    'cust_address'          => $request->cust_address,
                    'cust_phone'            => $request->cust_phone,
                    'weight'                => $request->weight,
                    'quantity'              => $request->quantity,
                    'price'                 => $request->price,
                    'advance_price'         => $request->advance_price,
                    'payment_type'          => $request->payment_type,
                    'payment_status'        => $request->payment_status,
                    'order_type'            => $request->order_type,
                    'order_status'          => $request->order_status,
                    'delivery_date'         => $delivery_date,
                    'delivery_time'         => $request->delivery_time,
                    'remarks'               => $request->remarks,
                    'branch_id'             => $branch_id,
                    'branch_code'           => $branchCode,
                    'user_id'               => $user_id,
                    'active'                => $request->active,
                    'priority'              => $request->priority,
                    'image'                 => $full_name,
                ];

            }

        }
        elseif(isset($request->default_image) && !empty($request->default_image)){

            if( isset($request->new_image) && !empty($request->new_image)){

                if(File::isFile('assets/images/usersImages/product/'.$request->new_image)){
                    \File::delete('assets/images/usersImages/product/'.$request->new_image);
                }
                if(File::isFile('assets/images/usersImages/order/'.$request->new_image)){
                    \File::delete('assets/images/usersImages/order/'.$request->new_image);
                }
                $img = Image::make('assets/images/staticImage/'.$request->new_image)->resize(1000, 1000);
                $name = md5(uniqid() . microtime());
                $img->save('assets/images/usersImages/product/'.$name. '.png');
                $img->save('assets/images/usersImages/order/'.$name. '.png');
                $full_name = $name. '.png';



                $order_data = [
                    'cust_name'             => $request->cust_name,
                    'cust_email'            => $request->cust_email,
                    'cust_address'          => $request->cust_address,
                    'cust_phone'            => $request->cust_phone,
                    'weight'                => $request->weight,
                    'quantity'              => $request->quantity,
                    'price'                 => $request->price,
                    'advance_price'         => $request->advance_price,
                    'payment_type'          => $request->payment_type,
                    'payment_status'        => $request->payment_status,
                    'order_type'            => $request->order_type,
                    'order_status'          => $request->order_status,
                    'delivery_date'         => $delivery_date,
                    'delivery_time'         => $request->delivery_time,
                    'remarks'               => $request->remarks,
                    'branch_id'             => $branch_id,
                    'branch_code'           => $branchCode,
                    'user_id'               => $user_id,
                    'active'                => $request->active,
                    'priority'              => $request->priority,
                    'image'                 => $full_name,
                ];
            } else{

                $order_data = [
                    'cust_name'             => $request->cust_name,
                    'cust_email'            => $request->cust_email,
                    'cust_address'          => $request->cust_address,
                    'cust_phone'            => $request->cust_phone,
                    'weight'                => $request->weight,
                    'quantity'              => $request->quantity,
                    'price'                 => $request->price,
                    'advance_price'         => $request->advance_price,
                    'payment_type'          => $request->payment_type,
                    'payment_status'        => $request->payment_status,
                    'order_type'            => $request->order_type,
                    'order_status'          => $request->order_status,
                    'delivery_date'         => $delivery_date,
                    'delivery_time'         => $request->delivery_time,
                    'remarks'               => $request->remarks,
                    'branch_id'             => $branch_id,
                    'branch_code'           => $branchCode,
                    'user_id'               => $user_id,
                    'active'                => $request->active,
                    'priority'              => $request->priority,
                ];
            }
        }else{

            return redirect()->back()->withErrors(['Provide Product image']);

        }

        $flavor1_id = $request->flavor1_id;
        $flavor2_id = $request->flavor2_id;
        $product_id = $request->product_id;

        $order = null;

        if(!empty($data) && isset($data)) {

            if(!empty($product_id) && isset($product_id)) {

                $product = Product::find($product_id);

                if(isset($product) && !empty($product)){

                    $product->update($data);

                }
            }

        }

        if(!empty($order_data) && isset($order_data)) {

            if(!empty($id) && isset($id)) {

                Order::where('id', $id)->update($order_data);
                $order = Order::find($id);

            }
        }

        if(isset($order)){

            if(!$order->products()){

                $order->products()->attach($product_id);
            }

            if(!$order->flavors()){

                if ( !empty($flavor1_id) &&  !empty($flavor2_id)){

                    if($flavor1_id == $flavor2_id){

                        $order->flavors()->attach($flavor1_id);

                    }else{

                        $order->flavors()->attach($flavor1_id);
                        $order->flavors()->attach($flavor2_id);

                    }

                } elseif (!empty($flavor1_id) ){


                    if (!empty($flavor2_id) ){


//                    $order->flavors()->attach([$flavor1_id, $flavor2_id]);
                        $order->flavors()->attach($flavor1_id);
                        $order->flavors()->attach($flavor2_id);

                    }else{

                        $order->flavors()->attach($flavor1_id);

                    }


                } elseif (!empty($flavor2_id) ){

                    if (!empty($flavor1_id) ){

                        $order->flavors()->attach($flavor1_id);
                        $order->flavors()->attach($flavor2_id);
                    }else{

                        $order->flavors()->attach($flavor2_id);
                    }

                }
            }

        }

        $request->session()->flash('alert-success', 'Image succefully added!');
        return redirect()->route('v1.employee_admin.order.edit', ['id' => $id]);
//        return redirect()->back()->with(['Provide Product image']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->products()->detach($id);
        $order->delete();

        return redirect()->route('v1.employee_admin.order.index');
    }
}
