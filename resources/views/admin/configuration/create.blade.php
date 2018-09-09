@extends('laravel-authentication-acl::admin.layouts.base-2cols')

@section('title')
Admin area: edit flavour
@stop

@section('content')

    <div class="jumbotron jumbotron-sm">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <h2>Admin <small>Configuration Section</small></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="well well-sm">
                    {!! Form::model('create', [ 'url' => URL::route('configuration.store')] )  !!}
                    {{ Form::hidden('_method', 'POST') }}

                        <fieldset>

                            <!-- Text input Active-->
                            <div class="form-group">
                                {!! Form::label('Active','Active: ', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-5">
                                    {!! Form::text('active', null, ['class' => 'form-control input-md', 'id' => 'active', 'placeholder' => 'Enter active value', 'autocomplete' => 'off']) !!}
                                </div>
                            </div>
                            <span class="text-danger">{!! $errors->first('active') !!}</span><br><br>

                            <!-- Text input priority-->
                            <div class="form-group">
                                {!! Form::label('Priority','priority: ', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-5">
                                    {!! Form::text('priority', null, ['class' => 'form-control input-md', 'id' => 'priority', 'placeholder' => 'Enter priority value', 'autocomplete' => 'off']) !!}
                                </div>
                            </div>
                            <span class="text-danger">{!! $errors->first('priority') !!}</span><br><br>


                            <!-- Text input order_type-->
                            <div class="form-group">
                                {!! Form::label('Order type','Order type: ', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-5">
                                    {!! Form::text('order_type', null, ['class' => 'form-control input-md', 'id' => 'order_type', 'placeholder' => 'Enter order type', 'autocomplete' => 'off']) !!}
                                </div>
                            </div>
                            <span class="text-danger">{!! $errors->first('order_type') !!}</span><br><br>


                            <!-- Text input order_status-->
                            <div class="form-group">
                                {!! Form::label('Order Status','Order Status: ', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-5">
                                    {!! Form::text('order_status', null, ['class' => 'form-control input-md', 'id' => 'order_status', 'placeholder' => 'Enter order status', 'autocomplete' => 'off']) !!}
                                </div>
                            </div>
                            <span class="text-danger">{!! $errors->first('order_status') !!}</span><br><br>

                            <!-- Text input payment_type-->
                            <div class="form-group">
                                {!! Form::label('Payment Type','Payment Type: ', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-5">
                                    {!! Form::text('payment_type', null, ['class' => 'form-control input-md', 'id' => 'payment_type', 'placeholder' => 'Enter payment type', 'autocomplete' => 'off']) !!}
                                </div>
                            </div>
                            <span class="text-danger">{!! $errors->first('payment_type') !!}</span><br><br>

                            <!-- Text input payment_status-->
                            <div class="form-group">
                                {!! Form::label('Payment Status','Payment Status: ', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-5">
                                    {!! Form::text('payment_status', null, ['class' => 'form-control input-md', 'id' => 'payment_status', 'placeholder' => 'Enter payment status', 'autocomplete' => 'off']) !!}
                                </div>
                            </div>
                            <span class="text-danger">{!! $errors->first('payment_status') !!}</span><br><br>

                            <!-- Text input branch_name-->
                            <div class="form-group">
                                {!! Form::label('Branch Name','Branch Name: ', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-5">
                                    {!! Form::text('branch_name', null, ['class' => 'form-control input-md', 'id' => 'branch_name', 'placeholder' => 'Enter branch name', 'autocomplete' => 'off']) !!}
                                </div>
                            </div>
                            <span class="text-danger">{!! $errors->first('branch_name') !!}</span><br><br>

                        </fieldset>
                    {!! Form::hidden('id') !!}
                    {!! Form::hidden('form_name','configuration') !!}
                    {!! Form::submit('Save', array("class"=>"btn btn-info ", 'style' => 'margin-top: 10px; margin-left: 14px; padding-left: 50px; padding-right: 50px;')) !!}
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>

@stop

@section('footer_scripts')
    <span class="text-danger">{!! $errors->first('image') !!}</span>
    <!-- parent_id text field -->
<script>
    $(".delete").click(function(){
        return confirm("Are you sure to delete this item?");
    });
</script>

    <style>
        .jumbotron{
            margin-bottom: 0 !important;
            margin-top: 0 !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            padding-top: 0 !important;
        }
    </style>

@stop