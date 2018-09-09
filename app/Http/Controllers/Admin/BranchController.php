<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;

use App\Branch;
use App\Helper\FillableDropdown;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branchData = Branch::orderBy('created_at', 'asc')->paginate(10);
        $sidebar_items = array(
            "Branch List" => array('url' => URL::route('branch.index'), 'icon' => '<i class="fa fa-users"></i>'),
            'Add New' => array('url' => URL::route('branch.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );

        $FillableDropdown = new FillableDropdown();
        $active = $FillableDropdown->orderActiveKeyValue($default = 1);

        return view('admin/branches.list',  compact('branchData', 'active', 'sidebar_items'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sidebar_items = array(
            "Branch List" => array('url' => URL::route('branch.index'), 'icon' => '<i class="fa fa-users"></i>'),
            'Add New' => array('url' => URL::route('branch.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );

        $FillableDropdown = new FillableDropdown();
        $active = $FillableDropdown->active($default = false);

        return view('admin/branches.create', compact('sidebar_items', 'active'));
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
            'name'          => 'required',
            'code'          => 'required|unique:branches',
            'address'       => 'required',
            'phone'         => 'required'
        ]);

        if ($validator->fails()) {

            return redirect()->route('branch.create')->withInput()->withErrors($validator);
        }

        // store
        $data = [
            'name'          => $request->name,
            'code'          => $request->code,
            'address'       => $request->address,
            'phone'         => $request->phone,
            'active'        => $request->active
        ];

        Branch::create($data);
        return redirect()->route('branch.index');
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function assignUserToBranch()
    {
        dd('reach here');
    }


     /**
     * Assign branch to user. 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if (isset($request->selected_branch_id) && isset($request->id) && isset($request->operation)){

            $branch_id = $request->selected_branch_id;

            $user_id = $request->id;
            $operation = $request->operation;
        }else{

            return redirect()->back()->withErrors(['Operation could not succeed. Please try again. ']);

        }

        if($operation == 0){

            $branch = Branch::find($branch_id);
            if($branch){
                $branch->users()->detach($user_id);
            }
            return redirect()->back();
        }

        if($operation == 1){

            $branch = Branch::find($branch_id);
            if($branch){

                $branch->users()->attach($user_id);
            }
            return redirect()->back();
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
        $sidebar_items = array(
            "Branch List" => array('url' => URL::route('branch.index'), 'icon' => '<i class="fa fa-users"></i>'),
            'Add New' => array('url' => URL::route('branch.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );

        $branch = Branch::findOrFail($id);

        $FillableDropdown = new FillableDropdown();
        $active = $FillableDropdown->active($default = false);

        return view('admin/branches.edit', compact('sidebar_items', 'branch', 'active'));
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
            'name'          => 'required',
            'code'          => 'required',
            'address'       => 'required',
            'phone'         => 'required',
            'active'        => 'required',

        ]);

        if ($validator->fails()) {
            return redirect()->route('branch.edit', $id)
                ->withInput()
                ->withErrors($validator);
        }

        // store
        $data = [
            'name'          => $request->name,
            'code'          => $request->code,
            'address'       => $request->address,
            'phone'         => $request->phone,
            'active'        => $request->active
        ];

        Branch::where('id', $id)->update($data);
        return redirect()->route('branch.index');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
        $branch = Branch::findOrFail($id);


        if ($branch){
//            dd($product->order);
            if($branch->orders->count(1)){
                return redirect()->back()->withErrors(['Can not delete it. Orders are associated with it.']);
            }
            else{

                $branch->delete();
                return redirect()->route('branch.index');
            }
        }
        else
        {
            return false;
        }

    }
}
