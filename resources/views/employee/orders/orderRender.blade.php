
<div class="panel panel-info render-order-block">
    <div class="panel-heading">
        <h3 class="panel-title bariol-thin"></h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <div style="text-align: center; margin-bottom: -13px; margin-top: -20px;">
                    @if(isset($ordersData))
                        {{$ordersData->render()}}
                    @endif
                </div>
                @if(isset($ordersData) )
                    <table class="table table-bordered table-inverse" style="font-size: 12px">
                        <thead>
                        <tr>
                            <th>Order No</th>
                            <th>Product Name</th>
                            <th>Weight</th>
                            <th>Quantity</th>
                            <th>Delivery Date</th>
                            <th>Delivery Time</th>
                            <th>Priority</th>
                            <th>Order Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ordersData as $order)
                            @if(isset($order->priority) && isset($order->order_status))
                                @if($order->priority == 0 && $order->priority == 1 || $order->order_status == 0)
                                    <tr id="process_block" style="background-color: #dbf0f7; color: #5a5a5a; box-shadow: none; border:#bebebe 1px solid">

                                        @if(isset($order->id))
                                            <td>
                                                {{--<a href="{!! URL::route('v1.employee.order.show', ['id' => $order->id]) !!}" style="text-align: center; color: #be1238">--}}
                                                {!! $order->id !!}
                                                {{--</a>--}}
                                            </td>
                                        @else
                                            <td style="text-align: center">{!! $order->id !!}</td>
                                        @endif

                                        @if(isset($order->products->first()->name))
                                            <td>{!! $order->products->first()->name !!}</td>
                                        @else
                                            <td> </td>
                                        @endif

                                        @if(isset($order->weight))
                                            <td style="text-align: center">{!! $order->weight !!}</td>
                                        @else
                                            <td> </td>
                                        @endif

                                        @if(isset($order->quantity))
                                            <td style="text-align: center">{!! $order->quantity !!}</td>
                                        @else
                                            <td> </td>
                                        @endif

                                        @if(isset($order->delivery_date))
                                            <td>
                                                {!! $order->delivery_date->format('Y-m-d')!!}
                                            </td>
                                        @else
                                            <td> </td>
                                        @endif

                                        @if(isset($order->delivery_time))
                                            <td>{!! $order->delivery_time !!}</td>
                                        @else
                                            <td> </td>
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

                                        <td>
                                            <select class="form-control order_id" id="{{$order->id}} "onchange="changeStatus(this);"  style="border-radius: 0px">
                                                @if(isset($orderStatus))
                                                    @foreach ($orderStatus as $status)
                                                        @if ($status['key'] == 0)
                                                            <option selected value="{{ $status['key'] }}">{{ $status['value'] }}</option>
                                                        @else
                                                            <option value="{{ $status['key'] }}">{{ $status['value'] }}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                        </td>

                                    </tr>
                                @endif
                                {{--@if ($order === $ordersData->last() )--}}
                                {{--<tr>--}}
                                {{--<td>Unprocessed Orders</td>--}}
                                {{--</tr>--}}
                                {{--@endif--}}
                                @if($order->order_status == 1)
                                    <tr id="unprocess_block" style="background-color: #cceeee; color: #5a5a5a;">

                                        @if(isset($order->id))
                                            <td>
                                                {{--<a href="{!! URL::route('v1.employee.order.show', ['id' => $order->id]) !!}" style="text-align: center; color: #be1238">--}}
                                                {!! $order->id !!}
                                                {{--</a>--}}
                                            </td>
                                        @else
                                            <td style="text-align: center">{!! $order->id !!}</td>
                                        @endif

                                        @if(isset($order->products->first()->name))
                                            <td>{!! $order->products->first()->name !!}</td>
                                        @else
                                            <td> </td>
                                        @endif

                                        @if(isset($order->weight))
                                            <td style="text-align: center">{!! $order->weight !!}</td>
                                        @else
                                            <td> </td>
                                        @endif

                                        @if(isset($order->quantity))
                                            <td style="text-align: center">{!! $order->quantity !!}</td>
                                        @else
                                            <td> </td>
                                        @endif

                                        @if(isset($order->delivery_date))
                                            <td>
                                                {!! $order->delivery_date->format('Y-m-d')!!}
                                            </td>
                                        @else
                                            <td> </td>
                                        @endif

                                        @if(isset($order->delivery_time))
                                            <td>{!! $order->delivery_time !!}</td>
                                        @else
                                            <td> </td>
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

                                        <td>
                                            <select class="form-control order_id" id="{{$order->id}} "onchange="changeStatus(this);"  style="border-radius: 0px">
                                                @if(isset($orderStatus))
                                                    @foreach ($orderStatus as $status)
                                                        @if ($status['key'] == 1)
                                                            <option selected value="{{ $status['key'] }}">{{ $status['value'] }}</option>
                                                        @else
                                                            <option value="{{ $status['key'] }}">{{ $status['value'] }}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                        </td>
                                    </tr>
                                @endif
                                @if(($order->priority == 2 && $order->order_status == 2) || ($order->order_status == 2))
                                    <tr id="padding_block" style="background-color: #fdebd1; color: #5a5a5a;">

                                        @if(isset($order->id))
                                            <td>
                                                {{--<a href="{!! URL::route('v1.employee.order.show', ['id' => $order->id]) !!}" style="text-align: center; color: #be1238">--}}
                                                {!! $order->id !!}
                                                {{--</a>--}}
                                            </td>
                                        @else
                                            <td style="text-align: center">{!! $order->id !!}</td>
                                        @endif

                                        @if(isset($order->products->first()->name))
                                            <td>{!! $order->products->first()->name !!}</td>
                                        @else
                                            <td> </td>
                                        @endif

                                        @if(isset($order->weight))
                                            <td style="text-align: center">{!! $order->weight !!}</td>
                                        @else
                                            <td> </td>
                                        @endif

                                        @if(isset($order->quantity))
                                            <td style="text-align: center">{!! $order->quantity !!}</td>
                                        @else
                                            <td> </td>
                                        @endif

                                        @if(isset($order->delivery_date))
                                            <td>
                                                {!! $order->delivery_date->format('Y-m-d')!!}
                                            </td>
                                        @else
                                            <td> </td>
                                        @endif

                                        @if(isset($order->delivery_time))
                                            <td>{!! $order->delivery_time !!}</td>
                                        @else
                                            <td> </td>
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

                                        <td>
                                            <select class="form-control order_id" id="{{$order->id}} "onchange="changeStatus(this);"  style="border-radius: 0px">
                                                @if(isset($orderStatus))
                                                    @foreach ($orderStatus as $status)
                                                        @if ($status['key'] == 2)
                                                            <option selected value="{{ $status['key'] }}">{{ $status['value'] }}</option>
                                                        @else
                                                            <option value="{{ $status['key'] }}">{{ $status['value'] }}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                        </td>
                                    </tr>
                                @endif
                                @if($order->order_status == 3)
                                    <tr id="cancel_block" style="background-color: #ffdedd; color: #333;">

                                        @if(isset($order->id))
                                            <td>
                                                {{--<a href="{!! URL::route('v1.employee.order.show', ['id' => $order->id]) !!}" style="text-align: center; color: #be1238">--}}
                                                {!! $order->id !!}
                                                {{--</a>--}}
                                            </td>
                                        @else
                                            <td style="text-align: center">{!! $order->id !!}</td>
                                        @endif

                                        @if(isset($order->products->first()->name))
                                            <td>{!! $order->products->first()->name !!}</td>
                                        @else
                                            <td> </td>
                                        @endif

                                        @if(isset($order->weight))
                                            <td style="text-align: center">{!! $order->weight !!}</td>
                                        @else
                                            <td> </td>
                                        @endif

                                        @if(isset($order->quantity))
                                            <td style="text-align: center">{!! $order->quantity !!}</td>
                                        @else
                                            <td> </td>
                                        @endif

                                        @if(isset($order->delivery_date))
                                            <td>
                                                {!! $order->delivery_date->format('Y-m-d')!!}
                                            </td>
                                        @else
                                            <td> </td>
                                        @endif

                                        @if(isset($order->delivery_time))
                                            <td>{!! $order->delivery_time !!}</td>
                                        @else
                                            <td> </td>
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

                                        <td>
                                            <select class="form-control order_id" id="{{$order->id}} "onchange="changeStatus(this);"  style="border-radius: 0px">
                                                @if(isset($orderStatus))
                                                    @foreach ($orderStatus as $status)
                                                        @if ($status['key'] == 3)
                                                            <option selected value="{{ $status['key'] }}">{{ $status['value'] }}</option>
                                                        @else
                                                            <option value="{{ $status['key'] }}">{{ $status['value'] }}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                        </td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <span class="text-warning"><h5>No orders.</h5></span>
                @endif
                <div style="text-align: center; margin-bottom: -26px; margin-top: -26px;">
                    @if(isset($ordersData))
                        {{$ordersData->render()}}
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>