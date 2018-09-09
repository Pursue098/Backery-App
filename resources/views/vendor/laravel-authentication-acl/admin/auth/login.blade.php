@extends('laravel-authentication-acl::admin.layouts.baseauth')
@section('title')
Admin login
@stop
@section('container')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <?php $message = Session::get('message'); ?>
            @if( isset($message) )
                <div class="alert alert-success">{{$message}}</div>
            @endif
            @if($errors && ! $errors->isEmpty() )
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger">{{$error}}</div>
                @endforeach
            @endif
        </div>
    </div>
    <body class="login_bg">
    <div class="wrapper">

        <div class="login_form_container">
            <div class="login_screw_left"><img src="{{  asset('assets/images/staticImage/login_screw_left.png') }}" alt=""></div>
            <div class="login_screw_right"><img src="{{  asset('assets/images/staticImage/login_screw_right.png') }}" alt=""></div>
            <div class="login_screw_bottom_left"><img src="{{  asset('assets/images/staticImage/login_screw_left.png') }}" alt=""></div>
            <div class="login_screw_bottom_right"><img src="{{  asset('assets/images/staticImage/login_screw_right.png') }}" alt=""></div>
            <div class="logo">
                <img src="{{  asset('assets/images/staticImage/login_logo.png') }}" alt="">
            </div>

            <div class="login_form">

                {!! Form::open(array('url' => URL::route("user.login.process"), 'method' => 'post') ) !!}

                {!! Form::email('email', '', ['id' => 'email', 'class' => 'form-control username', 'placeholder' => 'Email address', 'required', 'autocomplete' => 'off']) !!}
                {!! Form::password('password', ['id' => 'password', 'class' => 'form-control password', 'placeholder' => 'Password', 'required', 'autocomplete' => 'off']) !!}

                {!! Form::label('remember','Remember me') !!}
                {!! Form::checkbox('remember') !!}
                <input type="submit" value="Login" class="btn btn-info btn-block">
                {!! Form::close() !!}

                <a href="{{ url('/login') }}">Login as a Client</a>

            </div>
        </div>

        <footer class="footer"> <span>Cake software version 1.1.0.</span> </footer>

    </div>
    </body>
@stop