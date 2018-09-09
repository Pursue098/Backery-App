@extends('laravel-authentication-acl::admin.layouts.base-2cols')

@section('title')
    Admin area: category list
@stop

@section('content')
<div class="panel panel-info">
    <div class="panel-body">
      <div class="row">
          <div class="col-md-12">
              @if($orders)
              <table class="table table-bordered table-inverse" style="font-size: 12px">
                      <thead>
                      <tr>
                          <th>Cust Name</th>
                          <th>ProductName</th>
                          <th>Weight</th>
                          <th>Quantity</th>
                          <th>Flavor</th>
                          <th>Price</th>
                          <th>Advance Price</th>
                          <th>Order Status</th>
                          <th>Remarks</th>
                          <th>Image</th>
                          <th>Branch ID</th>
                          <th>Operations</th>
                      </tr>
                      </thead>
                      <tbody>
                      @foreach($orders as $order)
                          <tr>
                              @if(isset($order->cust_name))
                                  <td>{!! $order->cust_name!!}</td>
                              @else
                                  <td > </td>
                              @endif
                              @if(isset($order->products->first()->name))
                                  <td>{!! $order->products->first()->name!!}</td>
                              @else
                                  <td > </td>
                              @endif
                              @if(isset($order->weight))
                                  <td style="text-align: center">{!! $order->weight!!}</td>
                              @else
                                  <td > </td>
                              @endif
                              @if(isset($order->quantity))
                                  <td style="text-align: center">{!! $order->quantity!!}</td>
                              @else
                                  <td > </td>
                              @endif
                              @if(isset($order->flavor))
                                  <td>{!! $order->flavor!!}</td>
                              @else
                                  <td > </td>
                              @endif
                              @if(isset($order->price))
                                  <td style="text-align: center">{!! $order->price!!}</td>
                              @else
                                  <td > </td>
                              @endif
                              @if(isset($order->advance_price))
                                  <td style="text-align: center">{!! $order->advance_price!!}</td>
                              @else
                                  <td > </td>
                              @endif
                              @if(isset($order->order_status))
                                  @if($order->order_status == 0)
                                      <td>un-Processed</td>
                                  @endif
                                  @if($order->order_status == 1)
                                      <td>Processed</td>
                                  @endif
                                  @if($order->order_status == 2)
                                      <td>Padding</td>
                                  @endif
                                  @if($order->order_status == 3)
                                      <td>Canceled</td>
                                  @endif
                              @endif

                              @if(isset($order->remarks))
                                  <td>{!! $order->remarks!!}</td>
                              @else
                                  <td > </td>
                              @endif
                              @if(isset($order->products->first()->image))
                                  {{ Form::image(url('assets/images/usersImages/product/'.$order->products->first()->image), 'op_old_image', array("class"=>"op_old_image", "style" => "width: 50px; height: 50px; margin-left:20px; border: 1px solid black;")) }}
                              @else
                                  <td > </td>
                              @endif
                              @if(isset($order->branches->name))
                                  {!! $order->branches->name !!}
                              @else
                                  <td > </td>
                              @endif

                              <td>
                                  @if( $order->id)

                                      <a href="{!! URL::route('order.edit', ['id' => $order->id]) !!}"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                      {!! Form::model($order, [ 'url' => URL::route('order.destroy', ['id' => $order->id])] )  !!}
                                      {{ Form::hidden('_method', 'DELETE') }}

                                      {{--Form for dlete request--}}
                                      {!! Form::submit('Delete', array("class"=>"btn btn-info pull-right order_del_from_index", "style"=>"margin-left:30px;margin-top:-30px;")) !!}
                                      {!! Form::close() !!}
                                  @else
                                      <i class="fa fa-times fa-2x light-blue"></i>
                                      <i class="fa fa-times fa-2x margin-left-12 light-blue"></i>
                                  @endif
                              </td>
                          </tr>
                      </tbody>
                  @endforeach
              </table>
              @else
                  <span class="text-warning"><h5>Haven't Order.</h5></span>
              @endif

                  @if(count($productSearchData) > 0)
                      <table class="table table-bordered table-inverse" style="font-size: 12px">
                          <thead>
                          <tr>
                              <th>Product ID</th>
                              <th>C-name</th>
                              <th>Name</th>
                              <th>Weight</th>
                              <th>Flavor</th>
                              <th>Price</th>
                              <th>Status</th>
                              <th>Max_age</th>
                              <th>Min_age</th>
                              <th>Tag</th>
                              <th>Image</th>
                              <th>Operations</th>
                          </tr>
                          </thead>
                          <tbody>
                          @foreach($productsData as $product)
                              @if($product->active == 0)
                                  <tr id="process_block" style="background-color: rgba(205, 205, 205, 0.58); color: #000000;">

                                      @if(isset($product->id))
                                          <td style="text-align: center">{!! $product->id !!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->category->name))
                                          <td >{!! $product->category->name !!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->name))
                                          <td >{!! $product->name !!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->weight))
                                          <td style="text-align: center">{!! $product->weight !!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->flavors->first()->name))
                                          <td >{!! $product->flavors->first()->name!!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->price))
                                          <td style="text-align: center">{!! $product->price !!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->active))
                                          @if($product->active == $active[0]['key'])
                                              <td>{!! $active[0]['value'] !!}</td>
                                          @elseif($product->active == $active[1]['key'])
                                              <td>{!! $active[1]['value'] !!}</td>
                                          @endif
                                      @else
                                          <td> </td>
                                      @endif
                                      @if(isset($product->max_age))
                                          <td style="text-align: center">{!! $product->max_age !!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->min_age))
                                          <td style="text-align: center">{!! $product->min_age !!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->tag))
                                          <td >{!! $product->tag !!}</td>
                                      @else
                                          <td > </td>
                                      @endif

                                      @if(isset($product->image))
                                          <td>
                                              <img style="width: 50px; height: 50px;" src="{{ asset('assets/images/usersImages/product/'.$product->image ) }}"  style="width: 50px; height: 50px;"/>
                                          </td>
                                      @else
                                          <td > </td>
                                      @endif


                                      <td>
                                          @if( $product->id)

                                              <a href="{!! URL::route('products.edit', ['id' => $product->id]) !!}"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                              {!! Form::model($product, [ 'url' => URL::route('products.destroy', ['id' => $product->id])] )  !!}
                                              {{ Form::hidden('_method', 'DELETE') }}

                                              {{--Form for dlete request--}}
                                              {!! Form::submit('Delete', array("class"=>"btn btn-info pull-right p_del_from_index ", "style"=>"margin-left:30px;margin-top:-30px;")) !!}
                                              {!! Form::close() !!}
                                          @else
                                              <i class="fa fa-times fa-2x light-blue"></i>
                                              <i class="fa fa-times fa-2x margin-left-12 light-blue"></i>
                                          @endif
                                      </td>
                                  </tr>
                              @else
                                  <tr>
                                      @if(isset($product->id))
                                          <td style="text-align: center">{!! $product->id !!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->category->name))
                                          <td >{!! $product->category->name !!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->name))
                                          <td >{!! $product->name !!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->weight))
                                          <td style="text-align: center">{!! $product->weight !!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->flavors->first()->name))
                                          <td >{!! $product->flavors->first()->name!!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->price))
                                          <td style="text-align: center">{!! $product->price !!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->active))
                                          @if($product->active == $active[0]['key'])
                                              <td>{!! $active[0]['value'] !!}</td>
                                          @elseif($product->active == $active[1]['key'])
                                              <td>{!! $active[1]['value'] !!}</td>
                                          @endif
                                      @else
                                          <td> </td>
                                      @endif
                                      @if(isset($product->max_age))
                                          <td style="text-align: center">{!! $product->max_age !!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->min_age))
                                          <td style="text-align: center">{!! $product->min_age !!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->tag))
                                          <td >{!! $product->tag !!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->image))
                                          <td>
                                              <img style="width: 50px; height: 50px;" src="{{ asset('assets/images/usersImages/product/'.$product->image ) }}"  style="width: 50px; height: 50px;"/>
                                          </td>
                                      @else
                                          <td > </td>
                                      @endif

                                      <td>
                                          @if( $product->id)

                                              <a href="{!! URL::route('products.edit', ['id' => $product->id]) !!}"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                              {!! Form::model($product, [ 'url' => URL::route('products.destroy', ['id' => $product->id])] )  !!}
                                              {{ Form::hidden('_method', 'DELETE') }}

                                              {{--Form for dlete request--}}
                                              {!! Form::submit('Delete', array("class"=>"btn btn-info pull-right p_del_from_index ", "style"=>"margin-left:30px;margin-top:-30px;")) !!}
                                              {!! Form::close() !!}
                                          @else
                                              <i class="fa fa-times fa-2x light-blue"></i>
                                              <i class="fa fa-times fa-2x margin-left-12 light-blue"></i>
                                          @endif
                                      </td>
                                  </tr>
                              @endif
                          </tbody>
                          @endforeach
                      </table>
                  @elseif(count($productsData) > 0)
                      <div style="text-align: center">
                          @if($productsData->render())
                              {{$productsData->render()}}
                          @endif
                      </div>
                      <table class="table table-bordered table-inverse" style="font-size: 12px">
                          <thead>
                          <tr>
                              <th>Product ID</th>
                              <th>C-name</th>
                              <th>Name</th>
                              <th>Weight</th>
                              <th>Flavor</th>
                              <th>Price</th>
                              <th>Status</th>
                              <th>Max_age</th>
                              <th>Min_age</th>
                              <th>Tag</th>
                              <th>Image</th>
                              <th>Operations</th>
                          </tr>
                          </thead>
                          <tbody>
                          @foreach($productsData as $product)
                              @if($product->active == 0)
                                  <tr id="process_block" style="background-color: rgba(205, 205, 205, 0.58); color: #000000;">

                                      @if(isset($product->id))
                                          <td style="text-align: center">{!! $product->id !!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->category->name))
                                          <td >{!! $product->category->name !!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->name))
                                          <td >{!! $product->name !!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->weight))
                                          <td style="text-align: center">{!! $product->weight !!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->flavors->first()->name))
                                          <td >{!! $product->flavors->first()->name!!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->price))
                                          <td style="text-align: center">{!! $product->price !!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->active))
                                          @if($product->active == $active[0]['key'])
                                              <td>{!! $active[0]['value'] !!}</td>
                                          @elseif($product->active == $active[1]['key'])
                                              <td>{!! $active[1]['value'] !!}</td>
                                          @endif
                                      @else
                                          <td> </td>
                                      @endif
                                      @if(isset($product->max_age))
                                          <td style="text-align: center">{!! $product->max_age !!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->min_age))
                                          <td style="text-align: center">{!! $product->min_age !!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->tag))
                                          <td >{!! $product->tag !!}</td>
                                      @else
                                          <td > </td>
                                      @endif

                                      @if(isset($product->image))
                                          <td>
                                              <img style="width: 50px; height: 50px;" src="{{ asset('assets/images/usersImages/product/'.$product->image ) }}"  style="width: 50px; height: 50px;"/>
                                          </td>
                                      @else
                                          <td > </td>
                                      @endif


                                      <td>
                                          @if( $product->id)

                                              <a href="{!! URL::route('products.edit', ['id' => $product->id]) !!}"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                              {!! Form::model($product, [ 'url' => URL::route('products.destroy', ['id' => $product->id])] )  !!}
                                              {{ Form::hidden('_method', 'DELETE') }}

                                              {{--Form for dlete request--}}
                                              {!! Form::submit('Delete', array("class"=>"btn btn-info pull-right p_del_from_index ", "style"=>"margin-left:30px;margin-top:-30px;")) !!}
                                              {!! Form::close() !!}
                                          @else
                                              <i class="fa fa-times fa-2x light-blue"></i>
                                              <i class="fa fa-times fa-2x margin-left-12 light-blue"></i>
                                          @endif
                                      </td>
                                  </tr>
                              @else
                                  <tr>
                                      @if(isset($product->id))
                                          <td style="text-align: center">{!! $product->id !!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->category->name))
                                          <td >{!! $product->category->name !!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->name))
                                          <td >{!! $product->name !!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->weight))
                                          <td style="text-align: center">{!! $product->weight !!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->flavors->first()->name))
                                          <td >{!! $product->flavors->first()->name!!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->price))
                                          <td style="text-align: center">{!! $product->price !!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->active))
                                          @if($product->active == $active[0]['key'])
                                              <td>{!! $active[0]['value'] !!}</td>
                                          @elseif($product->active == $active[1]['key'])
                                              <td>{!! $active[1]['value'] !!}</td>
                                          @endif
                                      @else
                                          <td> </td>
                                      @endif
                                      @if(isset($product->max_age))
                                          <td style="text-align: center">{!! $product->max_age !!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->min_age))
                                          <td style="text-align: center">{!! $product->min_age !!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->tag))
                                          <td >{!! $product->tag !!}</td>
                                      @else
                                          <td > </td>
                                      @endif
                                      @if(isset($product->image))
                                          <td>
                                              <img style="width: 50px; height: 50px;" src="{{ asset('assets/images/usersImages/product/'.$product->image ) }}"  style="width: 50px; height: 50px;"/>
                                          </td>
                                      @else
                                          <td > </td>
                                      @endif

                                      <td>
                                          @if( $product->id)

                                              <a href="{!! URL::route('products.edit', ['id' => $product->id]) !!}"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                              {!! Form::model($product, [ 'url' => URL::route('products.destroy', ['id' => $product->id])] )  !!}
                                              {{ Form::hidden('_method', 'DELETE') }}

                                              {{--Form for dlete request--}}
                                              {!! Form::submit('Delete', array("class"=>"btn btn-info pull-right p_del_from_index ", "style"=>"margin-left:30px;margin-top:-30px;")) !!}
                                              {!! Form::close() !!}
                                          @else
                                              <i class="fa fa-times fa-2x light-blue"></i>
                                              <i class="fa fa-times fa-2x margin-left-12 light-blue"></i>
                                          @endif
                                      </td>
                                  </tr>
                              @endif
                          </tbody>
                          @endforeach
                      </table>
                      <div style="text-align: center">
                          @if($productsData->render())
                              {{$productsData->render()}}
                          @endif
                      </div>
                  @else
                      <span class="text-warning"><h5>No results found.</h5></span>
                  @endif

          </div>
      </div>
    </div>
</div>
@stop

@section('footer_scripts')
    <script>
        $(".delete").click(function(){
            return confirm("Are you sure to delete this item?");
        });
        $(".order_del_from_index").click(function(){
            return confirm("Are you sure to delete this item?");
        });

    </script>

    <style>
        .pagination{margin: 0; margin-bottom: 10px;}
        thead{ background-color: #d9edf7}
    </style>
@stop
