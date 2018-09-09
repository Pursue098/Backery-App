@extends('laravel-authentication-acl::admin.layouts.base-2cols')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('title')
Admin area: edit Order
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
            @if(isset($order))
                <div class="panel-body">
                <div class="col-md-6 col-xs-12">
                    @if(isset($order->id))

                        <h4>Update Order</h4>

                        {!! Form::model($order, [ 'url' => URL::route('order.update', ['id' => $order->id])] )  !!}
                        {{ Form::hidden('_method', 'PUT') }}

                        <!-- Product text field -->
                        <div class="form-group">
                            {!! Form::label('Product name','Product name: *') !!}
                            @if(isset($products))

                                @if(isset($products) && isset($selectedProduct))
                                    <select name="product_id" id="product_id" class="form-control product_id">
                                        @foreach ($products as $prod)
                                            @if($prod->id == $selectedProduct)
                                                <option selected value="{{ $prod->id }}">{{ $prod->name }}</option>
                                            @else
                                                <option value="{{ $prod->id }}">{{ $prod->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                @else
                                    <p>First Enter the product please</p>
                                @endif

                            @endif
                        </div>
                        <span class="text-danger">{!! $errors->first('flavor') !!}</span>



                        <!-- Custumer name text field -->
                        <div class="form-group">
                            {!! Form::label('Customer name','Customer name: *') !!}
                            {!! Form::text('cust_name', $order->cust_name, ['class' => 'form-control name', 'placeholder' => 'Custumer name', 'autocomplete' => 'off']) !!}
                        </div>
                        <span class="text-danger">{!! $errors->first('name') !!}</span>

                        <!-- Custumer email feild text field -->
                        <div class="form-group">
                            {!! Form::label('Customer email', "Customer email: ") !!}
                            {!! Form::text('cust_email', $order->cust_email, ['class' => 'form-control email', 'placeholder' => 'Custumer email', 'autocomplete' => 'off']) !!}
                        </div>
                        <span class="text-danger">{!! $errors->first('email') !!}</span>

                        <!-- Customer address feild text field -->
                        <div class="form-group">
                            {!! Form::label('Customer address', "Customer address: ") !!}
                            {!! Form::text('cust_address', $order->cust_address, ['class' => 'form-control address', 'placeholder' => 'Customer address', 'autocomplete' => 'off']) !!}
                        </div>
                        <span class="text-danger">{!! $errors->first('address') !!}</span>

                        <!-- Customer phone feild text field -->
                        <div class="form-group">
                            {!! Form::label('Customer phone', "Customer phone: ") !!}
                            {!! Form::text('cust_phone', $order->cust_phone, ['class' => 'form-control phone', 'placeholder' => 'Customer phone', 'autocomplete' => 'off']) !!}
                        </div>
                        <span class="text-danger">{!! $errors->first('phone') !!}</span>

                        <!-- weight feild text field -->
                        <div class="form-group">
                            {!! Form::label('Weight', "Weight: ") !!}
                            {!! Form::text('weight', $order->weight, ['class' => 'form-control weight', 'placeholder' => 'Weight', 'autocomplete' => 'off']) !!}
                        </div>
                        <span class="text-danger">{!! $errors->first('weight') !!}</span>

                        <!-- Quantity field -->
                        <div class="form-group">
                            {!! Form::label('Quantity', "Quantity: ") !!}
                            {!! Form::text('quantity', $order->quantity, ['class' => 'form-control quantity', 'placeholder' => 'Quantity', 'autocomplete' => 'off']) !!}
                        </div>
                        <span class="text-danger">{!! $errors->first('quantity') !!}</span>

                        <!-- flavor text field -->
                        <div class="form-group">
                            @if(isset($flavour))
                                @if(isset($flavour) && isset($selectedFlavor_1))

                                    {!! Form::label('flavor1_id',!isset($product->id) ? "Flavor: " : "Flavor: ") !!}
                                    <select name="flavor1_id" id="flavor1_id" class="form-control flavor1_id">
                                        @foreach ($flavour as $flavor)
                                            @if($flavor->id == $selectedFlavor_1)
                                                <option selected value="{{ $flavor->id }}">{{ $flavor->name }}</option>
                                            @else
                                                <option value="{{ $flavor->id }}">{{ $flavor->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                @elseif(isset($flavourDefaut))
                                    {!! Form::label('flavor1_id',"Choose first flavor: ") !!}
                                    {!! Form::select('flavor1_id', $flavourDefaut, null, ['class' => 'form-control flavor1_id']) !!}
                                @endif

                            @endif
                        </div>
                        <span class="text-danger">{!! $errors->first('flavor') !!}</span>

                        <!-- flavor text field -->
                        <div class="form-group">
                            @if(isset($flavour))
                                @if(isset($flavour) && isset($selectedFlavor_2))

                                    {!! Form::label('flavor2_id',!isset($product->id) ? "Flavor: " : "Flavor: ") !!}
                                    <select name="flavor2_id" id="flavor2_id" class="form-control flavor2_id">
                                        @foreach ($flavour as $flavor)
                                            @if($flavor->id == $selectedFlavor_2)
                                                <option selected value="{{ $flavor->id }}">{{ $flavor->name }}</option>
                                            @else
                                                <option value="{{ $flavor->id }}">{{ $flavor->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                @elseif(isset($flavourDefaut))
                                    {!! Form::label('flavor2_id',"Choose second flavor: ") !!}
                                    {!! Form::select('flavor2_id', $flavourDefaut, null, ['class' => 'form-control flavor2_id']) !!}
                                @endif

                            @endif
                        </div>
                        <span class="text-danger">{!! $errors->first('flavor') !!}</span>

                        <!-- price text field -->
                        <div class="form-group">
                            {!! Form::label('Price', "Price: ") !!}
                            {!! Form::text('price', $order->price, ['class' => 'form-control price', 'placeholder' => 'Price', 'autocomplete' => 'off']) !!}
                        </div>
                        <span class="text-danger">{!! $errors->first('price') !!}</span>

                        <!-- Advance price text field -->
                        <div class="form-group">
                            {!! Form::label('Advance price', "Advance price: ") !!}
                            {!! Form::text('advance_price', $order->advance_price, ['class' => 'form-control advance_price', 'placeholder' => 'Advance price', 'autocomplete' => 'off']) !!}
                        </div>
                        <span class="text-danger">{!! $errors->first('advance_price') !!}</span>

                        {{--!-- Payment type field -->--}}
                        @if(isset($paymentType))
                            <div class="form-group">
                                {!! Form::label('Payment type', "Payment type: ") !!}
                                {!! Form::select('payment_type', $paymentType, null, ['class' => 'form-control']) !!}
                            </div>
                            <span class="text-danger">{!! $errors->first('payment_type') !!}</span>
                        @endif

                        <!-- Payment status field -->
                        @if(isset($paymentStatus))
                            <div class="form-group">
                                {!! Form::label('Payment status', "Payment status: ") !!}
                                {!! Form::select('payment_status', $paymentStatus, null, ['class' => 'form-control']) !!}
                            </div>
                            <span class="text-danger">{!! $errors->first('payment_status') !!}</span>
                        @endif

                        <!-- Order type field -->
                        @if(isset($orderType))
                            <div class="form-group">
                                {!! Form::label('Order type', "Order type: ") !!}
                                {!! Form::select('order_type', $orderType, null, ['class' => 'form-control']) !!}
                            </div>
                            <span class="text-danger">{!! $errors->first('order_type') !!}</span>
                        @endif

                        <!-- Order status field -->
                        @if(isset($orderStatus))
                            <div class="form-group">
                                {!! Form::label('Order status', "Order status: ") !!}
                                {!! Form::select('order_status', $orderStatus, null, ['class' => 'form-control']) !!}
                            </div>
                            <span class="text-danger">{!! $errors->first('order_status') !!}</span>
                        @endif
                        <!-- Delivery date & time field -->
                        <div class="form-group">
                            {!! Form::label('Delivery date', "Delivery date: ") !!}

                            @if(!empty($order->delivery_date) && isset($order->delivery_date))
                                <div class='input-group datepicker'>
                                    {{--{{$order->delivery_date}}--}}
                                    {{--{{Carbon\Carbon::createFromFormat('Y-m-d G:i:s', $order->delivery_date)->toDateTimeString()}}--}}
                                    {!! Form::text('delivery_date',
                                        Carbon\Carbon::createFromFormat('Y-m-d G:i:s', $order->delivery_date)->toDateTimeString(),
                                         ['class' => 'form-control datepicker'])
                                     !!}
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                                        </span>
                                </div>
                            @else
                                <div class='input-group datepicker'>
                                    {!! Form::text('delivery_date', null, ['class' => 'form-control datepicker']) !!}
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                                        </span>
                                </div>
                            @endif
                        </div>
                        <span class="text-danger">{!! $errors->first('delivery_date') !!}</span>

                        <!-- Delivery date & time field -->
                        <div class="form-group">
                            {!! Form::label('Delivery time', "Delivery time: ") !!}

                            @if(!empty($order->delivery_time) && isset($order->delivery_time))
                                <div class='input-group date timepicker'>
                                    {!! Form::text('delivery_time', $order->delivery_time, ['class' => 'form-control delivery_time timepicker']) !!}
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                                        </span>
                                </div>
                            @else
                                <div class='input-group date timepicker'>
                                    {!! Form::text('delivery_time', null, ['class' => 'form-control delivery_time timepicker']) !!}
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                                        </span>
                                </div>
                            @endif
                        </div>
                        <span class="text-danger">{!! $errors->first('delivery_time') !!}</span>

                        <!-- Remarks text field -->
                        <div class="form-group">
                            {!! Form::label('Remarks', "Remarks: ") !!}
                            {!! Form::textarea('remarks', $order->remarks, ['class' => 'form-control', 'placeholder' => 'Remarks', 'autocomplete' => 'off', 'col' => '50', 'rows' => '2']) !!}
                        </div>
                        <span class="text-danger">{!! $errors->first('remarks') !!}</span>

                        <!-- branch_id text field -->
                        <div class="form-group">
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
                            <div class="form-group">
                                {!! Form::label('priority', "priority: ") !!}
                                {!! Form::select('priority', $priority, null, ['class' => 'form-control']) !!}
                            </div>
                            <span class="text-danger">{!! $errors->first('priority') !!}</span>
                        @endif
                        <!-- Active or not feild text field -->
                        @if(isset($active))
                            <div class="form-group">
                                {!! Form::label('active', "Active: ") !!}
                                {!! Form::select('active',  $active, null,  ['class' => 'form-control']) !!}
                            </div>
                            <span class="text-danger">{!! $errors->first('active') !!}</span>
                        @endif
                        <!-- image field -->
                        <div class="form-group">
                            @if(isset($order->products()->first()->image))

                                {!! Form::label('Image',!isset($order->id) ? "Main image: " : "Default Image: ") !!}
                                <br>
                                <img src="{{url(asset(config('images.product_image_path')).'/'.$order->products()->first()->image)}}" name="op_old_image" class="op_old_image" style="width: 50px; height: 50px; margin-left:20px; border: 1px solid black;">

                            @endif
                        </div>
                        <span class="text-danger">{!! $errors->first('image') !!}</span>



                        {!! Form::hidden('id') !!}
                        {{ Form::hidden('order_id', $order->id, array('id' => 'order_id')) }}
                        {!! Form::hidden('form_name','order_update') !!}
                        {!! Form::submit('Save', array("class"=>"btn btn-info pull-right ")) !!}
                        {!! Form::close() !!}

                        {{--Form for delete request--}}
                        {!! Form::model($order, [ 'url' => URL::route('order.destroy', ['id' => $order->id])] )  !!}
                        {{ Form::hidden('_method', 'DELETE') }}
                        {!! Form::submit('Delete', array("class"=>"btn btn-danger pull-right delete",
                        "style"=>"margin-right:10px")) !!}
                        {!! Form::close() !!}

                        {{ Form::button('Print Script', array('class' => 'btn print-script')) }}

{{--                        <a href="{!! URL::route('order.edit', ['id' => $order->id]) !!}" class="btn btn-default print-script">Print Script</a>--}}

                    @endif
                    </div>
                </div>
            @endif
      </div>
    </div>
</div>
@stop

@section('footer_scripts')
<script>

    (function($) {

        $('.datepicker').datetimepicker({
            format: 'YYYY-MM-DD',
        });

        $('.timepicker').datetimepicker({
            format: 'LT'
        });



        $(".print-script").click(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
                }
            });

            var order_id = $('#order_id').val();

            $.ajax({
                type: "GET",
                url: '{{env('APP_URL')}}'+'admin/order/'+order_id+'/print_screen',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {

                    var originalContents = document.body.innerHTML;

                    document.body.innerHTML = data.page;

                    window.print();

                    document.body.innerHTML = originalContents;

                    var delay = 1000;
                    setTimeout(function(){

                        window.location.reload();
                    }, delay);

                },
                error: function(data) {
                    console.log(data);
                    return;
                }
            },"json");

            return;
        });


        $('.product_id').on('change', function (e) {

            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });

            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;

//            console.log(optionSelected)
            console.log(valueSelected)

            var data = {id:valueSelected}
            $.ajax({
                type: "Post",
                url: './get_product_image',
                data:data,
                cache: false,
                success: function(data) {

                    console.log('aliali', data)

                    var image = data[0].image;

                    if(image){
                        $('.op_old_image').attr('src', '{{env('APP_URL')}}'+'assets/images/usersImages/product/'+image);

                    }else {
                        $('.op_old_image').replaceWith('<p>Product image not exist.</p>')
                        $('.op_old_image').replaceWith('<p>Product image not exist.</p>')

                    }


                    {{--                    $('.op_old_image').replaceWith('{{ Form::image(url('images/usersImages/product/'.image), 'op_old_image', array("class"=>"op_old_image", "style" => " margin-left:20px; border: 1px solid black;")) }}');--}}
                },
                error: function(data) {
                    console.log(data);
                }
            },"json");

            return;

        });

    })(jQuery);


    $(".delete").click(function(){
        return confirm("Are you sure to delete this item?");
    });
</script>
@stop