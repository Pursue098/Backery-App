
<div class="panel panel-info render-order-block">
    <div class="panel-heading">
        <h3 class="panel-title bariol-thin"></h3>
    </div>
    <div class="panel-body">
      <div class="row">
          <div class="col-md-12">

              @if(count($orderSearchData) > 0)
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
                          <th>Branch</th>
                          <th>Order Status</th>
                      </tr>
                      </thead>
                      <tbody>
                      @foreach($orderSearchData as $order)
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

                                      @if(isset($order->branch))
                                          <td>{!! $order->branch->name !!}</td>
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

                                      @if(isset($order->branch))
                                          <td>{!! $order->branch->name !!}</td>
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
                                  <tr id="Pendding_block" style="background-color: #fdebd1; color: #5a5a5a;">

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

                                      @if(isset($order->branch))
                                          <td>{!! $order->branch->name !!}</td>
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

                                      @if(isset($order->branch))
                                          <td>{!! $order->branch->name !!}</td>
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
              @elseif(count($ordersData) > 0)
                  <div style="text-align: center">
                      @if($ordersData->render())
                          {{$ordersData->render()}}
                      @endif
                  </div>
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
                          <th>Branch</th>
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

                                      @if(isset($order->branch))
                                          <td>{!! $order->branch->name !!}</td>
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

                                      @if(isset($order->branch))
                                          <td>{!! $order->branch->name !!}</td>
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
                                  <tr id="Pendding_block" style="background-color: #fdebd1; color: #5a5a5a;">

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

                                      @if(isset($order->branch))
                                          <td>{!! $order->branch->name !!}</td>
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

                                      @if(isset($order->branch))
                                          <td>{!! $order->branch->name !!}</td>
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
                  <div style="text-align: center">
                      @if($ordersData->render())
                          {{$ordersData->render()}}
                      @endif
                  </div>
              @else
                  <span class="text-warning"><h5>No results found.</h5></span>
              @endif
          </div>
      </div>
    </div>
</div>

@section('footer_scripts')
    <script>
//        $.ajaxSetup({
//            headers: {
//                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//            }
//        });
//        function changeStatus(value) {
//
//            function getParameterByName(name, url) {
//                if (!url) {
//                    url = window.location.href;
//                }
//                name = name.replace(/[\[\]]/g, "\\$&");
//                var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
//                        results = regex.exec(url);
//                if (!results) return null;
//                if (!results[2]) return '';
//                return decodeURIComponent(results[2].replace(/\+/g, " "));
//            }
//
//            var page = getParameterByName('page');
//
//            var order_id = value.id;
//            var status = $('.order_id').val();
//
//            var data = {'order_id':order_id, 'status':value.value };
//
//            console.log('page: ', page); return;
//
//            if(page) {
//
//                $.ajax({
//                    type: "GET",
//                    url: 'change_order_status',
//                    headers: {
//                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                    },
//                    data:data,
//                    success: function(data) {
//
//                        console.log(data)
//
//                        $( ".render-order-block" ).html(data);
//
//                    },
//                    error: function(data) {
//                        console.log(data);
//                    }
//                },"json");
//
//                return;
//
//            }else {
//
//                $.ajax({
//                    type: "GET",
//                    url: 'change_order_status',
//                    headers: {
//                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                    },
//                    data:data,
//                    success: function(data) {
//
//                        console.log(data)
//
//                        $( ".render-order-block" ).html(data);
//
//                    },
//                    error: function(data) {
//                        console.log(data);
//                    }
//                },"json");
//
//                return;
//            }
//
//
//        }

    </script>
@stop