@if(isset($logged_user) && $logged_user->user_profile()->count())
    <img src="{!! env('APP_URL'). $logged_user->user_profile()->first()->presenter()->avatar($size) !!}" width="{{$size}}">
@else
    <img src="{!! env('APP_URL').'packages/jacopo/laravel-authentication-acl/images/avatar.png' !!}" width="{{$size}}">
@endif