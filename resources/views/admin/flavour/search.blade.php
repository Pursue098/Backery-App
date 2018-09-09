<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title bariol-thin"><i class="fa fa-search"></i> Flavour search</h3>
    </div>
    <div class="panel-body">
        {!! Form::open(['route' => 'categories.index','method' => 'get']) !!}
        <!-- email text field -->
        <div class="form-group">
            {!! Form::label('name','Name: ') !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Category name']) !!}
        </div>
        <span class="text-danger">{!! $errors->first('category') !!}</span>
        <!-- first_name text field -->
        <div class="form-group">
            {!! Form::label('description','Write description here: ') !!}
            {!! Form::text('description', null, ['class' => 'form-control', 'placeholder' => 'Describe']) !!}
        </div>
        <span class="text-danger">{!! $errors->first('description') !!}</span>
        <!-- last_name text field -->
        <div class="form-group">
            {!! Form::label('parent_id', 'Parent ID: ') !!}
            {!! Form::select('parent_id', ['' => 'Any', 1 => 'Yes', 0 => 'No'], ["class" => "form-control"]) !!}
        </div>


        {{--@include('laravel-authentication-acl::admin.user.partials.sorting')--}}
        <div class="form-group">
            <a href="{!! URL::route('categories.index') !!}" class="btn btn-default search-reset">Reset</a>
            {!! Form::submit('Search', ["class" => "btn btn-info", "id" => "search-submit"]) !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>