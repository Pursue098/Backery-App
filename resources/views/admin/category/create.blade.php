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
                        <h3 class="panel-title bariol-thin"> <i class="fa fa-plus fa-0x"></i> Add a new category</h3>
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

                    {!! Form::model('create', [ 'url' => URL::route('categories.store')] )  !!}
                    {{ Form::hidden('_method', 'POST') }}

                    <!-- Category text field -->
                    <div class="form-group">
                        {!! Form::label('Category name','Category: *') !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Category name', 'autocomplete' => 'off']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('name') !!}</span>

                    <!-- Description text field -->
                    <div class="form-group">
                        {!! Form::label('description', "Description: ") !!}
                        {!! Form::text('description', null, ['class' => 'form-control', 'placeholder' => 'Description here', 'autocomplete' => 'off']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('description') !!}</span>

                    <!-- parent_id text field -->
                    <div class="form-group">
                        {!! Form::label('parent_id',"Category as parent: ") !!}
                        @if (isset($categoryParentData) && isset($categoryChildData))
{{--                            {!! Form::select('parent_id', $category, null,  ['class' => 'form-control']) !!}--}}

                            @if(isset($categoryParentData) && isset($categoryChildData))
                                <select name="parent_id" id="parent_id" class="form-control">
                                    <option selected>Select Category</option>
                                    <optgroup label="Parent Categories" >
                                        @foreach ($categoryParentData as $parentCat)
                                            <option value="{{ $parentCat['id'] }}">{{ $parentCat['name'] }}</option>
                                        @endforeach
                                        <option value="NULL">None</option>
                                    </optgroup>
                                    <optgroup label="Child Categories">
                                        @foreach ($categoryChildData as $childCat)
                                            <option value="{{ $childCat['id'] }}">{{ $childCat['name'] }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            @endif
                        @endif
                    </div>
                    <span class="text-danger">{!! $errors->first('parent_id') !!}</span>

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

                    <!-- image text field -->
                    <div class="form-group">
                        {!! Form::label('image', "Load image: ") !!}
                        {!! Form::file('image') !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('image') !!}</span>

                    {!! Form::hidden('id') !!}
                    {!! Form::hidden('form_name','category') !!}
                    {!! Form::submit('Save', array("class"=>"btn btn-info pull-right ")) !!}
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