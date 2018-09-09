@extends('laravel-authentication-acl::admin.layouts.base-2cols')

@section('title')
Admin area: edit category
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
                        <h3 class="panel-title bariol-thin"><i class="fa fa-pencil"></i>Edit Branch</h3>
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
                    <h4>Updation</h4>
                    {!! Form::model($branch, [ 'url' => URL::route('branch.update', ['id' => $branch->id])] )  !!}
                    {{ Form::hidden('_method', 'PUT') }}
                    <!-- Branch's name text field -->
                    <div class="form-group">
                        {!! Form::label('name','Branch: *') !!}
                        {!! Form::text('name', $branch->name, ['class' => 'form-control', 'placeholder' => 'Branch name', 'autocomplete' => 'off']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('name') !!}</span>

                    <!-- Branch's code text field -->
                    <div class="form-group">
                        {!! Form::label('code','Code number: *') !!}
                        {!! Form::text('code', $branch->code, ['class' => 'form-control', 'placeholder' => 'Branch code', 'autocomplete' => 'off']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('code') !!}</span>

                    <!-- Branch's address text field -->
                    <div class="form-group">
                        {!! Form::label('address','Address: *') !!}
                        {!! Form::text('address', $branch->address, ['class' => 'form-control', 'placeholder' => 'Address', 'autocomplete' => 'off']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('address') !!}</span>

                    <!-- Branch's phone no text field -->
                    <div class="form-group">
                        {!! Form::label('phone','Phone: *') !!}
                        {!! Form::text('phone', $branch->pjone, ['class' => 'form-control', 'placeholder' => 'Phone number', 'autocomplete' => 'off']) !!}
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
                    {!! Form::hidden('form_name','branch_update') !!}
                    {!! Form::submit('Save', array("class"=>"btn btn-info pull-right ")) !!}
                    {!! Form::close() !!}

                    {{--Form for delete request--}}
                    {!! Form::model($branch, [ 'url' => URL::route('branch.destroy', ['id' => $branch->id])] )  !!}
                    {{ Form::hidden('_method', 'DELETE') }}
                    {{--<a href="{!! route('categories.destroy', ['id' => $category->id]) !!}" class="margin-left-5 delete"><i class="fa fa-trash-o fa-2x"></i></a>--}}
                    {!! Form::submit('Delete', array("class"=>"btn btn-danger pull-right delete", "style"=>"margin-right:10px")) !!}
                    {!! Form::close() !!}

                    </div>
                </div>
            </div>
      </div>
</div>
@stop

@section('footer_scripts')
<script>
    $(".delete").click(function(){
        return confirm("Are you sure to delete this item?");
    });
</script>
@stop