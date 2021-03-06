{{--@if(empty($data))--}}
    <div class="container-fluid" id="printDiv">
        <div class="row" ng-if="printDivFlag">
            <header class="header" style="margin-bottom: 30px">
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <div class="col-xs-6 col-md-8">
                            <h2 style="text-align: center; float: right;">Invoice</h2>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <img src="{{ env('APP_URL').'assets/images/staticImage/logo1.png' }}" alt="" style="float: right; margin-right: 40px; width: 100px; height: 100px">
                        </div>
                    </div>
                </div>
            </header>
            <!-- First Featurette -->

            <div class="row"  style="margin-bottom: 30px">
                {{--<div class="col-xs-12 col-md-12">--}}

                    <div class="col-xs-6 col-sm-4">
{{--                        @foreach($order as $order)--}}
                            @if($order->products[0]->image)
                                <img  src="{{ env('APP_URL').'assets/images/usersImages/product/'.$order->products[0]->image }}" class="featurette-image  img-responsive text-center" style="text-align: center; margin-left: 40px; width: 300px; height: 300px; border-radius: 0; border: 3px solid slategray;">
                            @else
                                <p class="featurette-image text-center" style="text-align: center; margin-left: 40px; padding-top:80px; width: 300px; height: 300px; border-radius: 0; border: 3px solid slategray;">Product image not exist</p>

                            @endif
                        {{--@endforeach--}}
                    </div>
                    <div class="col-xs-6 col-sm-4">

                        @if(isset($order->cust_name) && !empty($order->cust_name))
                            <p><b>Name: </b>{{$order->cust_name}}</p><br>
                        @endif
                        @if(isset($order->cust_phone) && !empty($order->cust_phone))
                            <p><b>Phone no: </b>{{$order->cust_phone}}</p><br>
                        @endif
                        @if(isset($order->id))
                            <p><b>Order No: </b>{{$order->id}}</p><br>
                        @endif
                        @if(isset($order->token_code) && !empty($order->token_code))
                            <p><b>Token Code: </b>{{$order->token_code}}</p><br>
                        @endif

                    </div>
                    <div class="col-xs-6 col-sm-4">

                        <p><b>Branch Name: </b>Blue Area</p><br>
                        @if(isset($order->created_at) && !empty($order->created_at))
                            <p><b>Order Date : </b>{{$order->created_at}}</p><br>
                        @endif
                        @if(isset($order->delivery_date) && !empty($order->delivery_date))
                            <p><b>Delivery Date : </b>{{$order->delivery_date}}</p><br>
                        @endif
                        @if(isset($order->delivery_time) && !empty($order->delivery_time))
                            <p><b>Delivery Time: </b>{{$order->delivery_time}}</p><br>
                        @endif

                    </div>
                {{--</div>--}}
            </div>

            <div class="col-xs-12 col-md-12">
                <h2>Your order</h2>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        @if(isset($product->name))
                            <th>Product name</th>
                        @endif
                        @if(isset($flavor1))
                            <th>Flavors</th>
                        @endif
                        @if(isset($order->weight))
                            <th>Weight</th>
                        @endif
                        @if(isset($order->quantity))
                            <th>Quantity</th>
                        @endif
                        @if(isset($order->price))
                            <th>Price(Rs)</th>
                        @endif
                        @if(isset($order->advance_price))
                            <th>Advance(Rs)</th>
                        @endif

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        @if(isset($product->name))
                            <td>{{$product->name}}</td>
                        @endif
                        @if(isset($flavor1))
                            @if(isset($flavor2))
                                <td>{{$flavor1->first()->name}} & {{$flavor2->first()->name}}</td>
                            @else
                                <td>{{$flavor1->first()->name}}</td>
                            @endif
                        @elseif(isset($flavor2))
                            @if(isset($flavor1))
                                <td>{{$flavor1->first()->name}} & {{$flavor2->first()->name}}</td>
                            @else
                                <td>{{$flavor2->first()->name}}</td>
                            @endif
                        @endif
                        @if(isset($order->weight))
                            <td>{{$order->weight}}</td>
                        @endif
                        @if(isset($order->quantity))
                            <td>{{$order->quantity}}</td>
                        @endif
                        @if(isset($order->price))
                            <td>{{$order->price + $order->advance_price}}</td>
                        @endif
                        @if(isset($order->advance_price))
                            <td>{{$order->advance_price}}</td>
                        @endif

                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="row" style="margin-bottom: 30px">
                <div class="col-xs-12">
                    <div style="float: right;">
                        <h3>Balance(Rs):  {{$order->price}}</h3><br>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-bottom: 30px">
                <div class="col-xs-12">
                    <div class="col-xs-6">
                        <div style="float: left;">
                            <hr style="border: 1px solid black;clear:both;display:block;width: 200px;background-color:#000000;height: 1px;">
                            <h3 style="text-align: center">Salesman </h3>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div style="float: right;">
                            <hr style="border: 1px solid black;clear:both;display:block;width: 200px;background-color:#000000;height: 1px;">
                            <h3 style="text-align: center">Cashiar </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br>
    <div class="container-fluid" id="printDiv">
        <div class="row" ng-if="printDivFlag">
            <header class="header" style="margin-bottom: 30px">
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <div class="col-xs-6 col-md-8">
                            <h2 style="text-align: right">Customer Invoice</h2>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <img src="{{ env('APP_URL').'assets/images/staticImage/logo1.png' }}" alt="" style="float: right; margin-right: 40px; width: 100px; height: 100px">
                        </div>
                    </div>
                </div>
            </header>
            <!-- First Featurette -->

            <div class="row"  style="margin-bottom: 30px">
                {{--<div class="col-xs-12 col-sm-12">--}}

                    <div class="col-xs-6 col-sm-4">
{{--                        @foreach($order as $order)--}}
                            @if($order->products[0]->image)
                                <img  src="{{ env('APP_URL').'assets/images/usersImages/product/'.$order->products[0]->image }}" class="featurette-image  img-responsive text-center" style="text-align: center; margin-left: 40px; width: 300px; height: 300px; border-radius: 0; border: 3px solid slategray;">
                            @else
                                <p class="featurette-image text-center" style="text-align: center; margin-left: 40px; padding-top:80px; width: 300px; height: 300px; border-radius: 0; border: 3px solid slategray;">Product image not exist</p>

                            @endif
                        {{--@endforeach--}}
                    </div>

                    <div class="col-xs-6 col-sm-4">

                        @if(isset($order->cust_name) && !empty($order->cust_name))
                            <p><b>Name: </b>{{$order->cust_name}}</p><br>
                        @endif
                        @if(isset($order->cust_phone) && !empty($order->cust_phone))
                            <p><b>Phone no: </b>{{$order->cust_phone}}</p><br>
                        @endif
                        @if(isset($order->id))
                            <p><b>Order No: </b>{{$order->id}}</p><br>
                        @endif
                        @if(isset($order->token_code) && !empty($order->token_code))
                            <p><b>Token Code: </b>{{$order->token_code}}</p><br>
                        @endif

                    </div>
                    <div class="col-xs-6 col-sm-4">

                        <p><b>Branch Name: </b>Blue Area</p><br>
                        @if(isset($order->created_at) && !empty($order->created_at))
                            <p><b>Order Date : </b>{{$order->created_at}}</p><br>
                        @endif
                        @if(isset($order->delivery_date) && !empty($order->delivery_date))
                            <p><b>Delivery Date : </b>{{$order->delivery_date}}</p><br>
                        @endif
                        @if(isset($order->delivery_time) && !empty($order->delivery_time))
                            <p><b>Delivery Time: </b>{{$order->delivery_time}}</p><br>
                        @endif

                    </div>
                {{--</div>--}}
            </div>

            <div class="col-xs-12 col-md-12">
                <h2>Your order</h2>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        @if(isset($product->name))
                            <th>Product name</th>
                        @endif
                        @if(isset($flavor1))
                            <th>Flavors</th>
                        @endif
                        @if(isset($order->weight))
                            <th>Weight</th>
                        @endif
                        @if(isset($order->quantity))
                            <th>Quantity</th>
                        @endif
                        @if(isset($order->price))
                            <th>Price(Rs)</th>
                        @endif
                        @if(isset($order->advance_price))
                            <th>Advance(Rs)</th>
                        @endif

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        @if(isset($product->name))
                            <td>{{$product->name}}</td>
                        @endif
                        @if(isset($flavor1))
                            @if(isset($flavor2))
                                <td>{{$flavor1->first()->name}} & {{$flavor2->first()->name}}</td>
                            @else
                                <td>{{$flavor1->first()->name}}</td>
                            @endif
                        @elseif(isset($flavor2))
                            @if(isset($flavor1))
                                <td>{{$flavor1->first()->name}} & {{$flavor2->first()->name}}</td>
                            @else
                                <td>{{$flavor2->first()->name}}</td>
                            @endif
                        @endif
                        @if(isset($order->weight))
                            <td>{{$order->weight}}</td>
                        @endif
                        @if(isset($order->quantity))
                            <td>{{$order->quantity}}</td>
                        @endif
                        @if(isset($order->price))
                            <td>{{$order->price + $order->advance_price}}</td>
                        @endif
                        @if(isset($order->advance_price))
                            <td>{{$order->advance_price}}</td>
                        @endif

                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="row" style="margin-bottom: 30px">
                <div class="col-xs-12">
                    <div style="float: right;">
                        <h3>Balance(Rs):  {{$order->price}}</h3><br>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-bottom: 30px">
                <div class="col-xs-12">
                    <div class="col-xs-6">
                        <div style="float: left;">
                            <hr style="border: 1px solid black;clear:both;display:block;width: 200px;background-color:#000000;height: 1px;">
                            <h3 style="text-align: center">Salesman </h3>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div style="float: right;">
                            <hr style="border: 1px solid black;clear:both;display:block;width: 200px;background-color:#000000;height: 1px;">
                            <h3 style="text-align: center">Cashiar </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{--@endif--}}


