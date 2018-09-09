<?php
if (isset($menu_items)) {
    $basic_items = array();
    $other_items = array();
    $home = array();
    foreach ($menu_items as $item) {

        $item_name = $item->getName();

        if ($item->getName() == "Users" ||
                $item->getName() == "Groups" ||
                $item->getName() == "Configuration" ||
                $item->getName() == "Permission") {

            $basic_items[] = $item;

        }elseif ($item->getName() == "Home Screen") {

            $home[] = $item;

        } else {

            $other_items[] = $item;
        }
    }
}

?>

<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid margin-right-15">
        <div class="navbar-header">
            <a class="navbar-brand bariol-thin" href="#">{{$app_name}}</a>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav-main-menu">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="nav-main-menu">
            <ul class="nav navbar-nav">
                @if(isset($home) && count($home) > 0)
                    @foreach($home as $item)
                        <li style="margin-bottom: -18px; margin-top: -3px;" class="{!! LaravelAcl\Library\Views\Helper::get_active_route_name($item->getRoute()) !!}">
                            <a href="{!! $item->getLink() !!}"><i class="fa fa-home fa-2x"></i></a>
                        </li>
                    @endforeach
                @endif
                @if(isset($other_items) && count($other_items) > 0)
                    @foreach($other_items as $item)
                        <li class="{!! LaravelAcl\Library\Views\Helper::get_active_route_name($item->getRoute()) !!}">
                            <a href="{!! $item->getLink() !!}">{!!$item->getName()!!}</a>
                        </li>
                        <li class="divider"></li>
                    @endforeach
                @endif
                {{-- Basic items Menu --}}
                @if(isset($basic_items) && count($basic_items) > 0)
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">System <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            @foreach($basic_items as $item)
                                <li class="{!! LaravelAcl\Library\Views\Helper::get_active_route_name($item->getRoute()) !!}">
                                    <a href="{!! $item->getLink() !!}">{!!$item->getName()!!}</a>
                                </li>
                                <li class="divider"></li>
                            @endforeach
                        </ul>
                    </li>
                @endif
            </ul>

            <div class="navbar-nav nav navbar-right">
                <li class="dropdown dropdown-user">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="dropdown-profile">
                        @include('laravel-authentication-acl::admin.layouts.partials.avatar', ['size' => 30])
                        <span id="nav-email">{!! isset($logged_user) ? $logged_user->email : 'User' !!}</span>
                        <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{!! URL::route('users.selfprofile.edit') !!}"><i class="fa fa-user"></i> Your profile</a>
                            <a href="{!! URL::route('user.logout') !!}"><i class="fa fa-user"></i> Log out</a>
                        </li>
                    </ul>
                </li>
            </div><!-- nav-right -->
        </div><!--/.nav-collapse -->
    </div>
</div>

