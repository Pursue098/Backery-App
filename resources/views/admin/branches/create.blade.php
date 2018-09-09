@extends('laravel-authentication-acl::admin.layouts.base-2cols')

@section('title')
Admin area: edit flavour
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
                        <h3 class="panel-title bariol-thin"> <i class="fa fa-plus fa-0x"></i> Add a new branches</h3>
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
                    <h4>Add new Branch</h4>
                    {!! Form::model('create', [ 'url' => URL::route('branch.store')] )  !!}
                    {{ Form::hidden('_method', 'POST') }}
                    <!-- Branch name text field -->
                    <div class="form-group">
                        {!! Form::label('Branch name','Name: *') !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Branch name', 'autocomplete' => 'off']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('name') !!}</span>

                    <!-- Code Number text field -->
                    <div class="form-group">
                        {!! Form::label('Branch Code Number','Branch Code: *') !!}
                        {!! Form::text('code', null, ['class' => 'form-control', 'placeholder' => 'Code number', 'autocomplete' => 'off']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('code') !!} </span>

                    <!-- Address text field -->
                    <div class="form-group">
                        {!! Form::label('Address','Address: *') !!}
                        {!! Form::text('address', null, ['class' => 'form-control', 'placeholder' => 'Address', 'autocomplete' => 'off']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('address') !!}</span>

                    <!-- Phone Number text field -->
                    <div class="form-group">
                        {!! Form::label('Phone Number','Phone: *') !!}
                        {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Phone number', 'autocomplete' => 'off']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('phone') !!}</span>

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
                    {!! Form::hidden('branch_name','branch') !!}
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