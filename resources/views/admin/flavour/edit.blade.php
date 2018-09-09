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
                        <h3 class="panel-title bariol-thin"><i class="fa fa-pencil"></i>Edit Flavor</h3>
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
            @if(isset($flavour))
                <div class="panel-body">
                    <div class="col-md-6 col-xs-12">
                        @if(isset($flavour->id))
                            <h4>Update Flavor</h4>
                            {!! Form::model($flavour, [ 'url' => URL::route('flavour.update', ['id' => $flavour->id])] )  !!}
                            {{ Form::hidden('_method', 'PUT') }}
                            <!-- Flavour's name text field -->
                            <div class="form-group">
                                {!! Form::label('name','Flavour: *') !!}
                                {!! Form::text('name', $flavour->name, ['class' => 'form-control', 'placeholder' => 'Flavour name', 'autocomplete' => 'off']) !!}
                            </div>
                            <span class="text-danger">{!! $errors->first('name') !!}</span>

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
                            {!! Form::hidden('form_name','flavour_update') !!}
                            {!! Form::submit('Save', array("class"=>"btn btn-info pull-right ")) !!}
                            {!! Form::close() !!}

                            {{--Form for delete request--}}
                            {!! Form::model($flavour, [ 'url' => URL::route('flavour.destroy', ['id' => $flavour->id])] )  !!}
                            {{ Form::hidden('_method', 'DELETE') }}
                            {{--<a href="{!! route('categories.destroy', ['id' => $category->id]) !!}" class="margin-left-5 delete"><i class="fa fa-trash-o fa-2x"></i></a>--}}
                            {!! Form::submit('Delete', array("class"=>"btn btn-danger pull-right delete", "style"=>"margin-right:10px")) !!}
                            {!! Form::close() !!}
                        @endif
                    </div>
                </div>
            @endif
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