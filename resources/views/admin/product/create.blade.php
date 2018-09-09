@extends('laravel-authentication-acl::admin.layouts.base-2cols')

@section('title')
Admin area: edit product
@stop

@section('content')

<div class="row">
    <div class="col-md-12">
        {{-- successful message --}}
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        @if($errors->has('model') )
            <div class="alert alert-danger">{!! $errors->first('model') !!}</div>
        @endif
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="panel-title bariol-thin"> <i class="fa fa-plus fa-0x"></i> Add a new product</h3>
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
                    <h4>Add new Product</h4>
                    {!! Form::model('create', [ 'url' => URL::route('products.store')] )  !!}
                    {{ Form::hidden('_method', 'POST') }}

                    <!-- category field -->
                    <div class="form-group">
                        {!! Form::label('category',"Category: ") !!}
                        @if (isset($categories))
                            {!! Form::select('category_id', $categories, null,  ['class' => 'form-control']) !!}
                        @endif
                    </div>
                    <span class="text-danger">{!! $errors->first('category_id') !!}</span>

                    <!-- Product name text field -->
                    <div class="form-group">
                        {!! Form::label('Product name','Products: *') !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Product name', 'autocomplete' => 'off']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('name') !!}</span>

                    <!-- weight feild text field -->
                    <div class="form-group">
                        {!! Form::label('weight', "Weight: ") !!}
                        {!! Form::text('weight', null, ['class' => 'form-control', 'placeholder' => 'Weight will be', 'autocomplete' => 'off']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('weight') !!}</span>

                        <!-- flavor feild text field -->
                    <div class="form-group">
                        {!! Form::label('flavor', "Flavor: ") !!}
                        @if (isset($flavours))
                            {!! Form::select('flavor', $flavours, null,  ['class' => 'form-control']) !!}
                        @endif
                    </div>
                    <span class="text-danger">{!! $errors->first('flavor') !!}</span>

                    <!-- price feild text field -->
                    <div class="form-group">
                        {!! Form::label('price', "Price: ") !!}
                        {!! Form::text('price', null, ['class' => 'form-control', 'placeholder' => 'Price', 'autocomplete' => 'off']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('price') !!}</span>

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

                    <!-- Maximum age feild text field -->
                    <div class="form-group">
                        {!! Form::label('min_age', "Minimum age: ") !!}
                        {!! Form::text('min_age', null, ['class' => 'form-control', 'placeholder' => 'Minimum age', 'autocomplete' => 'off']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('min_age') !!}</span>

                    <!-- Maximum age feild text field -->
                    <div class="form-group">
                        {!! Form::label('max_age', "Maximum age: ") !!}
                        {!! Form::text('max_age', null, ['class' => 'form-control', 'placeholder' => 'Maximum age', 'autocomplete' => 'off']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('max_age') !!}</span>

                    <!-- tags feild text field -->
                    <div class="form-group">
                        {!! Form::label('tag', "Tags: ") !!}
                        {!! Form::text('tag', null, ['class' => 'form-control', 'placeholder' => 'tags', 'autocomplete' => 'off']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('tag') !!}</span>

                    <!-- image field -->
                    <div class="form-group">
                        {!! Form::label('image', "Image: ") !!}
                        {!! Form::file('image') !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('image') !!}</span>

                    {!! Form::hidden('id') !!}
                    {!! Form::hidden('form_name','products') !!}
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
    $(".delete").click(function(){
        return confirm("Are you sure to delete this item?");
    });
</script>
@stop