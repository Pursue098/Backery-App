<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;

use Carbon\Carbon;

use App\Order;
use App\Branch;
use App\Product;
use App\User;
use App\Flavour;
use App\Configuration;
use App\Helper\FillableDropdown;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $ordersData = Order::orderBy('created_at', 'decs')
            ->orderBy('priority', 'asc')
            ->paginate(20);

        $dates = Order::select([

            DB::raw('DISTINCT DATE(created_at) as day')

            ])->groupBy('day')
            ->get();

        $dates_list = [];
        foreach($dates as $entry) {
            $dates_list[$entry->day] = $entry->count;
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

        $sidebar_items = array(
            "Order List" => array('url' => URL::route('order.index'), 'icon' => '<i class="fa fa-users"></i>'),
            'Add New' => array('url' => URL::route('order.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );

        $orderSearchData = [];

        return view('admin/orders.list',  compact('ordersData', 'orderSearchData', 'dates', 'dates_time', 'branches', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'priority', 'priority_4', 'priority_4_key', 'sidebar_items'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
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

        $dates = Order::select([
            DB::raw('DISTINCT DATE(created_at) as day')
            ])->groupBy('day')
            ->get();

        $sidebar_items = array(
            "Order List" => array('url' => URL::route('order.index'), 'icon' => '<i class="fa fa-users"></i>'),
            'Add New' => array('url' => URL::route('order.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );


        if(isset($request->branch_id)){

            $branch_id = $request->branch_id;

            if(isset($branch_id) && $branch_id == 'all'){

                if (isset($request->order_status)) {

                    $order_status = $request->order_status;

                    if (isset($order_status) && $order_status == 'all') {

                        $ordersData = Order::orderBy('created_at', 'decs')->paginate(10);

                        $request->session()->put('selection', 'status');

                        $returnHTML = view('admin/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();
                        return $returnHTML;

                    }else{
                        $ordersData = Order::orderBy('created_at', 'decs')
                            ->where('order_status', $order_status)
                            ->paginate(10);

                        $request->session()->put('selection', 'status');

                        $returnHTML = view('admin/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();
                        return $returnHTML;
                    }
                }else{

                    $request->session()->put('selection', 'branch');

                    $ordersData = Order::orderBy('created_at', 'decs')->paginate(10);

                    $returnHTML = view('admin/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                    return $returnHTML;
                }

            }
            elseif(isset($branch_id)){

                if (isset($request->order_status)) {

                    $order_status = $request->order_status;

                    if (isset($order_status) && $order_status == 'all') {

                        $ordersData = Order::orderBy('created_at', 'decs')
                            ->where('branch_id', $branch_id)
                            ->paginate(10);

                        $request->session()->put('selection', 'status');

                        $returnHTML = view('admin/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;

                    }else{

                        $ordersData = Order::orderBy('created_at', 'decs')
                            ->where('order_status', $order_status)
                            ->where('branch_id', $branch_id)
                            ->paginate(10);

                        $request->session()->put('selection', 'status');

                        $returnHTML = view('admin/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;
                    }
                } else{

                    $request->session()->put('selection', 'branch');

                    $ordersData = Order::orderBy('created_at', 'decs')
                        ->where('branch_id', $branch_id)
                        ->paginate(10);

                    $returnHTML = view('admin/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                    return $returnHTML;
                }
            }
        }elseif (isset($request->order_status)) {

            $order_status = $request->order_status;

            if (isset($order_status) && $order_status == 'all') {

                $ordersData = Order::orderBy('created_at', 'decs')->paginate(10);

                $request->session()->put('selection', 'status');

                $returnHTML = view('admin/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                return $returnHTML;

            }else{
                $ordersData = Order::orderBy('created_at', 'decs')
                    ->where('order_status', $order_status)
                    ->paginate(10);

                $request->session()->put('selection', 'status');

                $returnHTML = view('admin/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                return $returnHTML;
            }
        } elseif(isset($b_id)){

            $b_id = substr($url, strrpos($url, '/') + 1);

            $value = $request->session()->get('selection');

            if($value == 'branch'){

                if(isset($b_id) && $b_id  == 'all'){

                    $ordersData = Order::orderBy('created_at', 'decs')->paginate(10);
                    $returnHTML = view('admin/orders.orderViewRender1', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                    return $returnHTML;
                }
                elseif(isset($b_id)){

                    $branch_id = $b_id;

                    $ordersData = Order::orderBy('created_at', 'decs')->where('branch_id', $branch_id)->paginate(10);
                    $returnHTML = view('admin/orders.orderViewRender1', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                    return $returnHTML;
                }

            }elseif ($value == 'status'){

                if(isset($b_id) && $b_id  == 'all'){

                    $ordersData = Order::orderBy('created_at', 'decs')->paginate(10);
                    $returnHTML = view('admin/orders.orderViewRender1', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                    return $returnHTML;
                }
                elseif(isset($b_id)){

                    $status_key = $b_id;

                    $ordersData = Order::orderBy('created_at', 'decs')->where('order_status', $status_key)->paginate(10);
                    $returnHTML = view('admin/orders.orderViewRender1', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                    return $returnHTML;
                }
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

        $dates = Order::select([
            DB::raw('DISTINCT DATE(created_at) as day')
            ])->groupBy('day')
            ->get();

        $sidebar_items = array(
            "Order List" => array('url' => URL::route('order.index'), 'icon' => '<i class="fa fa-users"></i>'),
            'Add New' => array('url' => URL::route('order.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );


        if(isset($request->branch_id)){

            $branch_id = $request->branch_id;

            if(isset($branch_id) && $branch_id == 'all'){

                if (isset($request->priority)) {

                    $priority_key = $request->priority;

                    if (isset($priority_key) && $priority_key == 'all') {

                        $ordersData = Order::orderBy('created_at', 'decs')->paginate(10);

                        $request->session()->put('selection', 'priority');

                        $returnHTML = view('admin/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();
                        return $returnHTML;

                    }else{
                        $ordersData = Order::orderBy('created_at', 'decs')
                            ->where('priority', $priority_key)
                            ->paginate(10);

                        $request->session()->put('selection', 'priority');

                        $returnHTML = view('admin/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();
                        return $returnHTML;
                    }
                }else{

                    $request->session()->put('selection', 'branch');

                    $ordersData = Order::orderBy('created_at', 'decs')->paginate(10);

                    $returnHTML = view('admin/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                    return $returnHTML;
                }

            }
            elseif(isset($branch_id)){

                if (isset($request->priority)) {

                    $priority_key = $request->priority;

                    if (isset($priority_key) && $priority_key == 'all') {

                        $ordersData = Order::orderBy('created_at', 'decs')
                            ->where('branch_id', $branch_id)
                            ->paginate(10);

                        $request->session()->put('selection', 'priority');

                        $returnHTML = view('admin/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;

                    }else{

                        $ordersData = Order::orderBy('created_at', 'decs')
                            ->where('priority', $priority_key)
                            ->where('branch_id', $branch_id)
                            ->paginate(10);

                        $request->session()->put('selection', 'priority');

                        $returnHTML = view('admin/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;
                    }
                } else{

                    $request->session()->put('selection', 'branch');

                    $ordersData = Order::orderBy('created_at', 'decs')
                        ->where('branch_id', $branch_id)
                        ->paginate(10);

                    $returnHTML = view('admin/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                    return $returnHTML;
                }
            }
        }elseif (isset($request->priority)) {

            $priority_key = $request->priority;

            if (isset($priority_key) && $priority_key == 'all') {

                $ordersData = Order::orderBy('created_at', 'decs')->paginate(10);

                $request->session()->put('selection', 'priority');

                $returnHTML = view('admin/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                return $returnHTML;

            }else{
                $ordersData = Order::orderBy('created_at', 'decs')
                    ->where('priority', $priority_key)
                    ->paginate(10);

                $request->session()->put('selection', 'priority');

                $returnHTML = view('admin/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                return $returnHTML;
            }
        } elseif(isset($b_id)){

            $b_id = substr($url, strrpos($url, '/') + 1);

            $value = $request->session()->get('selection');

            if($value == 'branch'){

                if(isset($b_id) && $b_id  == 'all'){

                    $ordersData = Order::orderBy('created_at', 'decs')->paginate(10);
                    $returnHTML = view('admin/orders.orderViewRender1', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                    return $returnHTML;
                }
                elseif(isset($b_id)){

                    $branch_id = $b_id;

                    $ordersData = Order::orderBy('created_at', 'decs')->where('branch_id', $branch_id)->paginate(10);
                    $returnHTML = view('admin/orders.orderViewRender1', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                    return $returnHTML;
                }

            }elseif ($value == 'priority'){

                if(isset($b_id) && $b_id  == 'all'){

                    $ordersData = Order::orderBy('created_at', 'decs')->paginate(10);
                    $returnHTML = view('admin/orders.orderViewRender1', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                    return $returnHTML;
                }
                elseif(isset($b_id)){

                    $priority_key_key = $b_id;

                    $ordersData = Order::orderBy('created_at', 'decs')->where('priority', $priority_key_key)->paginate(10);
                    $returnHTML = view('admin/orders.orderViewRender1', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                    return $returnHTML;
                }
            }

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

        $dates = Order::select([
            DB::raw('DISTINCT DATE(created_at) as day')
            ])->groupBy('day')
            ->get();

        $sidebar_items = array(
            "Order List" => array('url' => URL::route('order.index'), 'icon' => '<i class="fa fa-users"></i>'),
            'Add New' => array('url' => URL::route('order.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );


        if(isset($request->branch_id)){

            $branch_id = $request->branch_id;

            if(isset($branch_id) && $branch_id == 'all'){

                if (isset($request->date)) {

                    $date_value = $request->date;

                    if (isset($date_value) && $date_value == 'all') {

                        $ordersData = Order::orderBy('created_at', 'decs')->paginate(10);

                        $request->session()->put('date_selection', 'date_value');

                        $returnHTML = view('admin/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();
                        return $returnHTML;

                    }else{
                        $ordersData = Order::orderBy('created_at', 'decs')
                            ->where('created_at', 'LIKE', '%'.$date_value.'%')
                            ->paginate(10);

                        $request->session()->put('date_selection', 'date_value');

                        $returnHTML = view('admin/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();
                        return $returnHTML;
                    }
                }else{

                    $request->session()->put('date_selection', 'branch');

                    $ordersData = Order::orderBy('created_at', 'decs')->paginate(10);

                    $returnHTML = view('admin/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                    return $returnHTML;
                }

            }
            elseif(isset($branch_id)){

                if (isset($request->date)) {

                    $date_value = $request->date;

                    if (isset($date_value) && $date_value == 'all') {

                        $ordersData = Order::orderBy('created_at', 'decs')
                            ->where('branch_id', $branch_id)
                            ->paginate(10);

                        $request->session()->put('date_selection', 'date_value');

                        $returnHTML = view('admin/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;

                    }else{

                        $ordersData = Order::orderBy('created_at', 'decs')
                            ->where('created_at', 'LIKE', '%'.$date_value.'%')
                            ->where('branch_id', $branch_id)
                            ->paginate(10);

                        $request->session()->put('date_selection', 'date_value');

                        $returnHTML = view('admin/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;
                    }
                } else{

                    $request->session()->put('date_selection', 'branch');

                    $ordersData = Order::orderBy('created_at', 'decs')
                        ->where('branch_id', $branch_id)
                        ->paginate(10);

                    $returnHTML = view('admin/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                    return $returnHTML;
                }
            }
        }elseif (isset($request->date)) {

            $date_value = $request->date;

            if (isset($date_value) && $date_value == 'all') {

                $ordersData = Order::orderBy('created_at', 'decs')->paginate(10);

                $request->session()->put('date_selection', 'date_value');

                $returnHTML = view('admin/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                return $returnHTML;

            }else{
                $ordersData = Order::orderBy('created_at', 'decs')
                    ->where('created_at', 'LIKE', '%'.$date_value.'%')
                    ->paginate(10);

                $request->session()->put('date_selection', 'date_value');

                $returnHTML = view('admin/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                return $returnHTML;
            }
        } elseif(isset($b_id)){

            $b_id = substr($url, strrpos($url, '/') + 1);

            $value = $request->session()->get('date_selection');

            if($value == 'branch'){

                if(isset($b_id) && $b_id  == 'all'){

                    $ordersData = Order::orderBy('created_at', 'decs')->paginate(10);
                    $returnHTML = view('admin/orders.orderViewRender1', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                    return $returnHTML;
                }
                elseif(isset($b_id)){

                    $branch_id = $b_id;

                    $ordersData = Order::orderBy('created_at', 'decs')->where('branch_id', $branch_id)->paginate(10);
                    $returnHTML = view('admin/orders.orderViewRender1', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                    return $returnHTML;
                }

            }elseif ($value == 'date_value'){

                if(isset($b_id) && $b_id  == 'all'){

                    $ordersData = Order::orderBy('created_at', 'decs')->paginate(10);
                    $returnHTML = view('admin/orders.orderViewRender1', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                    return $returnHTML;
                }
                elseif(isset($b_id)){

                    $date_value_key = $b_id;

                    $ordersData = Order::orderBy('created_at', 'decs')->where('created_at', 'LIKE', '%'.$date_value_key.'%')->paginate(10);
                    $returnHTML = view('admin/orders.orderViewRender1', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                    return $returnHTML;
                }
            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_image($id)
    {
        $ajax_data = Input::all();
        $p_id = $ajax_data['id'];

        $product_image = Product::select('image')->where('id', $p_id)->get();

        return $product_image;
    }


    /**
     * Search method for Order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getList(Request $request)
    {
        $order_search = $request->order_search;

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
            "Order List" => array('url' => URL::route('order.index'), 'icon' => '<i class="fa fa-users"></i>'),
            'Add New' => array('url' => URL::route('order.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
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

                $ordersData = [];
                return view('admin/orders.list', compact('orderSearchData', 'ordersData', 'orderStatus', 'orderStatus_3', 'orderStatus_4',  'order_status_key', 'branches', 'priority', 'priority_4', 'priority_4_key', 'sidebar_items'));

            }
        }
        else{

            return redirect()->route('order.index')->withErrors(["This Order does not exist"]);

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
            "orders List" => array('url' => URL::route('order.index'), 'icon' => '<i class="fa fa-users"></i>'),
            'Add New' => array('url' => URL::route('order.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
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
            $flavour = $flavour->where('active', 1)->pluck('name', 'id')->prepend('Select Flavor','');

        }

        $FillableDropdown = new FillableDropdown();
        $priority = $FillableDropdown->priority($default = false);
        $orderStatus = $FillableDropdown->orderStatus($default = 3);
        $orderType = $FillableDropdown->orderType($default = false);
        $paymentStatus = $FillableDropdown->paymentStatus($default = false);
        $paymentType = $FillableDropdown->paymentType($default = false);
        $active = $FillableDropdown->active($default = false);

        return view('admin/orders.create',
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

            return redirect()->route('order.create')->withInput()->withErrors($validator);
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
        } else{
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

        return redirect()->route('order.index');
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
            "orders List" => array('url' => URL::route('order.index'), 'icon' => '<i class="fa fa-users"></i>'),
            'Add New' => array('url' => URL::route('order.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );

        $branch = Branch::all();
        $user = User::all();
        $order = Order::findOrFail($id);

        if(! empty($branch)){
            $branch = $branch->pluck('name', 'id');
        }
        if(! empty($user)){
            $user = $user->pluck('email', 'id');
        }

        if(count($order->products) > 0){

            if (isset($order->products[0]->id)){

                $selectedProduct = $order->products[0]->id;
                $products = collect(Product::all())->keyBy('id');
            }


        } else{

            $products = Product::all();
            if(count($products) > 0){

                $products = $products->pluck('name', 'id');
            }
        }

        if(count($order->flavors) > 0){

            if(isset($order->flavors[0]->id)){

                $selectedFlavor_1 = $order->flavors[0]->id;
                $flavour = collect(Flavour::all())->keyBy('id');

//                dd($selectedFlavor_1);
                if ( isset($order->flavors[1]->id) ){

                    $selectedFlavor_2 = $order->flavors[1]->id;
                    $flavour = collect(Flavour::all())->keyBy('id');

                }else{

                    $flavourDefaut = Flavour::all();
                    if(count($flavourDefaut) > 0){

                        $flavourDefaut = $flavourDefaut->pluck('name', 'id');
                    }
                }
            }elseif ( isset($order->flavors[1]->id) ){

                $selectedFlavor_2 = $order->flavors[1]->id;
                $flavour = collect(Flavour::all())->keyBy('id');

                if ( isset($order->flavors[0]->id) ){

                    $selectedFlavor_1 = $order->flavors[0]->id;
                    $flavour = collect(Flavour::all())->keyBy('id');

                }else{

                    $flavourDefaut = Flavour::all();
                    if(count($flavourDefaut) > 0){

                        $flavourDefaut = $flavourDefaut->pluck('name', 'id');
                    }
                }
            }


        } else{

            $flavour = Flavour::all();
            if(count($flavour) > 0){

                $flavour = $flavour->pluck('name', 'id');
            }
        }

        $FillableDropdown = new FillableDropdown();
        $priority = $FillableDropdown->priority($default = false);
        $orderStatus = $FillableDropdown->orderStatus($default = 3);
        $orderType = $FillableDropdown->orderType($default = false);
        $paymentStatus = $FillableDropdown->paymentStatus($default = false);
        $paymentType = $FillableDropdown->paymentType($default = false);
        $active = $FillableDropdown->active($default = false);

        return view('admin/orders.edit',
            compact('sidebar_items', 'order', 'user', 'branch', 'products', 'selectedProduct',
                'flavour', 'flavourDefaut', 'selectedFlavor_1','selectedFlavor_2', 'priority', 'orderStatus', 'active',
                'orderType', 'paymentStatus', 'paymentType' ));
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
            return redirect()->route('order.edit', $id)
                ->withInput()
                ->withErrors($validator);
        }

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

        $token_code = mt_rand(15, 0xffffffffeeee);


        $authentication = \App::make('authenticator');
        $user = $authentication->getLoggedUser();

        if (isset($user)) {

            $user_id = $user->id;
        } else {
            $user_id = 0;

        }

        // store
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
            'remarks'               => $request->remarks,
            'branch_id'             => $branch_id,
            'branch_code'           => $branchCode,
            'user_id'               => $user_id,
            'active'                => $request->active,
            'priority'              => $request->priority,

        ];

        $product_id = $request->product_id;
        $flavor1_id = $request->flavor1_id;
        $flavor2_id = $request->flavor2_id;

        $order = Order::findOrFail($id);
        if(count($order) > 0) {

            Order::where('id', $id)->update($data);

            if(isset($product_id)){
                $old_product_id = $order->products()->first();
                $order->products()->updateExistingPivot($old_product_id->id, ['order_id' =>$id, 'product_id' =>$product_id]);

            }

            if (isset($flavor1_id)){

                if(isset($flavor2_id)){

                    $old_flavors = $order->flavors;
                    if(count($old_flavors) > 0){

                        if(isset($old_flavors[0]->id)){

                            $old_flavor_id_1 = $old_flavors[0]->id;

                        }elseif ($old_flavors[1]->id){

                            $old_flavor_id_2 = $old_flavors[1]->id;

                        }

                        if(isset($old_flavor_id_1)){
                            $order->flavors()->updateExistingPivot($old_flavor_id_1, ['order_id' =>$id, 'flavour_id' =>$flavor1_id]);

                        }else{

                            $order->flavors()->attach($flavor1_id);

                        }

                        if(isset($old_flavor_id_2)){
                            $order->flavors()->updateExistingPivot($old_flavor_id_2, ['order_id' =>$id, 'flavour_id' =>$flavor2_id]);

                        }else{

                            $order->flavors()->attach($flavor2_id);

                        }

                    }

                }else{
                    $old_flavors = $order->flavors;
                    if(count($old_flavors) > 0){

                        if(isset($old_flavors[0]->id)){

                            $old_flavor_id_1 = $old_flavors[0]->id;

                        }

                        if(isset($old_flavor_id_1)){
                            $order->flavors()->updateExistingPivot($old_flavor_id_1, ['order_id' =>$id, 'flavour_id' =>$flavor1_id]);

                        }else{

                            $order->flavors()->attach($flavor1_id);

                        }
                    }
                }

            } elseif (isset($flavor2_id)){

                $old_flavors = $order->flavors;
                if(count($old_flavors) > 0){

                    if(isset($old_flavors[1]->id)){

                        $old_flavor_id_2 = $old_flavors[1]->id;

                    }

                    if(isset($old_flavor_id_2)){
                        $order->flavors()->updateExistingPivot($old_flavor_id_2, ['order_id' =>$id, 'flavour_id' =>$flavor2_id]);

                    }else{

                        $order->flavors()->attach($flavor2_id);

                    }
                }
            }

        }

        return redirect()->route('order.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function printScreen($id)
    {

//        dd('azam');
        $product = Product::all();
        $branch = Branch::all();
        $user = User::all();
        $flavour = Flavour::all();
        $order = Order::findOrFail($id);


        if(! empty($product)){
            $product = $product->pluck('name', 'id');
        }
        if(! empty($branch)){
            $branch = $branch->pluck('name', 'id');
        }
        if(! empty($flavour)){
            $flavour = $flavour->pluck('name', 'id');
        }

        $view = View::make('admin.orders.printScript',  compact('order', 'branch', 'product', 'flavour'));

        $response = array(
            'status' => 'success',
            'page' => $view->render(),
            'product' => $order,
        );
        return \Response::json($response);

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

        return redirect()->route('order.index');
    }
}
