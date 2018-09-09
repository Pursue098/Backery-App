@extends('laravel-authentication-acl::admin.layouts.base-2cols')

@section('title')
Admin area: edit configuration
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
                        <h3 class="panel-title bariol-thin">{!! isset($configuration->id) ? '<i class="fa fa-pencil"></i> Edit' : '<i class="fa fa-user"></i> Create' !!} Config Item</h3>
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
                    {!! Form::model($configuration, [ 'url' => URL::route('configuration.update', ['id' => $configuration->id])] )  !!}
                    {{ Form::hidden('_method', 'PUT') }}
                    <!-- Branch's name text field -->
                    <div class="form-group">
                        {!! Form::label('value','Edit it: *') !!}
                        {!! Form::text('value', $configuration->value, ['class' => 'form-control', 'placeholder' => 'Edit it', 'autocomplete' => 'off']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('value') !!}</span>


                    {!! Form::hidden('id') !!}
                    {!! Form::hidden('form_name','config_update') !!}
                    {!! Form::submit('Save', array("class"=>"btn btn-info pull-right ")) !!}
                    {!! Form::close() !!}

                    {{--Form for delete request--}}
                    {!! Form::model($configuration, [ 'url' => URL::route('configuration.destroy', ['id' => $configuration->id])] )  !!}
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