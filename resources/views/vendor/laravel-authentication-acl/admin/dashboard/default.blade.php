<?php

use Illuminate\Support\Facades\Redirect;

    $authentication = \App::make('authenticator');
    $authentication_helper = \App::make('authentication_helper');

    $adminPermissions = '_superadmin';
    $clientPermissions = '_customer';
    $backmanPermissions = '_backman';
    $managerPermissions = '_manager';


    $redirectClientTo = '/';
    $redirectAdminTo = '/admin/categories';
    $redirectBackmanTo = '/employee/v1/order';
    $redirectManagerTo = 'employee_admin/v1/order';

    $user = $authentication->getLoggedUser();

    $perm = $user->permissions;
    if(!empty($perm)){

        foreach($perm as $key=> $val)
        {
            $permission_name = $key;
        }

        $authentication_helper->hasPermission($perm);

    //dd($permission_name);
        if ($permission_name == $clientPermissions){

    //        return redirect($this->redirectClientTo);

        }
        elseif ($permission_name == $backmanPermissions){

    //        dd('azamghfh');
    //        return Redirect::to('/employee/v1/order');
    //        redirect()->route('v1.employee.');
    //        return redirect('/employee/v1/order');

        }elseif ($permission_name == $managerPermissions){

    //        return redirect($redirectManagerTo);
    //        redirect()->route('v1.employee_admin.order');

        }elseif ($permission_name == $adminPermissions){

    //        dd('azam',redirect()->route('categories.index'));
    //        redirect()->route('categories.index');
    //        return Redirect::route('login');
    //        return redirect('http://10.10.10.107/tehzeeb/public/admin/categories');

        }
    }
?>

@extends('laravel-authentication-acl::admin.layouts.base-2cols')

@section('title')
Admin area: dashboard
@stop



@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
      <h3><i class="fa fa-dashboard"></i> Dashboard</h3>
      <hr/>
  </div>
  <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="stats-item margin-left-5 margin-bottom-12"><i class="fa fa-user icon-large"></i> <span class="text-large margin-left-15">{!! $registered !!}</span>
      <br/>Total users</div>
      <div class="stats-item margin-left-5 margin-bottom-12"><i class="fa fa-unlock-alt icon-large"></i> <span class="text-large margin-left-15">{!! $active !!}</span>
          <br/>Active users</div>
      <div class="stats-item margin-left-5 margin-bottom-12"><i class="fa fa-lock icon-large"></i> <span class="text-large margin-left-15">{!! $pending !!}</span>
          <br/>Pending users</div>
      <div class="stats-item margin-left-5 margin-bottom-12"><i class="fa fa-ban icon-large"></i> <span class="text-large margin-left-15">{!! $banned !!}</span>
          <br/>Banned users</div>
  </div>
</div>
@stop