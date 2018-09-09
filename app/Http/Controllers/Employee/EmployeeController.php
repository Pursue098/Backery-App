<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

use App\Order;
use App\Product;
use App\Branch;
use App\Configuration;
use App\User;
use App\Helper\FillableDropdown;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $FillableDropdown = new FillableDropdown();
        $orderStatus = $FillableDropdown->orderStatusKeyValue($default = 3);
        $orderStatus_1 = $FillableDropdown->orderStatusKeyValue($default = 1);
        $priority = $FillableDropdown->orderPriorityKeyValue($default = 3);   
        $priority_4 = $FillableDropdown->orderPriorityKeyValue($default = 4);

        $priority_4_key = 'all';
        $order_status_key = '';

        $orderSearchData = [];

        $authentication = \App::make('authenticator');
        $authentication_helper = \App::make('authentication_helper');

        $branch_ids = array();
        $branch_id = null;
        $result = null;

        $employeePermissions = '_backman';
        $employeeAdminPermissions = '_manager';
        $adminPermissions = '_superadmin';

        $user = $authentication->getLoggedUser();

        if (isset($user)) {

            $perm    = $user->permissions;
            $user_id = $user->id;

            if (isset($perm)){

                foreach($perm as $key=> $val)
                {
                    $permission_name = $key;
                }
            }


            $authentication_helper->hasPermission($perm);
            if (isset($permission_name) && isset($user_id)) {

                if ($permission_name == $adminPermissions) {

                    $branch = Branch::all();

                    if (!empty($branch)) {
                        $result = Branch::all()->pluck('id');
                    }

                    if (isset($result) && count($result) > 0) {

                        if (isset($result) && count($result) > 1) {
                            foreach ($result as $key) {
                                $branch_ids[] = $key;
                            }
                        } else {
                            $branch_id = $result[0]->branch_id;
                        }
                    } else {
                        $ordersData = null;
                    }

                } elseif ($permission_name == $employeePermissions || $permission_name == $employeeAdminPermissions) {

                    $user = User::find($user_id);

                    if ($user) {

                        if (isset($user->branches)) {

                            if($user->branches()->count() > 0){

                                $result = $user->branches()->select('branch_id')->get();
                            }
                        }
                    }


                    if (isset($result) && count($result) > 0) {

                        if (isset($result) && count($result) > 1) {
                            foreach ($result as $key) {
                                $branch_ids[] = $key->branch_id;

                            }
                        } else {
                            $branch_id = $result[0]->branch_id;
                        }
                    } else {
                        $ordersData = null;
                    }


                }
            }
            if (isset($branch_ids) && count($branch_ids) > 1) {

                $ordersData = Order::orderBy('order_status', 'asc')
                    ->whereIn('branch_id', $branch_ids)
                    ->orderBy('priority', 'asc')
                    ->orderBy('delivery_date', 'decs')
                    ->orderBy('delivery_time', 'decs')
                    ->paginate(20);

                return view('employee/orders.list', compact('ordersData', 'orderSearchData', 'orderStatus', 'order_status_key', 'orderStatus_1', 'priority', 'priority_4', 'priority_4_key'));

            } elseif(isset($branch_id)) {

                $ordersData = Order::orderBy('order_status', 'asc')
                    ->where('branch_id', $branch_id)
                    ->orderBy('priority', 'asc')
                    ->orderBy('delivery_date', 'decs')
                    ->orderBy('delivery_time', 'decs')
                    ->paginate(20);

//                dd($ordersData);

                return view('employee/orders.list', compact('ordersData', 'orderSearchData', 'orderStatus', 'order_status_key', 'orderStatus_1', 'priority', 'priority_4', 'priority_4_key'));

            }else{

                return view('employee/orders.list', compact('ordersData', 'orderSearchData', 'orderStatus', 'order_status_key', 'orderStatus_1', 'priority', 'priority_4', 'priority_4_key'));

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
                        $ordersData = null;
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
                        $ordersData = null;
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
            $orderStatus = $FillableDropdown->orderStatusKeyValue($default = 3);
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

            if(isset($branch_ids) && count($branch_ids) > 1) {
                if(isset($request->order_status_id)){

                    if(isset($request->order_status_id) && $request->order_status_id == 'all'){

                        if (isset($request->date)) {

                            $ordersData = Order::orderBy('created_at', 'decs')
                                ->whereIn('branch_id', $branch_ids)
                                ->where('created_at', 'LIKE', '%'.$request->date.'%')
                                ->paginate(10);

                            $request->session()->put('selection', 'date_value');

                                $returnHTML = view('employee/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();
                            return $returnHTML;

                        }else{

                            $request->session()->put('selection', 'order_status');

                            $ordersData = Order::orderBy('created_at', 'decs')
                                ->whereIn('branch_id', $branch_ids)
                                ->paginate(10);

                            $returnHTML = view('employee/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }

                    }
                    elseif(isset($request->order_status_id)){

                        if (isset($request->date)) {

                            $ordersData = Order::orderBy('created_at', 'decs')
                                ->where('created_at', 'LIKE', '%'.$request->date.'%')
                                ->where('order_status', $request->order_status_id)
                                ->whereIn('branch_id', $branch_ids)
                                ->paginate(10);

                            $request->session()->put('selection', 'date_value');

                            $returnHTML = view('employee/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;

                        } else{

                            $request->session()->put('selection', 'order_status');

                            $ordersData = Order::orderBy('created_at', 'decs')
                                ->where('order_status', $request->order_status_id)
                                ->whereIn('branch_id', $branch_ids)
                                ->paginate(10);

                            $returnHTML = view('employee/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }
                    }
                }
                elseif (isset($request->date)) {

                    $ordersData = Order::orderBy('created_at', 'decs')
                        ->where('created_at', 'LIKE', '%'.$request->date.'%')
                        ->whereIn('branch_id', $branch_ids)
                        ->paginate(10);


                    $request->session()->put('selection', 'date_value');

                    $returnHTML = view('employee/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                    return $returnHTML;

                }
                elseif(isset($b_id)){

                    $b_id = substr($url, strrpos($url, '/') + 1);

                    $value = $request->session()->get('selection');

                    if($value == 'order_status'){

                        if(isset($b_id) && $b_id  == 'all'){

                            $ordersData = Order::orderBy('created_at', 'decs')
                                ->whereIn('branch_id', $branch_ids)
                                ->paginate(10);

                            $returnHTML = view('employee/orders.orderViewRender1', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }
                        elseif(isset($b_id)){

                            $order_status_id = $b_id;

                            $ordersData = Order::orderBy('created_at', 'decs')
                                ->where('order_status', $order_status_id)
                                ->whereIn('branch_id', $branch_ids)
                                ->paginate(10);

                            $returnHTML = view('employee/orders.orderViewRender1', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }

                    }elseif ($value == 'date_value'){

                        if(isset($b_id)){

                            $date_value_key = $b_id;

                            $ordersData = Order::orderBy('created_at', 'decs')
                                ->where('created_at', 'LIKE', '%'.$date_value_key.'%')
                                ->whereIn('branch_id', $branch_ids)
                                ->paginate(10);
                            $returnHTML = view('employee/orders.orderViewRender1', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }
                    }

                }
            }
            elseif(isset($branch_id)){
                if(isset($request->order_status_id)){
                    if (isset($request->date)) {

                        $ordersData = Order::orderBy('created_at', 'decs')
                            ->where('created_at', 'LIKE', '%'.$request->date.'%')
                            ->where('order_status', $request->order_status_id)
                            ->where('branch_id', $branch_id)
                            ->paginate(10);

                        $request->session()->put('selection', 'date_value');

                        $returnHTML = view('employee/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();
                        return $returnHTML;

                    }else{

                        $request->session()->put('selection', 'order_status');

                        $ordersData = Order::orderBy('created_at', 'decs')
                            ->where('order_status', $request->order_status_id)
                            ->where('branch_id', $branch_id)
                            ->paginate(10);

                        $returnHTML = view('employee/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;
                    }

                }
                elseif (isset($request->date)) {

                    $ordersData = Order::orderBy('created_at', 'decs')
                        ->where('created_at', 'LIKE', '%'.$request->date.'%')
                        ->where('branch_id', $branch_id)
                        ->paginate(10);

                    $request->session()->put('selection', 'date_value');

                    $returnHTML = view('employee/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                    return $returnHTML;

                }
                elseif(isset($b_id)){

                    $b_id = substr($url, strrpos($url, '/') + 1);

                    $value = $request->session()->get('selection');

                    if($value == 'order_status'){

                        if(isset($b_id) && $b_id  == 'all'){

                            $ordersData = Order::orderBy('created_at', 'decs')
                                ->where('branch_id', $branch_id)
                                ->paginate(10);

                            $returnHTML = view('employee/orders.orderViewRender1', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }
                        elseif(isset($b_id)){

                            $branch_id = $b_id;

                            $ordersData = Order::orderBy('created_at', 'decs')
                                ->where('branch_id', $branch_id)
                                ->where('order_status', $branch_id)
                                ->paginate(10);

                            $returnHTML = view('employee/orders.orderViewRender1', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }

                    }elseif ($value == 'date_value'){

                        if(isset($b_id)){

                            $date_value_key = $b_id;

                            $ordersData = Order::orderBy('created_at', 'decs')
                                ->where('created_at', 'LIKE', '%'.$date_value_key.'%')
                                ->where('branch_id', $branch_id)
                                ->paginate(10);

                            $returnHTML = view('employee/orders.orderViewRender1', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }
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
                        $ordersData = null;
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
                        $ordersData = null;
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
            $orderStatus = $FillableDropdown->orderStatusKeyValue($default = 3);
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

            if(isset($branch_ids) && count($branch_ids) > 1) {
                if(isset($request->order_status_id)){

                    if($request->order_status_id == 'all'){

                        if (isset($request->priority)) {

                            if ($request->priority == 'all') {

                                $ordersData = Order::orderBy('created_at', 'decs')
                                    ->whereIn('branch_id', $branch_ids)
                                    ->paginate(10);

                                $request->session()->put('selection', 'priority');

                                $returnHTML = view('employee/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();
                                return $returnHTML;

                            }else{
                                $ordersData = Order::orderBy('created_at', 'decs')
                                    ->whereIn('branch_id', $branch_ids)
                                    ->where('priority', $request->priority)
                                    ->paginate(10);

                                $request->session()->put('selection', 'priority');

                                $returnHTML = view('employee/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();
                                return $returnHTML;
                            }
                        }else{

                            $request->session()->put('selection', 'order_status');

                            $ordersData = Order::orderBy('created_at', 'decs')
                                ->whereIn('branch_id', $branch_ids)
                                ->paginate(10);

                            $returnHTML = view('employee/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }

                    }
                    elseif(isset($request->order_status_id)){

                        if (isset($request->priority)) {

                            if ($request->priority == 'all') {

                                $ordersData = Order::orderBy('created_at', 'decs')
                                    ->WhereIn('branch_id', $branch_ids)
                                    ->where('order_status', $request->order_status_id)
                                    ->paginate(10);

                                $request->session()->put('selection', 'priority');

                                $returnHTML = view('employee/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                                return $returnHTML;

                            }else{

//                                dd($request->priority, $request->order_status_id);

                                $ordersData = Order::orderBy('created_at', 'decs')
                                    ->where('priority', $request->priority)
                                    ->WhereIn('branch_id', $branch_ids)
                                    ->where('order_status', $request->order_status_id)
                                    ->paginate(10);

                                $request->session()->put('selection', 'priority');

                                $returnHTML = view('employee/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                                return $returnHTML;
                            }
                        }
                        else{

                            $request->session()->put('selection', 'order_status');

                            $ordersData = Order::orderBy('created_at', 'decs')
                                ->WhereIn('branch_id', $branch_ids)
                                ->where('order_status', $request->order_status_id)
                                ->paginate(10);

                            $returnHTML = view('employee/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }
                    }
                }
                elseif (isset($request->priority)) {

                    if (isset($request->priority) && $request->priority == 'all') {

                        $ordersData = Order::orderBy('created_at', 'decs')
                            ->whereIn('branch_id', $branch_ids)
                            ->paginate(10);

                        $request->session()->put('selection', 'priority');

                        $returnHTML = view('employee/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;

                    }else{

                        $ordersData = Order::orderBy('created_at', 'decs')
                            ->where('priority', $request->priority)
                            ->whereIn('branch_id', $branch_ids)
                            ->paginate(10);


                        $request->session()->put('selection', 'priority');

                        $returnHTML = view('employee/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                        return $returnHTML;

                    }
                }
                elseif(isset($b_id)){

                    $b_id = substr($url, strrpos($url, '/') + 1);

                    $value = $request->session()->get('selection');
                    if($value == 'order_status'){

                        if(isset($b_id) && $b_id  == 'all'){

                            $ordersData = Order::orderBy('created_at', 'decs')
                                ->whereIn('branch_id', $branch_ids)
                                ->paginate(10);

                            $returnHTML = view('employee/orders.orderViewRender1', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }
                        elseif(isset($b_id)){

                            $order_status_id = $b_id;

                            $ordersData = Order::orderBy('created_at', 'decs')
                                ->where('order_status', $order_status_id)
                                ->whereIn('branch_id', $branch_ids)
                                ->paginate(10);

                            $returnHTML = view('employee/orders.orderViewRender1', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }

                    }
                   elseif ($value == 'priority'){

                        if(isset($b_id) && $b_id  == 'all'){

                            $ordersData = Order::orderBy('created_at', 'decs')
                                ->whereIn('branch_id', $branch_ids)
                                ->paginate(10);
                            $returnHTML = view('employee/orders.orderViewRender1', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }
                        elseif(isset($b_id)){

                            $priority_key_key = $b_id;

                            $ordersData = Order::orderBy('created_at', 'decs')
                                ->where('priority', $priority_key_key)
                                ->whereIn('branch_id', $branch_ids)
                                ->paginate(10);
                            $returnHTML = view('employee/orders.orderViewRender1', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }
                    }

                }
            }
            elseif(isset($branch_id)){

                if(isset($request->order_status_id)){

                    if($request->order_status_id == 'all') {

                        if (isset($request->priority)) {

                            if (isset($request->priority) && $request->priority == 'all') {

                                $ordersData = Order::orderBy('created_at', 'decs')
                                    ->where('branch_id', $branch_id)
                                    ->paginate(10);

                                $request->session()->put('selection', 'priority');

                                $returnHTML = view('employee/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();
                                return $returnHTML;

                            } else {
                                $ordersData = Order::orderBy('created_at', 'decs')
                                    ->where('priority', $request->priority)
                                    ->where('branch_id', $branch_id)
                                    ->paginate(10);

                                $request->session()->put('selection', 'priority');

                                $returnHTML = view('employee/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();
                                return $returnHTML;
                            }
                        } else {

                            $request->session()->put('selection', 'order_status');

                            $ordersData = Order::orderBy('created_at', 'decs')
                                ->where('branch_id', $request->branch_id)
                                ->paginate(10);

                            $returnHTML = view('employee/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }
                    }
                    elseif(isset($request->order_status_id)){

                        if (isset($request->priority)) {

                            if ($request->priority == 'all') {

                                $ordersData = Order::orderBy('created_at', 'decs')
                                    ->WhereIn('branch_id', $branch_ids)
                                    ->where('order_status', $request->order_status_id)
                                    ->paginate(10);

                                $request->session()->put('selection', 'priority');

                                $returnHTML = view('employee/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                                return $returnHTML;

                            }else{

                                $ordersData = Order::orderBy('created_at', 'decs')
                                    ->where('priority', $request->priority)
                                    ->WhereIn('branch_id', $branch_ids)
                                    ->where('order_status', $request->order_status_id)
                                    ->paginate(10);

                                $request->session()->put('selection', 'priority');

                                $returnHTML = view('employee/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                                return $returnHTML;
                            }
                        }
                        else{

                            $request->session()->put('selection', 'order_status');

                            $ordersData = Order::orderBy('created_at', 'decs')
                                ->WhereIn('branch_id', $branch_ids)
                                ->where('order_status', $request->order_status_id)
                                ->paginate(10);

                            $returnHTML = view('employee/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }
                    }
                }
                elseif (isset($request->priority)) {

                    if (isset($request->priority) && $request->priority == 'all') {

                        $ordersData = Order::orderBy('created_at', 'decs')
                            ->where('branch_id', $branch_id)
                            ->paginate(10);

                        $request->session()->put('selection', 'priority');

                        $returnHTML = view('employee/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();
                        return $returnHTML;

                    }else{
                        $ordersData = Order::orderBy('created_at', 'decs')
                            ->where('priority', $request->priority)
                            ->where('branch_id', $request->branch_id)
                            ->paginate(10);

                        $request->session()->put('selection', 'priority');

                        $returnHTML = view('employee/orders.orderViewRender', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();
                        return $returnHTML;
                    }
                }
                elseif(isset($b_id)){

                    $b_id = substr($url, strrpos($url, '/') + 1);

                    $value = $request->session()->get('selection');
                    if($value == 'order_status'){

                        if(isset($b_id) && $b_id  == 'all'){

                            $ordersData = Order::orderBy('created_at', 'decs')
                                ->where('branch_id', $branch_id)
                                ->paginate(10);

                            $returnHTML = view('employee/orders.orderViewRender1', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }
                        elseif(isset($b_id)){

                            $order_status_id = $b_id;

                            $ordersData = Order::orderBy('created_at', 'decs')
                                ->where('order_status', $order_status_id)
                                ->where('branch_id', $branch_id)
                                ->paginate(10);

                            $returnHTML = view('employee/orders.orderViewRender1', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }

                    }
                    elseif ($value == 'priority'){

                        if(isset($b_id) && $b_id  == 'all'){

                            $ordersData = Order::orderBy('created_at', 'decs')
                                ->where('branch_id', $branch_id)
                                ->paginate(10);
                            $returnHTML = view('employee/orders.orderViewRender1', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }
                        elseif(isset($b_id)){

                            $priority_key_key = $b_id;

                            $ordersData = Order::orderBy('created_at', 'decs')
                                ->where('priority', $priority_key_key)
                                ->where('branch_id', $branch_id)
                                ->paginate(10);
                            $returnHTML = view('employee/orders.orderViewRender1', compact('ordersData', 'dates', 'branches', 'priority', 'priority_4', 'priority_4_key', 'orderStatus', 'orderStatus_3', 'orderStatus_4', 'order_status_key', 'sidebar_items'))->render();

                            return $returnHTML;
                        }
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
        $order_search = $request->employee_order_search;

        $FillableDropdown = new FillableDropdown();
        $orderStatus = $FillableDropdown->orderStatusKeyValue($default = 3);
        $orderStatus_4 = $FillableDropdown->orderStatusKeyValue($default = 4);
        $orderStatus_3 = $FillableDropdown->orderStatusKeyValue($default = 3);
        $priority = $FillableDropdown->orderPriorityKeyValue($default = 3);
        $priority_4 = $FillableDropdown->orderPriorityKeyValue($default = 4);
        $order_status_key = 'all';
        $priority_4_key = 'all';

        $sidebar_items = array(
            "Order List" => array('url' => URL::route('v1.employee.order.index'), 'icon' => '<i class="fa fa-users"></i>'),
            'Add New' => array('url' => URL::route('v1.employee.order.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );


        if(!empty($order_search)){

            $orderSearchData = Order::where('id', $order_search)->take(30)->get();

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
//                dd($orderSearchData);

                $ordersData = [];
                return view('employee/orders.list', compact('orderSearchData', 'ordersData', 'orderStatus', 'orderStatus_3', 'orderStatus_4',  'order_status_key', 'branches', 'priority', 'priority_4', 'priority_4_key', 'sidebar_items'));

            }
        }
        else{

            return redirect()->route('v1.employee.order.index')->withErrors(["This Order does not exist"]);

        }

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeOrderStatusTo(Request $request)
    {

        $authentication = \App::make('authenticator');
        $authentication_helper = \App::make('authentication_helper');

        $branch_ids = array();
        $branch_id = null;
        $result = null;

        $employeePermissions = '_backman';
        $employeeAdminPermissions = '_manager';
        $adminPermissions = '_superadmin';

        $user = $authentication->getLoggedUser();

        if (isset($user)) {

            $perm = $user->permissions;
            $user_id = $user->id;

            if (isset($perm)) {

                foreach ($perm as $key => $val) {
                    $permission_name = $key;
                }
            }


            $authentication_helper->hasPermission($perm);
            if (isset($permission_name) && isset($user_id)) {

                if ($permission_name == $adminPermissions) {

                    $branch = Branch::all();

                    if (!empty($branch)) {
                        $result = Branch::all()->pluck('id');
                    }

                    if (isset($result) && count($result) > 0) {

                        if (isset($result) && count($result) > 1) {
                            foreach ($result as $key) {
                                $branch_ids[] = $key;
                            }
                        } else {
                            $branch_id = $result[0]->branch_id;
                        }
                    } else {
                        $ordersData = null;
                    }

                } elseif ($permission_name == $employeePermissions || $permission_name == $employeeAdminPermissions) {

                    $user = User::find($user_id);

                    if ($user) {

                        if (isset($user->branches)) {

                            if ($user->branches()->count() > 0) {

                                $result = $user->branches()->select('branch_id')->get();
                            }
                        }
                    }


                    if (isset($result) && count($result) > 0) {

                        if (isset($result) && count($result) > 1) {
                            foreach ($result as $key) {
                                $branch_ids[] = $key->branch_id;

                            }
                        } else {
                            $branch_id = $result[0]->branch_id;
                        }
                    } else {
                        $ordersData = null;
                    }


                }
            }


            $ajax_data = Input::all();
            $url = $request->path();


            if (isset($request->page)) {

                if (isset($url)) {
                    $b_id = substr($url, strrpos($url, '/') + 1);

                }
            }

            $sidebar_items = array(
                "List Items" => array('url' => URL::route('v1.employee.order.index'), 'icon' => '<i class="fa fa-users"></i>'),
                'Add New' => array('url' => URL::route('v1.employee.order.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
            );


            $FillableDropdown = new FillableDropdown();
            $orderStatus = $FillableDropdown->orderStatusKeyValue($default = 3);
            $orderStatus_1 = $FillableDropdown->orderStatusKeyValue($default = 1);
            $priority = $FillableDropdown->orderPriorityKeyValue($default = 3);

            $order_status_key = '';


            if (isset($branch_ids) && count($branch_ids) > 1) {

                if (isset($request->order_status) && isset($request->order_id)) {

                    $order_status_key = $request->order_status;
                    $order_id = $request->order_id;

                    if (isset($order_status_key) && isset($order_id)) {

                        $order = Order::find($order_id);
                        $order->order_status = $order_status_key;
                        $order->save();

                        $ordersData = Order::orderBy('order_status', 'asc')
                            ->orderBy('priority', 'asc')
                            ->orderBy('delivery_date', 'decs')
                            ->orderBy('delivery_time', 'decs')
                            ->whereIn('branch_id', $branch_ids)
                            ->paginate(20);

                        $order_status_key = '';
                        $returnHTML = view('employee/orders.orderViewRender', compact('ordersData', 'orderStatus', 'orderStatus_1', 'order_status_key', 'priority', 'sidebar_items'))->render();

                        return $returnHTML;

                    }
                }
                elseif(isset($b_id)) {

                    $ordersData = Order::orderBy('order_status', 'asc')
                        ->orderBy('priority', 'asc')
                        ->orderBy('delivery_date', 'decs')
                        ->orderBy('delivery_time', 'decs')
                        ->whereIn('branch_id', $branch_ids)
                        ->paginate(20);

                    $order_status_key = '';

                    $returnHTML = view('employee/orders.orderViewRender1', compact('ordersData', 'orderStatus', 'orderStatus_1', 'order_status_key', 'priority', 'sidebar_items'))->render();

                    return $returnHTML;

                }
            } elseif (isset($branch_id)) {

                if (isset($request->order_status) && isset($request->order_id)) {

                    $order_status_key = $request->order_status;
                    $order_id = $request->order_id;

                    if (isset($order_status_key) && isset($order_id)) {

                        $order = Order::find($order_id);
                        $order->order_status = $order_status_key;
                        $order->save();

                        $ordersData = Order::orderBy('order_status', 'asc')
                            ->orderBy('priority', 'asc')
                            ->orderBy('delivery_date', 'decs')
                            ->orderBy('delivery_time', 'decs')
                            ->where('branch_id', $branch_id)
                            ->paginate(20);

                        $order_status_key = '';
                        $returnHTML = view('employee/orders.orderViewRender', compact('ordersData', 'orderStatus', 'orderStatus_1', 'order_status_key', 'priority', 'sidebar_items'))->render();

                        return $returnHTML;

                    }
                }
                elseif(isset($b_id)) {

                    $ordersData = Order::orderBy('order_status', 'asc')
                        ->orderBy('priority', 'asc')
                        ->orderBy('delivery_date', 'decs')
                        ->orderBy('delivery_time', 'decs')
                        ->where('branch_id', $branch_id)
                        ->paginate(20);

                    $order_status_key = '';

                    $returnHTML = view('employee/orders.orderViewRender1', compact('ordersData', 'orderStatus', 'orderStatus_1', 'order_status_key', 'priority', 'sidebar_items'))->render();

                    return $returnHTML;

                }
            } else {

                return view('employee/orders.list', compact('ordersData', 'orderStatus', 'order_status_key', 'orderStatus_1'));

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
    public function show($id, Request $request)
    {

        $ajax_data = Input::all();
        $url = $request->path();

        if(isset($request->page)){

            if(isset($url)){
                $b_id = substr($url, strrpos($url, '/') + 1);
            }
        }

        $FillableDropdown = new FillableDropdown();
        $orderStatus = $FillableDropdown->orderStatusKeyValue($default = 3);
        $orderStatus_1 = $FillableDropdown->orderStatusKeyValue($default = 1);
        $priority = $FillableDropdown->orderPriorityKeyValue($default = 3);

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

        $sidebar_items = array(
            "List Items" => array('url' => URL::route('v1.employee.order.index'), 'icon' => '<i class="fa fa-users"></i>'),
            'Add New' => array('url' => URL::route('v1.employee.order.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );


            if (isset($request->order_status)) {
    
                $order_status_key = $request->order_status;
    
                if (isset($order_status_key) && $order_status_key == 'all') {
    
                    $ordersData = Order::orderBy('order_status', 'asc')
                        ->orderBy('priority', 'asc')
                        ->orderBy('delivery_date', 'decs')
                        ->orderBy('delivery_time', 'decs')
                        ->where('branch_id', $branch_id)
                        ->paginate(20);

                    $order_status_key = 0;

                    $returnHTML = view('employee/orders.orderViewRender', compact('ordersData', 'orderStatus', 'orderStatus_1', 'order_status_key', 'priority', 'sidebar_items'))->render();
    
                    return $returnHTML;
    
                }else{
                    $ordersData = Order::orderBy('created_at', 'decs')
                        ->where('order_status', $order_status_key)
                        ->where('branch_id', $branch_id)
                        ->paginate(20);
    
                    $returnHTML = view('employee/orders.orderViewRender', compact('ordersData', 'orderStatus', 'orderStatus_1', 'order_status_key', 'priority', 'sidebar_items'))->render();
    
                    return $returnHTML;
                }
            } 
            elseif(isset($b_id)) {

            $b_id = substr($url, strrpos($url, '/') + 1);

            $value = $request->session()->get('selection');

            if (isset($b_id) && $b_id == 'all') {

                $order_status_key = 0;

                $ordersData = Order::orderBy('order_status', 'asc')
                    ->orderBy('priority', 'asc')
                    ->orderBy('delivery_date', 'decs')
                    ->orderBy('delivery_time', 'decs')
                    ->where('branch_id', $branch_id)
                    ->paginate(20);

                $returnHTML = view('employee/orders.orderViewRender1', compact('ordersData', 'orderStatus', 'orderStatus_1', 'order_status_key', 'priority', 'sidebar_items'))->render();

                return $returnHTML;
            } elseif (isset($b_id)) {

                $order_status_key = $b_id;

                $ordersData = Order::orderBy('created_at', 'decs')
                    ->where('order_status', $order_status_key)
                    ->where('branch_id', $branch_id)
                    ->paginate(20);
                
                $returnHTML = view('employee/orders.orderViewRender1', compact('ordersData', 'orderStatus', 'orderStatus_1', 'order_status_key', 'priority', 'sidebar_items'))->render();

                return $returnHTML;
            }

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
