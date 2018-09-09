<?php

namespace App\Http\Controllers\Admin;

use App\Helper\FillableDropdown;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Configuration;

class ConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

//        $configData = Configuration::orderBy('created_at', 'asc')->get();
        $branchCode = Configuration::where('key', 'branch_id')->select('id', 'value')->get();
        $branchName = Configuration::where('key', 'branch_name')->select('id', 'value')->get();

        $remarksLimitKey = Configuration::where('key', 'remarks_key')->select('id', 'value')->get();
        $remarksLimitValue = Configuration::where('key', 'remarks_value')->select('id', 'value')->get();


//        dd($branchCode, $branchName);
        $sidebar_items = array(
            "List items" => array('url' => URL::route('configuration.index'), 'icon' => '<i class="fa fa-users"></i>'),
//            'Add New' => array('url' => URL::route('configuration.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );

        return view('admin/configuration.list', compact('branchCode', 'branchName', 'remarksLimitKey', 'remarksLimitValue', 'sidebar_items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sidebar_items = array(
            "List Items" => array('url' => URL::route('configuration.index'), 'icon' => '<i class="fa fa-users"></i>'),
            'Add New' => array('url' => URL::route('configuration.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );

        return view('admin/configuration.create', compact('category', 'active', 'sidebar_items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(!empty($request->remarksValue)){

            $remarksLimitLastKey = Configuration::orderBy('created_at', 'desc')
                ->select('value')
                ->where('key', 'remarks_key')
                ->first();


            if(isset($remarksLimitLastKey) && count($remarksLimitLastKey) > 0){

                $remarks_value = $request->remarksValue;
                $remarks_key   = $remarksLimitLastKey->value + 1;

                $remarksKeyData = [
                    'key'          => 'remarks_key',
                    'value'        => $remarks_key,
                ];
                $remarksValueData = [
                    'key'          => 'remarks_value',
                    'value'        => $remarks_value,
                ];
            }else{

                $remarks_value = $request->remarksValue;
                $remarks_key   = 0;

                $remarksKeyData = [
                    'key'          => 'remarks_key',
                    'value'        => $remarks_key,
                ];
                $remarksValueData = [
                    'key'          => 'remarks_value',
                    'value'        => $remarks_value,
                ];
            }
        }

        if(!empty($request->active)){

            $activeLastKey = Configuration::orderBy('created_at', 'desc')
                ->select('value')
                ->where('key', 'active_key')
                ->first();

            if(isset($activeLastKey) && count($activeLastKey) > 0){
                $active_value = $request->active;
                $active_key   = $activeLastKey->value + 1;

                $activeKeyData = [
                    'key'          => 'active_key',
                    'value'        => $active_key,
                ];
                $activeValueData = [
                    'key'          => 'active_value',
                    'value'        => $active_value,
                ];
            }else{
                $active_value = $request->active;
                $active_key   = 0;

                $activeKeyData = [
                    'key'          => 'active_key',
                    'value'        => $active_key,
                ];
                $activeValueData = [
                    'key'          => 'active_value',
                    'value'        => $active_value,
                ];
            }
        }

        if(!empty($request->priority)){

            $priorityLastKey = Configuration::orderBy('created_at', 'desc')
                ->select('value')
                ->where('key', 'priority_key')
                ->first();

            if(isset($priorityLastKey) && count($priorityLastKey) > 0){
                $priority_value = $request->priority;
                $priority_key   = $priorityLastKey->value + 1;

                $priorityKeyData = [
                    'key'          => 'priority_key',
                    'value'        => $priority_key,
                ];
                $priorityValueData = [
                    'key'          => 'priority_value',
                    'value'        => $priority_value,
                ];
            }else{
                $priority_value = $request->active;
                $priority_key   = 0;

                $priorityKeyData = [
                    'key'          => 'priority_key',
                    'value'        => $priority_key,
                ];
                $priorityValueData = [
                    'key'          => 'priority_value',
                    'value'        => $priority_value,
                ];
            }
        }

        if(!empty($request->order_type)){

            $orderTypeLastKey = Configuration::orderBy('created_at', 'desc')
                ->select('value')
                ->where('key', 'order_type_key')
                ->first();

            if(isset($orderTypeLastKey) && count($orderTypeLastKey) > 0){
                $order_type_value = $request->order_type;
                $order_type_key   = $orderTypeLastKey->value + 1;

                $orderTypeKeyData = [
                    'key'          => 'order_type_key',
                    'value'        => $order_type_key,
                ];
                $orderTypeValueData = [
                    'key'          => 'order_type_value',
                    'value'        => $order_type_value,
                ];
            }else{
                $order_type_value = $request->order_type;
                $order_type_key   = 0;

                $orderTypeKeyData = [
                    'key'          => 'order_type_key',
                    'value'        => $order_type_key,
                ];
                $orderTypeValueData = [
                    'key'          => 'order_type_value',
                    'value'        => $order_type_value,
                ];
            }
        }

        if(!empty($request->order_status)){

            $orderStatusLastKey = Configuration::orderBy('created_at', 'desc')
                ->select('value')
                ->where('key', 'order_status_key')
                ->first();

            if(isset($orderStatusLastKey) && count($orderStatusLastKey) > 0){
                $order_status_value = $request->order_status;
                $order_status_key   = $orderStatusLastKey->value + 1;

                $orderStatusKeyData = [
                    'key'          => 'order_status_key',
                    'value'        => $order_status_key,
                ];
                $orderStatusValueData = [
                    'key'          => 'order_status_value',
                    'value'        => $order_status_value,
                ];
            }else{
                $order_status_value = $request->order_status;
                $order_status_key   = 0;

                $orderStatusKeyData = [
                    'key'          => 'order_status_key',
                    'value'        => $order_status_key,
                ];
                $orderStatusValueData = [
                    'key'          => 'order_status_value',
                    'value'        => $order_status_value,
                ];
            }
        }

        if(!empty($request->payment_type)){

            $paymentTypeLastKey = Configuration::orderBy('created_at', 'desc')
                ->select('value')
                ->where('key', 'payment_type_key')
                ->first();

            if(isset($paymentTypeLastKey) && count($paymentTypeLastKey) > 0){
                $payment_type_value = $request->payment_type;
                $payment_type_key   = $paymentTypeLastKey->value + 1;

                $paymentTypeKeyData = [
                    'key'          => 'payment_type_key',
                    'value'        => $payment_type_key,
                ];
                $paymentTypeValueData = [
                    'key'          => 'payment_type_value',
                    'value'        => $payment_type_value,
                ];
            }else{
                $payment_type_value = $request->payment_type;
                $payment_type_key   = 0;

                $paymentTypeKeyData = [
                    'key'          => 'payment_type_key',
                    'value'        => $payment_type_key,
                ];
                $paymentTypeValueData = [
                    'key'          => 'payment_type_value',
                    'value'        => $payment_type_value,
                ];
            }
        }

        if(!empty($request->payment_status)){

            $paymentStatusLastKey = Configuration::orderBy('created_at', 'desc')
                ->select('value')
                ->where('key', 'payment_status_key')
                ->first();

            if(isset($paymentStatusLastKey) && count($paymentStatusLastKey) > 0){
                $payment_status_value = $request->payment_status;
                $payment_status_key   = $paymentStatusLastKey->value + 1;

                $paymentStatusKeyData = [
                    'key'          => 'payment_status_key',
                    'value'        => $payment_status_key,
                ];
                $paymentStatusValueData = [
                    'key'          => 'payment_status_value',
                    'value'        => $payment_status_value,
                ];
            }else{
                $payment_status_value = $request->payment_status;
                $payment_status_key   = 0;

                $paymentStatusKeyData = [
                    'key'          => 'payment_status_key',
                    'value'        => $payment_status_key,
                ];
                $paymentStatusValueData = [
                    'key'          => 'payment_status_value',
                    'value'        => $payment_status_value,
                ];
            }
        }

        if(!empty($request->branch_name)){

            $branchIdLastKey = Configuration::orderBy('created_at', 'desc')
                ->select('value')
                ->where('key', 'branch_id')
                ->first();

            if(isset($branchIdLastKey) && count($branchIdLastKey) > 0){
                $branch_name = $request->branch_name;
                $branch_id   = $branchIdLastKey->value + 1;

                $branchIdData = [
                    'key'          => 'branch_id',
                    'value'        => $branch_id,
                ];
                $branchNameData = [
                    'key'          => 'branch_name',
                    'value'        => $branch_name,
                ];
            }else{
                $branch_name = $request->branch_name;
                $branch_id   = 0;

                $branchIdData = [
                    'key'          => 'branch_id',
                    'value'        => $branch_id,
                ];
                $branchNameData = [
                    'key'          => 'branch_name',
                    'value'        => $branch_name,
                ];
            }
        }


        if(isset($remarksKeyData) && isset($remarksValueData)){

            Configuration::create($remarksKeyData);
            Configuration::create($remarksValueData);
        }

        if(isset($activeKeyData) && isset($activeValueData)){

            Configuration::create($activeKeyData);
            Configuration::create($activeValueData);
        }

        if(isset($priorityKeyData) && isset($priorityValueData)){

            Configuration::create($priorityKeyData);
            Configuration::create($priorityValueData);
        }

        if(isset($orderTypeKeyData) && isset($orderTypeValueData)){

            Configuration::create($orderTypeKeyData);
            Configuration::create($orderTypeValueData);
        }

        if(isset($orderStatusKeyData) && isset($orderStatusValueData)){

            Configuration::create($orderStatusKeyData);
            Configuration::create($orderStatusValueData);
        }

        if(isset($paymentTypeKeyData) && isset($paymentTypeValueData)){

            Configuration::create($paymentTypeKeyData);
            Configuration::create($paymentTypeValueData);
        }

        if(isset($paymentStatusKeyData) && isset($paymentStatusValueData)){

            Configuration::create($paymentStatusKeyData);
            Configuration::create($paymentStatusValueData);
        }

        if(isset($branchIdData) && isset($branchNameData)){

            Configuration::create($branchIdData);
            Configuration::create($branchNameData);
        }


        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd('show method');
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
            "List Items" => array('url' => URL::route('configuration.index'), 'icon' => '<i class="fa fa-product-hunt" aria-hidden="true"></i>'),
            'Add Item' => array('url' => URL::route('configuration.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );

        $configuration = Configuration::findOrFail($id);

        return view('admin/configuration.edit', compact('sidebar_items', 'configuration'));
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

        if(isset($request->value) && isset($request->key)){

            $name = $request->value;
            $code = $request->key;

            $config = Configuration::findOrFail($id);
            if($config && $code) {
                $config->value = $code;
                $config->save();
            }
            $config = Configuration::findOrFail($id+1);
            if($config && $name) {
                $config->value = $name;
                $config->save();
            }

        }


        if(isset($request->remarksValue)){

            $remarksLimitValue = $request->remarksValue;

            $config = Configuration::findOrFail($id);
            if($config && $remarksLimitValue) {

                $config->value = $remarksLimitValue;
                $config->save();
            }

        }


//        Configuration::where('id', $id)->update([$value]);

//
//        $value = $request->value;
//        $config = Configuration::findOrFail($id);
//        if($config && $value) {
//            $config->value = $value;
//            $config->save();
//        }

//        Configuration::where('id', $id)->update([$value]);

        return redirect()->route('configuration.index');
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $item = Configuration::findOrFail($id);

        if($item){
            $item->delete();
        }

        $item = Configuration::findOrFail($id+1);

        if($item){
            $item->delete();
        }

        return redirect()->route('configuration.index');
    }
}