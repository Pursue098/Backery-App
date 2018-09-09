
<div class="panel panel-info renderOrderData1">
    <div class="panel-heading">
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">

                @if(count($orderSearchData) > 0)
                    <table class="table table-bordered table-inverse" style="font-size: 12px">
                        <thead style="background-color: #d9edf7; font-size: 12px">
                        <tr>
                            <th>Order#</th>
                            <th>Product id</th>
                            <th>Cust Name</th>
                            <th>ProductName</th>
                            <th>Weight</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Advance Price</th>
                            <th>Order Status</th>
                            <th>Priority</th>
                            <th>Created Date</th>
                            <th>Branch ID</th>
                            <th>Default Image</th>
                            <th>New Created</th>
                            <th>Operations</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ordersData1 as $order)
                            @if(isset($order->active) && $order->active == 0)
                                <tr style="background-color: rgba(205, 205, 205, 0.58)">
                                    <td style="text-align: center">{!! $order->id!!}</td>
                                    @if(isset($order->products()->first()->id))
                                        <td style="text-align: center">{!! $order->products()->first()->id !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->cust_name))
                                        <td>{!! $order->cust_name!!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->products()->first()->name))
                                        <td>{!! $order->products()->first()->name!!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->weight))
                                        <td style="text-align: center">{!! $order->weight !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->quantity))
                                        <td style="text-align: center">{!! $order->quantity !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->price))
                                        <td style="text-align: center">{!! $order->price !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->advance_price))
                                        <td style="text-align: center">{!! $order->advance_price !!}</td>
                                    @else
                                        <td></td>
                                    @endif

                                    @if(isset($order->order_status))
                                        @if($order->order_status == $orderStatus_3[0]['key'])
                                            <td>{{$orderStatus_3[0]['value']}}</td>
                                        @endif
                                        @if($order->order_status == $orderStatus_3[1]['key'])
                                            <td>{{$orderStatus_3[1]['value']}}</td>
                                        @endif
                                        @if($order->order_status == $orderStatus_3[2]['key'])
                                            <td>{{$orderStatus_3[2]['value']}}</td>
                                        @endif
                                        @if($order->order_status == $orderStatus_3[3]['key'])
                                            <td>{{$orderStatus_3[3]['value']}}</td>
                                        @endif
                                    @endif

                                    @if(isset($order->priority))
                                        @if($order->priority == $priority[0]['key'])
                                            <td>{{$priority[0]['value']}}</td>
                                        @endif
                                        @if($order->priority == $priority[1]['key'])
                                            <td>{{$priority[1]['value']}}</td>
                                        @endif
                                        @if($order->priority == $priority[2]['key'])
                                            <td>{{$priority[2]['value']}}</td>
                                        @endif
                                    @else
                                        <td> </td>
                                    @endif

                                    @if(isset($order->delivery_date))
                                        <td>{!! date("Y-m-d", strtotime($order->delivery_date)) !!}</td>
                                    @else
                                        <td></td>
                                    @endif

                                    <td>
                                        @if(isset($order->branch->name))
                                            {!! $order->branch->name !!}
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($order->products()->first()->image))
                                            {{ Form::image(url('assets/images/usersImages/product/'.$order->products[0]->image), 'op_old_image', array("class"=>"op_old_image", "style" => "  width: 50px; height: 50px; margin-left:20px; border: 1px solid black;")) }}
                                        @else
                                            {{ Form::image(url('assets/images/staticImage/productDefaultImage.png'), 'op_old_image', array("class"=>"op_old_image", "style" => "  width: 50px; height: 50px; margin-left:20px; border: 1px solid black;")) }}
                                        @endif

                                    </td>
                                    <td>
                                        @if(isset($order->image))
                                            {{ Form::image(url('assets/images/usersImages/product/'.$order->image), 'op_old_image', array("class"=>"op_old_image", "style" => "  width: 50px; height: 50px; margin-left:20px; border: 1px solid black;")) }}

                                        @endif

                                    </td>
                                    <td>
                                        @if( $order->id)

                                            <a href="{!! URL::route('v1.employee_admin.order.edit', ['id' => $order->id]) !!}"><i class="fa fa-pencil-square-o fa-2x"></i></a>

                                            {{ Form::open([ 'url' => URL::route('v1.employee_admin.order.destroy',['id' => $order->id]),'class'=>'OrderDelete']) }}
                                            {{ Form::hidden('_method', 'DELETE') }}
                                            {!! Form::submit('Delete', array("class"=>"btn btn-info pull-right",
                                            "style"=>"margin-left:35px;margin-top:-30px;")) !!}
                                            {!! Form::close() !!}

                                        @else
                                            <i class="fa fa-times fa-2x light-blue"></i>
                                            <i class="fa fa-times fa-2x margin-left-12 light-blue"></i>
                                        @endif
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td style="text-align: center">{!! $order->id!!}</td>
                                    @if(isset($order->products()->first()->id))
                                        <td style="text-align: center">{!! $order->products()->first()->id !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->cust_name))
                                        <td>{!! $order->cust_name!!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->products()->first()->name))
                                        <td>{!! $order->products()->first()->name!!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->weight))
                                        <td style="text-align: center">{!! $order->weight !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->quantity))
                                        <td style="text-align: center">{!! $order->quantity !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->price))
                                        <td style="text-align: center">{!! $order->price !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->advance_price))
                                        <td style="text-align: center">{!! $order->advance_price !!}</td>
                                    @else
                                        <td></td>
                                    @endif

                                    @if(isset($order->order_status))
                                        @if($order->order_status == $orderStatus_3[0]['key'])
                                            <td>{{$orderStatus_3[0]['value']}}</td>
                                        @endif
                                        @if($order->order_status == $orderStatus_3[1]['key'])
                                            <td>{{$orderStatus_3[1]['value']}}</td>
                                        @endif
                                        @if($order->order_status == $orderStatus_3[2]['key'])
                                            <td>{{$orderStatus_3[2]['value']}}</td>
                                        @endif
                                        @if($order->order_status == $orderStatus_3[3]['key'])
                                            <td>{{$orderStatus_3[3]['value']}}</td>
                                        @endif
                                    @endif

                                    @if(isset($order->priority))
                                        @if($order->priority == $priority[0]['key'])
                                            <td>{{$priority[0]['value']}}</td>
                                        @endif
                                        @if($order->priority == $priority[1]['key'])
                                            <td>{{$priority[1]['value']}}</td>
                                        @endif
                                        @if($order->priority == $priority[2]['key'])
                                            <td>{{$priority[2]['value']}}</td>
                                        @endif
                                    @else
                                        <td> </td>
                                    @endif

                                    @if(isset($order->delivery_date))
                                        <td>{!! date("Y-m-d", strtotime($order->delivery_date)) !!}</td>
                                    @else
                                        <td></td>
                                    @endif

                                    <td>
                                        @if(isset($order->branch->name))
                                            {!! $order->branch->name !!}
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($order->products()->first()->image))
                                            {{ Form::image(url('assets/images/usersImages/product/'.$order->products[0]->image), 'op_old_image', array("class"=>"op_old_image", "style" => "  width: 50px; height: 50px; margin-left:20px; border: 1px solid black;")) }}
                                        @else
                                            {{ Form::image(url('assets/images/staticImage/productDefaultImage.png'), 'op_old_image', array("class"=>"op_old_image", "style" => "  width: 50px; height: 50px; margin-left:20px; border: 1px solid black;")) }}
                                        @endif

                                    </td>
                                    <td>
                                        @if(isset($order->image))
                                            {{ Form::image(url('assets/images/usersImages/product/'.$order->image), 'op_old_image', array("class"=>"op_old_image", "style" => "  width: 50px; height: 50px; margin-left:20px; border: 1px solid black;")) }}

                                        @endif

                                    </td>
                                    <td>
                                        @if( $order->id)

                                            <a href="{!! URL::route('v1.employee_admin.order.edit', ['id' => $order->id]) !!}"><i class="fa fa-pencil-square-o fa-2x"></i></a>{!! Form::model($order, [ 'url' => URL::route('v1.employee_admin.order.destroy', ['id' => $order->id])] )  !!}

                                            {{ Form::open([ 'url' => URL::route('v1.employee_admin.order.destroy',['id' => $order->id]),'class'=>'OrderDelete']) }}
                                            {{ Form::hidden('_method', 'DELETE') }}
                                            {!! Form::submit('Delete', array("class"=>"btn btn-info pull-right",
                                            "style"=>"margin-left:35px;margin-top:-30px;")) !!}
                                            {!! Form::close() !!}

                                        @else
                                            <i class="fa fa-times fa-2x light-blue"></i>
                                            <i class="fa fa-times fa-2x margin-left-12 light-blue"></i>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                @elseif(count($ordersData1) > 0)
                    <div style="text-align: center">
                        @if($ordersData1->render())
                            {{$ordersData1->render()}}
                        @endif
                    </div>
                    <table class="table table-bordered table-inverse" style="font-size: 12px">
                        <thead style="background-color: #d9edf7; font-size: 12px">
                        <tr>
                            <th>Order#</th>
                            <th>Product id</th>
                            <th>Cust Name</th>
                            <th>ProductName</th>
                            <th>Weight</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Advance Price</th>
                            <th>Order Status</th>
                            <th>Priority</th>
                            <th>Created Date</th>
                            <th>Branch ID</th>
                            <th>Default Image</th>
                            <th>New Created</th>
                            <th>Operations</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ordersData1 as $order)
                            @if(isset($order->active) && $order->active == 0)
                                <tr style="background-color: rgba(205, 205, 205, 0.58)">
                                    <td style="text-align: center">{!! $order->id!!}</td>
                                    @if(isset($order->products()->first()->id))
                                        <td style="text-align: center">{!! $order->products()->first()->id !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->cust_name))
                                        <td>{!! $order->cust_name!!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->products()->first()->name))
                                        <td>{!! $order->products()->first()->name!!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->weight))
                                        <td style="text-align: center">{!! $order->weight !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->quantity))
                                        <td style="text-align: center">{!! $order->quantity !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->price))
                                        <td style="text-align: center">{!! $order->price !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->advance_price))
                                        <td style="text-align: center">{!! $order->advance_price !!}</td>
                                    @else
                                        <td></td>
                                    @endif

                                    @if(isset($order->order_status))
                                        @if($order->order_status == $orderStatus_3[0]['key'])
                                            <td>{{$orderStatus_3[0]['value']}}</td>
                                        @endif
                                        @if($order->order_status == $orderStatus_3[1]['key'])
                                            <td>{{$orderStatus_3[1]['value']}}</td>
                                        @endif
                                        @if($order->order_status == $orderStatus_3[2]['key'])
                                            <td>{{$orderStatus_3[2]['value']}}</td>
                                        @endif
                                        @if($order->order_status == $orderStatus_3[3]['key'])
                                            <td>{{$orderStatus_3[3]['value']}}</td>
                                        @endif
                                    @endif

                                    @if(isset($order->priority))
                                        @if($order->priority == $priority[0]['key'])
                                            <td>{{$priority[0]['value']}}</td>
                                        @endif
                                        @if($order->priority == $priority[1]['key'])
                                            <td>{{$priority[1]['value']}}</td>
                                        @endif
                                        @if($order->priority == $priority[2]['key'])
                                            <td>{{$priority[2]['value']}}</td>
                                        @endif
                                    @else
                                        <td> </td>
                                    @endif

                                    @if(isset($order->delivery_date))
                                        <td>{!! date("Y-m-d", strtotime($order->delivery_date)) !!}</td>
                                    @else
                                        <td></td>
                                    @endif

                                    <td>
                                        @if(isset($order->branch->name))
                                            {!! $order->branch->name !!}
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($order->products()->first()->image))
                                            {{ Form::image(url('assets/images/usersImages/product/'.$order->products[0]->image), 'op_old_image', array("class"=>"op_old_image", "style" => "  width: 50px; height: 50px; margin-left:20px; border: 1px solid black;")) }}
                                        @else
                                            {{ Form::image(url('assets/images/staticImage/productDefaultImage.png'), 'op_old_image', array("class"=>"op_old_image", "style" => "  width: 50px; height: 50px; margin-left:20px; border: 1px solid black;")) }}
                                        @endif

                                    </td>
                                    <td>
                                        @if(isset($order->image))
                                            {{ Form::image(url('assets/images/usersImages/product/'.$order->image), 'op_old_image', array("class"=>"op_old_image", "style" => "  width: 50px; height: 50px; margin-left:20px; border: 1px solid black;")) }}

                                        @endif

                                    </td>
                                    <td>
                                        @if( $order->id)

                                            <a href="{!! URL::route('v1.employee_admin.order.edit', ['id' => $order->id]) !!}"><i class="fa fa-pencil-square-o fa-2x"></i></a>{!! Form::model($order, [ 'url' => URL::route('v1.employee_admin.order.destroy', ['id' => $order->id])] )  !!}

                                            {{ Form::open([ 'url' => URL::route('v1.employee_admin.order.destroy',['id' => $order->id]),'class'=>'OrderDelete']) }}
                                            {{ Form::hidden('_method', 'DELETE') }}
                                            {!! Form::submit('Delete', array("class"=>"btn btn-info pull-right",
                                            "style"=>"margin-left:35px;margin-top:-30px;")) !!}
                                            {!! Form::close() !!}

                                        @else
                                            <i class="fa fa-times fa-2x light-blue"></i>
                                            <i class="fa fa-times fa-2x margin-left-12 light-blue"></i>
                                        @endif
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td style="text-align: center">{!! $order->id!!}</td>
                                    @if(isset($order->products()->first()->id))
                                        <td style="text-align: center">{!! $order->products()->first()->id !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->cust_name))
                                        <td>{!! $order->cust_name!!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->products()->first()->name))
                                        <td>{!! $order->products()->first()->name!!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->weight))
                                        <td style="text-align: center">{!! $order->weight !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->quantity))
                                        <td style="text-align: center">{!! $order->quantity !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->price))
                                        <td style="text-align: center">{!! $order->price !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->advance_price))
                                        <td style="text-align: center">{!! $order->advance_price !!}</td>
                                    @else
                                        <td></td>
                                    @endif

                                    @if(isset($order->order_status))
                                        @if($order->order_status == $orderStatus_3[0]['key'])
                                            <td>{{$orderStatus_3[0]['value']}}</td>
                                        @endif
                                        @if($order->order_status == $orderStatus_3[1]['key'])
                                            <td>{{$orderStatus_3[1]['value']}}</td>
                                        @endif
                                        @if($order->order_status == $orderStatus_3[2]['key'])
                                            <td>{{$orderStatus_3[2]['value']}}</td>
                                        @endif
                                        @if($order->order_status == $orderStatus_3[3]['key'])
                                            <td>{{$orderStatus_3[3]['value']}}</td>
                                        @endif
                                    @endif

                                    @if(isset($order->priority))
                                        @if($order->priority == $priority[0]['key'])
                                            <td>{{$priority[0]['value']}}</td>
                                        @endif
                                        @if($order->priority == $priority[1]['key'])
                                            <td>{{$priority[1]['value']}}</td>
                                        @endif
                                        @if($order->priority == $priority[2]['key'])
                                            <td>{{$priority[2]['value']}}</td>
                                        @endif
                                    @else
                                        <td> </td>
                                    @endif

                                    @if(isset($order->delivery_date))
                                        <td>{!! date("Y-m-d", strtotime($order->delivery_date)) !!}</td>
                                    @else
                                        <td></td>
                                    @endif

                                    <td>
                                        @if(isset($order->branch->name))
                                            {!! $order->branch->name !!}
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($order->products()->first()->image))
                                            {{ Form::image(url('assets/images/usersImages/product/'.$order->products[0]->image), 'op_old_image', array("class"=>"op_old_image", "style" => "  width: 50px; height: 50px; margin-left:20px; border: 1px solid black;")) }}
                                        @else
                                            {{ Form::image(url('assets/images/staticImage/productDefaultImage.png'), 'op_old_image', array("class"=>"op_old_image", "style" => "  width: 50px; height: 50px; margin-left:20px; border: 1px solid black;")) }}
                                        @endif

                                    </td>
                                    <td>
                                        @if(isset($order->image))
                                            {{ Form::image(url('assets/images/usersImages/product/'.$order->image), 'op_old_image', array("class"=>"op_old_image", "style" => "  width: 50px; height: 50px; margin-left:20px; border: 1px solid black;")) }}

                                        @endif

                                    </td>
                                    <td>
                                        @if( $order->id)

                                            <a href="{!! URL::route('v1.employee_admin.order.edit', ['id' => $order->id]) !!}"><i class="fa fa-pencil-square-o fa-2x"></i></a>

                                            {{ Form::open([ 'url' => URL::route('v1.employee_admin.order.destroy',['id' => $order->id]),'class'=>'OrderDelete']) }}
                                            {{ Form::hidden('_method', 'DELETE') }}
                                            {!! Form::submit('Delete', array("class"=>"btn btn-info pull-right",
                                            "style"=>"margin-left:35px;margin-top:-30px;")) !!}
                                            {!! Form::close() !!}

                                        @else
                                            <i class="fa fa-times fa-2x light-blue"></i>
                                            <i class="fa fa-times fa-2x margin-left-12 light-blue"></i>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                    <div style="text-align: center">
                        @if($ordersData1->render())
                            {{$ordersData1->render()}}
                        @endif
                    </div>
                @else
                    <span class="text-warning"><h5>No results found.</h5></span>
                @endif

        </div>
    </div>
</div>

@section('footer_scripts')

<style>
    .table > tbody > tr:nth-child(2n+1) > td, .table > tbody > tr:nth-child(2n+1) > th {
        background-color: #f9f9f9;
    }
    table, tr, td {
        font-size: 13px;
    }

    .pagination{margin: 0;}
</style>

@stop
