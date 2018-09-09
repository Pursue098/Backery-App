@extends('laravel-authentication-acl::admin.layouts.base-2cols')

@section('title')
    Admin area: Product list
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
            <div class="col-md-12" style="margin-bottom: 10px">
                @include('admin.product.search')
            </div>
            <div class="col-md-12">
                {{-- print messages --}}
                <?php $message = Session::get('message'); ?>
                @if( isset($message) )
                    <div class="alert alert-success">{!! $message !!}</div>
                @endif
                {{-- print errors --}}
                @if($errors && ! $errors->isEmpty() )
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger">{!! $error !!}</div>
                    @endforeach
                @endif
                {{-- Product lists --}}
                @include('admin.product.index')
            </div>
        </div>
</div>
@stop

@section('footer_scripts')
    <script>
        $(".delete").click(function(){
            return confirm("Are you sure to delete this item?");
        });
        $(".p_del_from_index").click(function(){
            return confirm("Are you sure to delete this item?");
        });
    </script>
@stop