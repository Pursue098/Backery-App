@extends('laravel-authentication-acl::admin.layouts.base-1cols')

@section('title')
EmployeeAdmin area: edit Order
@stop

@section('content')

<div class="row">
    <div class="col-md-12">
        {{-- successful message --}}
        <?php $message = Session::get('message'); ?>
        @if( isset($message) )
        <div class="alert alert-success">{!! $message !!}</div>
        @endif
        @if($errors->has('model') )
            <div class="alert alert-danger">{!! $errors->first('model') !!}</div>
        @endif
        <h3 style="text-align: center">Replace Product Image</h3>
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="panel-title bariol-thin"><i class="fa fa-pencil"></i>Edit Order</h3>
                    </div>
                </div>
            </div>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <br>
            <div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))

                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                    @endif
                @endforeach
            </div> <!-- end .flash-message -->

            @if(isset($order))
                <div class="panel-body">
                    @if(isset($order->id))
                        <div class="col-md-6 col-xs-6">

                            <h4>Update This Record</h4>
                            {!! Form::model($order, [ 'url' => URL::route('v1.employee_admin.order.update', ['id' => $order->id])] )  !!}
                            {{ Form::hidden('_method', 'PUT') }}

                            <!-- Custumer name text field -->
                            <div class="form-group col-md-6 col-xs-6">
                                {!! Form::label('Product name','Product name: *') !!}
                                @if(!empty($product) && isset($product))
                                    {!! Form::select('product_id', $product, null, ['class' => 'form-control product_id']) !!}
                                @else
                                    {!! Form::text('product_id', null, ['class' => 'form-control product_id', 'placeholder' => 'Product name', 'autocomplete' => 'off']) !!}
                                @endif
                            </div>
                            <span class="text-danger">{!! $errors->first('product_id') !!}</span>

                            <!-- Custumer name text field -->
                            <div class="form-group col-md-6 col-xs-6">
                                {!! Form::label('Customer name','Customer name: *') !!}
                                {!! Form::text('cust_name', $order->cust_name, ['class' => 'form-control name', 'placeholder' => 'Custumer name', 'autocomplete' => 'off']) !!}
                            </div>
                            <span class="text-danger">{!! $errors->first('name') !!}</span>

                            <!-- Custumer email feild text field -->
                            <div class="form-group col-md-6 col-xs-6">
                                {!! Form::label('Customer email', "Customer email: ") !!}
                                {!! Form::text('cust_email', $order->cust_email, ['class' => 'form-control email', 'placeholder' => 'Custumer email', 'autocomplete' => 'off']) !!}
                            </div>
                            <span class="text-danger">{!! $errors->first('email') !!}</span>

                            <!-- Customer address feild text field -->
                            <div class="form-group col-md-6 col-xs-6">
                                {!! Form::label('Customer address', "Customer address: ") !!}
                                {!! Form::text('cust_address', $order->cust_address, ['class' => 'form-control address', 'placeholder' => 'Customer address', 'autocomplete' => 'off']) !!}
                            </div>
                            <span class="text-danger">{!! $errors->first('address') !!}</span>

                            <!-- Customer phone feild text field -->
                            <div class="form-group col-md-6 col-xs-6">
                                {!! Form::label('Customer phone', "Customer phone: ") !!}
                                {!! Form::text('cust_phone', $order->cust_phone, ['class' => 'form-control phone', 'placeholder' => 'Customer phone', 'autocomplete' => 'off']) !!}
                            </div>
                            <span class="text-danger">{!! $errors->first('phone') !!}</span>

                            <!-- weight feild text field -->
                            <div class="form-group col-md-6 col-xs-6">
                                {!! Form::label('Weight', "Weight: ") !!}
                                {!! Form::text('weight', $order->weight, ['class' => 'form-control weight', 'placeholder' => 'Weight', 'autocomplete' => 'off']) !!}
                            </div>
                            <span class="text-danger">{!! $errors->first('weight') !!}</span>

                            <!-- Quantity field -->
                            <div class="form-group col-md-6 col-xs-6">
                                {!! Form::label('Quantity', "Quantity: ") !!}
                                {!! Form::text('quantity', $order->quantity, ['class' => 'form-control quantity', 'placeholder' => 'Quantity', 'autocomplete' => 'off']) !!}
                            </div>
                            <span class="text-danger">{!! $errors->first('quantity') !!}</span>

                            <!-- Flavor 1 field -->
                            <div class="form-group col-md-6 col-xs-6">
                                {!! Form::label('Flavor 1', "Flavor 1: ") !!}

                                @if(!empty($flavour) && isset($flavour))
                                    {!! Form::select('flavor1_id', $flavour, null, ['class' => 'form-control']) !!}
                                @else
                                    {!! Form::text('flavor1_id', null, ['class' => 'form-control', 'placeholder' => 'Flavors', 'autocomplete' => 'off']) !!}
                                @endif
                            </div>
                            <span class="text-danger">{!! $errors->first('flavor1_id') !!}</span>

                            <!-- Flavor 2 field -->
                            <div class="form-group col-md-6 col-xs-6">
                                {!! Form::label('Flavor 2', "Flavor 2: ") !!}

                                @if(!empty($flavour) && isset($flavour))

                                    {!! Form::select('flavor2_id', $flavour, null, ['class' => 'form-control']) !!}
                                @else
                                    {!! Form::text('flavor2_id', null, ['class' => 'form-control', 'placeholder' => 'Flavors', 'autocomplete' => 'off']) !!}
                                @endif
                            </div>
                            <span class="text-danger">{!! $errors->first('flavor2_id') !!}</span>

                            <!-- price text field -->
                            <div class="form-group col-md-6 col-xs-6">
                                {!! Form::label('Price', "Price: ") !!}
                                {!! Form::text('price', $order->price, ['class' => 'form-control price', 'placeholder' => 'Price', 'autocomplete' => 'off']) !!}
                            </div>
                            <span class="text-danger">{!! $errors->first('price') !!}</span>

                            <!-- Advance price text field -->
                            <div class="form-group col-md-6 col-xs-6">
                                {!! Form::label('Advance price', "Advance price: ") !!}
                                {!! Form::text('advance_price', $order->advance_price, ['class' => 'form-control advance_price', 'placeholder' => 'Advance price', 'autocomplete' => 'off']) !!}
                            </div>
                            <span class="text-danger">{!! $errors->first('advance_price') !!}</span>

                            {{--!-- Payment type field -->--}}
                            @if(isset($paymentType))
                                <div class="form-group col-md-6 col-xs-6">
                                    {!! Form::label('Payment type', "Payment type: ") !!}
                                    {!! Form::select('payment_type', $paymentType, null, ['class' => 'form-control']) !!}
                                </div>
                                <span class="text-danger">{!! $errors->first('payment_type') !!}</span>
                            @else
                                <div class="form-group col-md-6 col-xs-6">
                                    {!! Form::label('Payment type', "Payment type: ") !!}
                                    {!! Form::select('payment_type', [0=>'Credit', 1=>'Debit'], null, ['class' => 'form-control']) !!}
                                </div>
                                <span class="text-danger">{!! $errors->first('payment_type') !!}</span>
                            @endif

                        <!-- Payment status field -->
                            @if(isset($paymentStatus))
                                <div class="form-group col-md-6 col-xs-6">
                                    {!! Form::label('Payment status', "Payment status: ") !!}
                                    {!! Form::select('payment_status', $paymentStatus, null, ['class' => 'form-control']) !!}
                                </div>
                                <span class="text-danger">{!! $errors->first('payment_status') !!}</span>
                            @else
                                <div class="form-group col-md-6 col-xs-6">
                                    {!! Form::label('Payment status', "Payment status: ") !!}
                                    {!! Form::select('payment_status', [1=>'Payed', 0=>'Not'], null, ['class' => 'form-control']) !!}
                                </div>
                                <span class="text-danger">{!! $errors->first('payment_status') !!}</span>
                            @endif

                        <!-- Order type field -->
                            @if(isset($orderType))
                                <div class="form-group col-md-6 col-xs-6">
                                    {!! Form::label('Order type', "Order type: ") !!}
                                    {!! Form::select('order_type', $orderType, null, ['class' => 'form-control']) !!}
                                </div>
                                <span class="text-danger">{!! $errors->first('order_type') !!}</span>
                            @else
                                <div class="form-group col-md-6 col-xs-6">
                                    {!! Form::label('Order type', "Order type: ") !!}
                                    {!! Form::select('order_type', [0=>'Personal', 1=>'By Call', 2=>'By Message'], null, ['class' => 'form-control']) !!}
                                </div>
                                <span class="text-danger">{!! $errors->first('order_type') !!}</span>
                            @endif



                        </div>
                        {{--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////--}}
                        <div class="col-md-6">
                            <div class="col-xs-12 col-xs-12" style="margin-bottom: 25px;">
                                <div class="col-md-6">
                                    @if(isset($order->products()->first()->image))

                                        <h3 style="text-align: center">Original Image </h3>
{{--                                        {{ Form::image(url('assets/images/usersImages/product/'.$order->products()->first()->image), 'default_image', array("class"=>"default_image", "style" => "width: 220px; height: 193px; margin-left:20px; border: 1px solid black;")) }}--}}
                                        <img src="{{url('assets/images/usersImages/product/'.$order->products()->first()->image)}}" name="default_image" class="default_image" style="width: 220px; height: 193px; margin-left:20px; border: 1px solid black;">

                                    @else
                                        <h3 style="text-align: center">Original Image </h3>
                                        {{ Form::image(url('assets/images/staticImage/productDefaultImage.png'), 'default_image', array("class"=>"default_image", "style" => "width: 220px; height: 193px; margin-left:20px; border: 1px solid black;")) }}

                                    @endif
                                </div>
                                <div class="col-md-6">
                                    @if(isset($order->image))

                                        <h3 style="text-align: center">We Made</h3>
{{--                                        {{ Form::image(url('assets/images/usersImages/order/'.$order->image), 'old_image', array("class"=>"old_image", "style" => "width: 220px; height: 193px; margin-left:20px; border: 1px solid black;")) }}--}}
                                        <img src="{{url('assets/images/usersImages/order/'.$order->image)}}" name="old_image" class="old_image" style="width: 220px; height: 193px; margin-left:20px; border: 1px solid black;">

                                    @else
                                        <div id="image-block-2" style="display: none;visibility: hidden;">

                                            <h3 style="text-align: center">We Made</h3>
{{--                                            {{ Form::image(url('assets/images/usersImages/order/'.$order->image), 'old_image', array("class"=>"old_image", "style" => "width: 220px; height: 193px; margin-left:20px; border: 1px solid black;")) }}--}}
                                            <img src="{{url('assets/images/usersImages/order/'.$order->image)}}" name="old_image" class="old_image" style="width: 220px; height: 193px; margin-left:20px; border: 1px solid black;">

                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Order status field -->
                            @if(isset($orderStatus))
                                <div class="form-group col-md-6 col-xs-6">
                                    {!! Form::label('Order status', "Order status: ") !!}
                                    {!! Form::select('order_status', $orderStatus, null, ['class' => 'form-control']) !!}
                                </div>
                                <span class="text-danger">{!! $errors->first('order_status') !!}</span>
                            @else
                                <div class="form-group col-md-6 col-xs-6">
                                    {!! Form::label('Order status', "Order status: ") !!}
                                    {!! Form::select('order_status', [0=>'Un processed', 1=>'processed', 2=>'Padding', 3=>'Canceled'], null, ['class' => 'form-control']) !!}
                                </div>
                                <span class="text-danger">{!! $errors->first('order_status') !!}</span>
                            @endif

                            <!-- Delivery date & time field -->
                            <div class="form-group col-md-6 col-xs-6">
                                {!! Form::label('Delivery time', "Delivery time: ") !!}

                                @if(!empty($order->delivery_time) && isset($order->delivery_time))
                                    <div class='input-group date timepicker' id='timepicker'>
                                        {!! Form::text('delivery_time', $order->delivery_time, ['class' => 'form-control delivery_time timepicker']) !!}
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                                                </span>
                                    </div>
                                @else
                                    <div class='input-group date timepicker' id='timepicker'>
                                        {!! Form::text('delivery_time', null, ['class' => 'form-control delivery_time timepicker']) !!}
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                                                </span>
                                    </div>
                                @endif
                            </div>
                            <span class="text-danger">{!! $errors->first('delivery_time') !!}</span>

                            <!-- Delivery date & time field -->
                            <div class="form-group col-md-6 col-xs-6">
                                {!! Form::label('Delivery date', "Delivery date: ") !!}

                                @if(!empty($order->delivery_date) && isset($order->delivery_date))
                                    <div class='input-group date datepicker' id='datepicker'>
                                        {!! Form::text('delivery_date', Carbon\Carbon::createFromFormat('Y-m-d G:i:s', $order->delivery_date)->toDateTimeString(), ['class' => 'form-control datepicker']) !!}
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                                            </span>
                                    </div>
                                @else
                                    <div class='input-group date datepicker' id='datepicker'>
                                        {!! Form::text('delivery_date', null, ['class' => 'form-control datepicker']) !!}
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                                            </span>
                                    </div>
                                @endif
                            </div>
                            <span class="text-danger">{!! $errors->first('delivery_date') !!}</span>


                            <!-- Remarks text field -->
                            <div class="form-group col-md-6 col-xs-6">
                                {!! Form::label('Remarks', "Remarks: ") !!}
                                {!! Form::textarea('remarks', $order->remarks, ['class' => 'form-control', 'placeholder' => 'Remarks', 'autocomplete' => 'off', 'col' => '50', 'rows' => '2']) !!}
                            </div>
                            <span class="text-danger">{!! $errors->first('remarks') !!}</span>

                            <!-- branch_id text field -->
                            <div class="form-group col-md-6 col-xs-6">
                                {!! Form::label('branch_id', "branch Name: ") !!}
                                @if(!empty($branch) && isset($branch))
                                    {!! Form::select('branch_id', $branch, null, ['class' => 'form-control branch_id']) !!}
                                @else
                                    {!! Form::text('branch_id', null, ['class' => 'form-control branch_id', 'placeholder' => 'Branch name', 'autocomplete' => 'off']) !!}
                                @endif
                            </div>
                            <span class="text-danger">{!! $errors->first('branch_id') !!}</span>


                            <!-- priority feild text field -->
                            @if(isset($priority))
                                <div class="form-group col-md-6 col-xs-6">
                                    {!! Form::label('priority', "priority: ") !!}
                                    {!! Form::select('priority', $priority, null, ['class' => 'form-control']) !!}
                                </div>
                                <span class="text-danger">{!! $errors->first('priority') !!}</span>
                            @else
                                <div class="form-group col-md-6 col-xs-6">
                                    {!! Form::label('priority', "priority: ") !!}
                                    {!! Form::select('priority', [0=>'Heigh',1=>'Normal',2=>'Low'], null, ['class' => 'form-control']) !!}
                                </div>
                                <span class="text-danger">{!! $errors->first('priority') !!}</span>
                            @endif

                            <!-- Active or not feild text field -->
                            @if(isset($active))
                                <div class="form-group col-md-6 col-xs-6">
                                    {!! Form::label('active', "Active: ") !!}
                                    {!! Form::select('active',  $active, null,  ['class' => 'form-control']) !!}
                                </div>
                                <span class="text-danger">{!! $errors->first('active') !!}</span>
                            @else
                                <div class="form-group col-md-6 col-xs-6">
                                    {!! Form::label('active', "Active: ") !!}
                                    {!! Form::select('active',  [1=>'Active', 0=>'Not'], null,  ['class' => 'form-control']) !!}
                                </div>
                                <span class="text-danger">{!! $errors->first('active') !!}</span>
                            @endif

                            <div class="form-group col-md-6 col-xs-6">
                                @if(isset($order->products()->first()->image))
                                    {!! Form::label('Image', "Product Image: ") !!}
                                    <br>

                                    {{ Form::hidden('default_image', $order->products()->first()->image, null, array('id' => 'p_default_image')) }}
                                    <img src="{{url('assets/images/usersImages/product/'.$order->products()->first()->image)}}" name="p_old_image" class="p_old_image" style="width: 50px; height: 50px; margin-left:20px; border: 1px solid black;">

                                    <br>
                                @endif
                            </div>
                            <span class="text-danger">{!! $errors->first('image') !!}</span>

                            <div class="form-group col-md-6 col-xs-6">
                                @if(isset($order->image))
                                    {!! Form::label('Image', "New provided Image 1: ") !!}

                                    <br>
                                    <img src="{{url('assets/images/usersImages/order/'.$order->image)}}" name="old_image" class="old_image" style="width: 50px; height: 50px; margin-left:20px; border: 1px solid black;">
                                    <br><br>

                                    {!! Form::label('Image', "You can add more, please choose ") !!}
                                    {{  Form::hidden('new_image', null, array('id' => 'p_new_image')) }}
                                    {!! Form::file('image', ['id' =>'getImage']) !!}
                                @else
                                    <div id="image-block-1" style="display: none;visibility: hidden;">
                                        {!! Form::label('Image', "New provided Image 2: ") !!}

                                        <br>
                                        <img src="{{url('assets/images/usersImages/order/'.$order->image)}}" name="old_image" class="old_image" style="width: 50px; height: 50px; margin-left:20px; border: 1px solid black;">
                                        <br><br>

                                    </div>
                                    {!! Form::label('Image', "You can add more, please choose ") !!}
                                    {{  Form::hidden('new_image', null, array('id' => 'p_new_image')) }}
                                    {!! Form::file('image', ['id' =>'getImage']) !!}
                                @endif
                            </div>
                            <span class="text-danger">{!! $errors->first('image') !!}</span>
                            <div class="form-group col-md-12 col-xs-12">
                                {!! Form::hidden('id') !!}
                                {!! Form::hidden('form_name','order_update') !!}
                                {!! Form::submit('Save', array("class"=>"btn btn-info pull-left", "style"=>"width:100px; margin-left: 20px ")) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    @endif
                </div>
            @endif
      </div>
    </div>
</div>
@stop
@section('footer_scripts')
    <script type="text/javascript">


        (function($) {

            $(".default_image").on("click",(function(event){

                e.preventDeafult();
            }));

            $('.datepicker').datetimepicker({
                format: 'YYYY-MM-DD',
            });

            $('.timepicker').datetimepicker({
                format: 'LT'
            });

            $('#getImage').on('change', function (event, files, label) {

                var file_name = this.value.replace(/\\/g, '/').replace(/.*\//, '')

                $("#image-block-1").css({ visibility: "visible", display: 'block'});
                $("#image-block-2").css({ visibility: "visible", display: 'block'});

                $('.old_image').attr('src', "{{env('APP_URL')}}"+'assets/images/staticImage/'+file_name);

                $('#p_new_image').val(file_name);
            });


        })(jQuery);

    </script>
@stop