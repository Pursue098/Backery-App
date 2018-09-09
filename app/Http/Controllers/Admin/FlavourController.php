<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;

use App\Flavour;
use App\Product;
use App\Helper\FillableDropdown;

class FlavourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $flavourData = Flavour::orderBy('created_at', 'asc')->paginate(40);
        $sidebar_items = array(
            "Flavour List" => array('url' => URL::route('flavour.index'), 'icon' => '<i class="fa fa-users"></i>'),
            'Add New' => array('url' => URL::route('flavour.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );

        $FillableDropdown = new FillableDropdown();
        $active = $FillableDropdown->orderActiveKeyValue($default = 1);

        return view('admin/flavour.list',  compact('flavourData', 'active', 'sidebar_items'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sidebar_items = array(
            "Flavour List" => array('url' => URL::route('flavour.index'), 'icon' => '<i class="fa fa-users"></i>'),
            'Add New' => array('url' => URL::route('flavour.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );

        $FillableDropdown = new FillableDropdown();
        $active = $FillableDropdown->active($default = false);

        return view('admin/flavour.create', compact('sidebar_items', 'active'));
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
            'name'                  => 'required',
            'active'                => 'required',
        ]);

        if ($validator->fails()) {

            return redirect()->route('flavour.create')->withInput()->withErrors($validator);
        }

        // store
      
        $data = [
            'name'           => $request->name,
            'active'         => $request->active,
        ];

        Flavour::create($data);


        // redirect
        return redirect()->route('flavour.index');
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
        $flavour = Flavour::findOrFail($id);
        $sidebar_items = array(
            "Flavour List" => array('url' => URL::route('flavour.index'), 'icon' => '<i class="fa fa-users"></i>'),
            'Add New' => array('url' => URL::route('flavour.create'), 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );

        $FillableDropdown = new FillableDropdown();
        $active = $FillableDropdown->active($default = false);

        return view('admin/flavour.edit', compact('flavour', 'active', 'sidebar_items'));
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
            'name'                  => 'required',
            'active'                => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('flavour.edit', $id)
                ->withInput()
                ->withErrors($validator);
        }

        // store
        $data = [
            'name'                  => $request->name,
            'active'                => $request->active,
        ];

        Flavour::where('id', $id)->update($data);
        return redirect()->route('flavour.index');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $flavour = Flavour::find($id);
//        dd($product);

        if ($flavour){
//            dd($flavour->products->count());
            if($flavour->products->count()){
                return redirect()->back()->withErrors(['Can not delete this flavor. Products are associated with it.']);
            }
            else{
                $flavour->delete();

                return redirect()->route('flavour.index');
            }
        }
        else
        {
            return false;
        }
    }
}
