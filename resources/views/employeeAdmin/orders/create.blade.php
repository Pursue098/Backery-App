@extends('laravel-authentication-acl::admin.layouts.base-2cols')

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
                        <h3 class="panel-title bariol-thin"> <i class="fa fa-plus fa-0x"></i> Add a new Order</h3>
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
            <div class="panel-body">
                <div class="col-md-6 col-xs-12">
                    <h4>Add New Order</h4>
                    {!! Form::model('create', [ 'url' => URL::route('v1.employee_admin.order.store')] )  !!}
                    {{ Form::hidden('_method', 'POST') }}

                    <!-- Product name text field -->
                    <div class="form-group">
                        {!! Form::label('Product name','Product name: *') !!}
                        @if(!empty($product) && isset($product))
                            {!! Form::select('product_id', $product, null, ['class' => 'form-control']) !!}
                        @else
                            {!! Form::text('product_id', null, ['class' => 'form-control', 'placeholder' => 'Product name', 'autocomplete' => 'off']) !!}
                        @endif
                    </div>
                    <span class="text-danger">{!! $errors->first('product_id') !!}</span>

                    <!-- Custumer name text field -->
                    <div class="form-group">
                        {!! Form::label('Customer name','Customer name: *') !!}
                        {!! Form::text('cust_name', null, ['class' => 'form-control', 'placeholder' => 'Customer name', 'autocomplete' => 'off']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('cust_name') !!}</span>

                    <!-- Custumer email feild text field -->
                    <div class="form-group">
                        {!! Form::label('Customer email', "Customer email: ") !!}
                        {!! Form::text('cust_email', null, ['class' => 'form-control', 'placeholder' => 'Custumer email', 'autocomplete' => 'off']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('cust_email') !!}</span>

                        <!-- Customer address feild text field -->
                    <div class="form-group">
                        {!! Form::label('Customer address', "Customer address: ") !!}
                        {!! Form::text('cust_address', null, ['class' => 'form-control', 'placeholder' => 'Customer address', 'autocomplete' => 'off']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('cust_address') !!}</span>

                    <!-- Customer phone feild text field -->
                    <div class="form-group">
                        {!! Form::label('Customer phone', "Customer phone: ") !!}
                        {!! Form::text('cust_phone', null, ['class' => 'form-control', 'placeholder' => 'Customer phone', 'autocomplete' => 'off']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('cust_phone') !!}</span>

                    <!-- weight feild text field -->
                    <div class="form-group">
                        {!! Form::label('Weight', "Weight: ") !!}
                        {!! Form::text('weight', null, ['class' => 'form-control', 'placeholder' => 'Weight', 'autocomplete' => 'off']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('weight') !!}</span>

                    <!-- Quantity field -->
                    <div class="form-group">
                        {!! Form::label('Quantity', "Quantity: ") !!}
                        {!! Form::text('quantity', null, ['class' => 'form-control', 'placeholder' => 'Quantity', 'autocomplete' => 'off']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('quantity') !!}</span>

                    <!-- Flavor 1 field -->
                    <div class="form-group">
                        {!! Form::label('Flavor 1', "Flavor 1: ") !!}

                        @if(!empty($flavour) && isset($flavour))
                            {!! Form::select('flavor1_id', array_merge(['' => 'Please Select'], $flavour->toArray()), null, ['class' => 'form-control']) !!}
                        @else
                            {!! Form::text('flavor1_id', null, ['class' => 'form-control', 'placeholder' => 'Flavors', 'autocomplete' => 'off']) !!}
                        @endif
                    </div>
                    <span class="text-danger">{!! $errors->first('flavor1_id') !!}</span>

                    <!-- Flavor 2 field -->
                    <div class="form-group">
                        {!! Form::label('Flavor 2', "Flavor 2: ") !!}

                        @if(!empty($flavour) && isset($flavour))

                            {!! Form::select('flavor2_id', $flavour, null, ['class' => 'form-control']) !!}
                        @else
                            {!! Form::text('flavor2_id', null, ['class' => 'form-control', 'placeholder' => 'Flavors', 'autocomplete' => 'off']) !!}
                        @endif
                    </div>
                    <span class="text-danger">{!! $errors->first('flavor2_id') !!}</span>

                    <!-- price text field -->
                    <div class="form-group">
                        {!! Form::label('Price', "Price: ") !!}
                        {!! Form::text('price', null, ['class' => 'form-control', 'placeholder' => 'Price', 'autocomplete' => 'off']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('price') !!}</span>

                    <!-- Advance price text field -->
                    <div class="form-group">
                        {!! Form::label('Advance price', "Advance price: ") !!}
                        {!! Form::text('advance_price', null, ['class' => 'form-control', 'placeholder' => 'Advance price', 'autocomplete' => 'off']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('advance_price') !!}</span>

                    <!-- Payment type field -->
                    @if(isset($paymentType))
                        <div class="form-group">
                            {!! Form::label('Payment type', "Payment type: ") !!}
                            {!! Form::select('payment_type', $paymentType, null, ['class' => 'form-control']) !!}
                        </div>
                        <span class="text-danger">{!! $errors->first('payment_type') !!}</span>
                    @else
                        <div class="form-group">
                            {!! Form::label('Payment type', "Payment type: ") !!}
                            {!! Form::select('payment_type', [0=>'Credit', 1=>'Debit'], null, ['class' => 'form-control']) !!}
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
                    @else
                        <div class="form-group">
                            {!! Form::label('Payment status', "Payment status: ") !!}
                            {!! Form::select('payment_status', [1=>'Payed', 0=>'Not'], null, ['class' => 'form-control']) !!}
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
                    @else
                        <div class="form-group">
                            {!! Form::label('Order type', "Order type: ") !!}
                            {!! Form::select('order_type', [0=>'Personal', 1=>'By Call', 2=>'By Message'], null, ['class' => 'form-control']) !!}
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
                    @else
                        <div class="form-group">
                            {!! Form::label('Order status', "Order status: ") !!}
                            {!! Form::select('order_status', [0=>'Un processed', 1=>'processed', 2=>'Padding', 3=>'Canceled'], null, ['class' => 'form-control']) !!}
                        </div>
                        <span class="text-danger">{!! $errors->first('order_status') !!}</span>
                    @endif

                    <!-- Delivery date & time field -->
                    <div class="form-group">
                        {!! Form::label('Delivery date', "Delivery date: ") !!}

                        <div class='input-group datepicker'>
                            {{--<input type='text' class="form-control" />--}}
                            {!! Form::text('delivery_date', null, ['class' => 'form-control datepicker']) !!}
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                            </span>
                        </div>
                    </div>
                    <span class="text-danger">{!! $errors->first('delivery_date') !!}</span>

                    <!-- Delivery date & time field -->
                    <div class="form-group">
                        {!! Form::label('Delivery time', "Delivery time: ") !!}

                        <div class='input-group timepicker'>
                            {!! Form::text('delivery_time', null, ['class' => 'form-control delivery_time timepicker']) !!}
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                            </span>
                        </div>
                    </div>
                    <span class="text-danger">{!! $errors->first('delivery_time') !!}</span>

                    <!-- Remarks text field -->
                    <div class="form-group">
                        {!! Form::label('Remarks', "Remarks: ") !!}
                        {!! Form::textarea('remarks', null, ['class' => 'form-control', 'placeholder' => 'Remarks', 'autocomplete' => 'off', 'col' => '50', 'rows' => '2']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('remarks') !!}</span>

                    <!-- branch_id text field -->
                    <div class="form-group">
                        {!! Form::label('branch_id', "branch Name: ") !!}
                        @if(!empty($branch) && isset($branch))
                            {!! Form::select('branch_id', $branch, null, ['class' => 'form-control']) !!}
                        @else
                            {!! Form::text('branch_id', null, ['class' => 'form-control', 'placeholder' => 'Branch name', 'autocomplete' => 'off']) !!}
                        @endif
                    </div>
                    <span class="text-danger">{!! $errors->first('branch_id') !!}</span>

                    <!-- tags feild text field -->
                    <div class="form-group">
                        {!! Form::label('tag', "Tags: ") !!}
                        {!! Form::text('tag', null, ['class' => 'form-control', 'placeholder' => 'tags', 'autocomplete' => 'off']) !!}
                        {{--                        {!! Form::select('tag', [NULL=>' ', 1=>'Active', 0=>'Not active'], null,  ['class' => 'form-control']) !!}--}}
                    </div>
                    <span class="text-danger">{!! $errors->first('tag') !!}</span>

                    <!-- priority feild text field -->
                    @if(isset($priority))
                        <div class="form-group">
                            {!! Form::label('priority', "priority: ") !!}
                            {!! Form::select('priority', $priority, null, ['class' => 'form-control']) !!}
                        </div>
                        <span class="text-danger">{!! $errors->first('priority') !!}</span>
                    @else
                        <div class="form-group">
                            {!! Form::label('priority', "priority: ") !!}
                            {!! Form::select('priority', [0=>'Heigh',1=>'Normal',2=>'Low'], null, ['class' => 'form-control']) !!}
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
                    @else
                        <div class="form-group">
                            {!! Form::label('active', "Active: ") !!}
                            {!! Form::select('active',  [1=>'Active', 0=>'Not'], null,  ['class' => 'form-control']) !!}
                        </div>
                        <span class="text-danger">{!! $errors->first('active') !!}</span>
                    @endif


                    {!! Form::hidden('id') !!}
                    {!! Form::hidden('form_name','Orders') !!}
                    {!! Form::submit('Save', array("class"=>"btn btn-info pull-right ")) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('footer_scripts')
    <span class="text-danger">{!! $errors->first('image') !!}</span>
                    <!-- parent_id text field -->
<script>

    (function($) {

        var dt = new Date();
        var time = dt.getHours() + ":" + dt.getMinutes() + 'PM';

        $('.delivery_time').val(time);

        $('.datepicker').datetimepicker({
            format: 'YYYY-MM-DD',
            defaultDate: new Date()
        });

        $('.timepicker').datetimepicker({
            format: 'LT'
        });

        $('.product_id').on('change', function (e) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
                }
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

                    $('.op_old_image').attr('src', '{{env('APP_URL')}}'+'images/usersImages/product/'+image);

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