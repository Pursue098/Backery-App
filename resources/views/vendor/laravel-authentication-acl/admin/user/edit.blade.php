@extends('laravel-authentication-acl::admin.layouts.base-2cols')

@section('title')
Admin area: edit user
@stop

@section('content')
    <?php

        $branches = App\Branch::all();

        if($branches){
            $branches = $branches->pluck('name', 'id')->prepend('Select Branch','')->put('all','Get All');;

        }

        if($user->exists){
            $user = App\User::find($user->id);
            $user_branches = $user->branches;
        }
    ?>
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
                        <h3 class="panel-title bariol-thin">{!! isset($user->id) ? '<i class="fa fa-pencil"></i> Edit' : '<i class="fa fa-user"></i> Create' !!} user</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <a href="{!! URL::route('users.profile.edit',['user_id' => $user->id]) !!}" class="btn btn-info pull-right" {!! ! isset($user->id) ? 'disabled="disabled"' : '' !!}><i class="fa fa-user"></i> Edit profile</a>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <h4>Login data</h4>
                    {!! Form::model($user, [ 'url' => URL::route('users.edit')] )  !!}
                    {{-- Field hidden to fix chrome and safari autocomplete bug --}}
                    {!! Form::password('__to_hide_password_autocomplete', ['class' => 'hidden']) !!}
                    <!-- email text field -->
                    <div class="form-group">
                        {!! Form::label('email','Email: *') !!}
                        {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'user email', 'autocomplete' => 'off']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('email') !!}</span>
                    <!-- password text field -->
                    <div class="form-group">
                        {!! Form::label('password',isset($user->id) ? "Change password: " : "Password: ") !!}
                        {!! Form::password('password', ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => '']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('password') !!}</span>
                    <!-- password_confirmation text field -->
                    <div class="form-group">
                        {!! Form::label('password_confirmation',isset($user->id) ? "Confirm change password: " : "Confirm password: ") !!}
                        {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => '','autocomplete' => 'off']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('password_confirmation') !!}</span>
                    <div class="form-group">
                        {!! Form::label("activated","User active: ") !!}
                        {!! Form::select('activated', ["1" => "Yes", "0" => "No"], (isset($user->activated) && $user->activated) ? $user->activated : "0", ["class"=> "form-control"] ) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label("banned","Banned: ") !!}
                        {!! Form::select('banned', ["1" => "Yes", "0" => "No"], (isset($user->banned) && $user->banned) ? $user->banned : "0", ["class"=> "form-control"] ) !!}
                    </div>
                    {!! Form::hidden('id') !!}
                    {!! Form::hidden('form_name','user') !!}
                    <a href="{!! URL::route('users.delete',['id' => $user->id, '_token' => csrf_token()]) !!}" class="btn btn-danger pull-right margin-left-5 delete">Delete user</a>
                    {!! Form::submit('Save', array("class"=>"btn btn-info pull-right ")) !!}
                    {!! Form::close() !!}
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <h4><i class="fa fa-users"></i> Groups</h4>
                        @include('laravel-authentication-acl::admin.user.groups')

                        {{-- group permission form --}}
                        <h4><i class="fa fa-lock"></i> Permission</h4>
                        {{-- permissions --}}
                        @include('laravel-authentication-acl::admin.user.perm')
                    </div>

{{--                {{dd($user->permissions)}}--}}

{{--                    @if($user->permissions[0] != '{"_superadmin":1}')--}}
                        <div class="col-md-6 col-xs-12">
                        {{-- Branch Access --}}
                        <h4><i class="fa fa-blind" aria-hidden="true"></i> Access Branch</h4>

                        {{-- add branch --}}
                        {!! Form::open(["route" => array('branch.show', $user->id), 'method' => 'GET', 'class' => 'form-add-branch', "name" => $user->id, "role"=>"form"]) !!}
                        {{ Form::hidden('_method', 'GET') }}
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon form-button button-add-branch"><span class="glyphicon glyphicon-plus-sign add-input"></span></span>
                                    {!! Form::select('assign_branch', $branches, '', ["class"=>"form-control assign_branch"]) !!}
                                </div>
                                {{-- add branch operation --}}
                                {!! Form::hidden('operation', 1) !!}
                                {!! Form::hidden('id', $user->id) !!}
                                {!! Form::hidden('selected_branch_id', null,['class'=>'selected_branch_id']) !!}

                                <span class="text-danger assign_branch_error_msg"></span>
                                <span class="text-primary assign_branch_success_msg"></span>
                            </div>
                            @if(! $user->exists)
                                <div class="form-group">
                                    <span class="text-danger"><h5>You need to create the user first.</h5></span>
                                </div>
                            @endif
                        {!! Form::close() !!}


                        {{-- remove permission --}}
                        @if( isset($user_branches) )
                            @foreach($user_branches as $user_branch)
                                {!! Form::open(["route" => array('branch.show', $user->id), 'method' => 'GET', "role"=>"form", 'class' => 'form_delete_branch']) !!}
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon form-button button-del-branch" name="{!! $user_branch->name !!}">
                                                <span class="glyphicon glyphicon-minus-sign add-input"></span>
                                            </span>
                                            {!! Form::text('permission_desc', $user_branch->name, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                            {!! Form::hidden('id', $user->id) !!}
                                            {!! Form::hidden('operation', 0) !!}
                                            {!! Form::hidden('selected_branch_id', $user_branch->id,['class'=>'selected_branch_id']) !!}
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            @endforeach
                        @elseif($user->exists)
                            <span class="text-warning"><h5>There is no branch associated to the user.</h5></span>
                        @endif


                    </div>
                    {{--@endif--}}

                </div>
            </div>
      </div>
</div>
@stop

@section('footer_scripts')
<script>

    $(".button-add-branch").click(function () {

        $('.form-add-branch').submit();

    });
    $(".button-del-branch").click(function () {

        console.log('azam');

        $('.form_delete_branch').submit();

    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.assign_branch').on('change', function(e){

//        var confirmation = confirm("Are you sure to ?");
//
//        if(confirmation != true){
//            return;
//        }

        var branch_id = $('.assign_branch').val();
        $('.selected_branch_id').val(branch_id);

    });

    $(".delete").click(function(){
        return confirm("Are you sure to delete this item?");
    });
</script>
@stop