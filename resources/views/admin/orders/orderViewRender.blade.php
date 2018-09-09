
<div class="panel panel-info renderOrderData">
    <div class="panel-heading">
        {{--<h3 class="panel-title bariol-thin"><i class="fa fa-user"></i> {!! $request->all() ? 'Search results:' : 'Users' !!}</h3>--}}
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <div style="text-align: center">
                    @if(isset($ordersData))
                        {{$ordersData->render()}}
                    @endif
                </div>
                @if(!$ordersData->isEmpty())
                    <table class="table table-bordered table-inverse" style="font-size: 12px">
                        <thead>
                        <tr>
                            <th>Order NO</th>
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
                            <th>Default</th>
                            <th>New Created</th>
                            <th>Operations</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ordersData as $order)
                            @if(isset($order->active) && $order->active == 0)
                                <tr style="background-color: rgba(205, 205, 205, 0.58)">
                                    @if(isset($order->id))
                                        <td>{!! $order->id !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->cust_name))
                                        <td>{!! $order->cust_name !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->products()->first()->name))
                                        <td>{!! $order->products()->first()->name !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->weight))
                                        <td>{!! $order->weight !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->quantity))
                                        <td>{!! $order->quantity !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->price))
                                        <td>{!! $order->price !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->advance_price))
                                        <td>{!! $order->advance_price !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->order_status) && isset($orderStatus_3))
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

                                    @if(isset($order->priority) && isset($priority))

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

                                    @if(isset($order->branch->name))
                                        <td>{!! $order->branch->name !!}</td>
                                    @else
                                        <td></td>
                                    @endif

                                    @if(isset($order->products()->first()->image))
                                        <td>
                                            {{ Form::image(url('assets/images/usersImages/product/'.$order->products[0]->image), 'op_old_image', array("class"=>"op_old_image", "style" => "  width: 50px; height: 50px; margin-left:20px; border: 1px solid black;")) }}
                                        </td>
                                    @else
                                        <td>
                                            {{ Form::image(url('assets/images/staticImage/productDefaultImage.png'), 'op_old_image', array("class"=>"op_old_image", "style" => "  width: 50px; height: 50px; margin-left:20px; border: 1px solid black;")) }}
                                        </td>
                                    @endif
                                    @if(isset($order->image))
                                        <td>
                                            {{ Form::image(url('assets/images/usersImages/product/'.$order->image), 'op_old_image', array("class"=>"op_old_image", "style" => "  width: 50px; height: 50px; margin-left:20px; border: 1px solid black;")) }}
                                        </td>
                                    @else
                                        <td></td>
                                    @endif
                                    <td>
                                        @if( $order->id)

                                            <a href="{!! URL::route('order.edit', ['id' => $order->id]) !!}"><i class="fa fa-pencil-square-o fa-2x"></i></a>

                                            {{ Form::open([ 'url' => URL::route('order.destroy',['id' => $order->id]),'class'=>'OrderDelete']) }}
                                            {{ Form::hidden('_method', 'DELETE') }}
                                            {!! Form::submit('Delete', array("class"=>"btn btn-info pull-right delete1",
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
                                    @if(isset($order->id))
                                        <td>{!! $order->id !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->cust_name))
                                        <td>{!! $order->cust_name !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->products()->first()->name))
                                        <td>{!! $order->products()->first()->name !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->weight))
                                        <td>{!! $order->weight !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->quantity))
                                        <td>{!! $order->quantity !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->price))
                                        <td>{!! $order->price !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->advance_price))
                                        <td>{!! $order->advance_price !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($order->order_status) && isset($orderStatus_3))

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

                                    @if(isset($order->priority) && isset($priority))

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

                                    @if(isset($order->branch->name))
                                        <td>{!! $order->branch->name !!}</td>
                                    @else
                                        <td></td>
                                    @endif

                                    @if(isset($order->products()->first()->image))
                                        <td>
                                            {{ Form::image(url('assets/images/usersImages/product/'.$order->products[0]->image), 'op_old_image', array("class"=>"op_old_image", "style" => "  width: 50px; height: 50px; margin-left:20px; border: 1px solid black;")) }}
                                        </td>
                                    @else
                                        <td>
                                            {{ Form::image(url('assets/images/staticImage/productDefaultImage.png'), 'op_old_image', array("class"=>"op_old_image", "style" => "  width: 50px; height: 50px; margin-left:20px; border: 1px solid black;")) }}
                                        </td>
                                    @endif
                                    @if(isset($order->image))
                                        <td>
                                            {{ Form::image(url('assets/images/usersImages/product/'.$order->image), 'op_old_image', array("class"=>"op_old_image", "style" => "  width: 50px; height: 50px; margin-left:20px; border: 1px solid black;")) }}
                                        </td>
                                    @else
                                        <td></td>
                                    @endif
                                    <td>
                                        @if( $order->id)

                                            <a href="{!! URL::route('order.edit', ['id' => $order->id]) !!}"><i class="fa fa-pencil-square-o fa-2x"></i></a>

                                            {{ Form::open([ 'url' => URL::route('order.destroy',['id' => $order->id]),'class'=>'OrderDelete']) }}
                                            {{ Form::hidden('_method', 'DELETE') }}
                                            {!! Form::submit('Delete', array("class"=>"btn btn-info pull-right delete1",
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
                @else
                    <span class="text-warning"><h5>No results found.</h5></span>
                @endif
            </div>
            <div style="text-align: center">
                @if(isset($ordersData))
                    {{$ordersData->render()}}
                @endif
            </div>

        </div>
    </div>
</div>
