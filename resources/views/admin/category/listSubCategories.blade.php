
@extends('laravel-authentication-acl::admin.layouts.base-2cols')

@section('title')
    Admin area: category list
@stop

@section('content')
<div class="panel panel-info">
    <div class="breadcrumb-section">
        @if( ! $default_category->isEmpty())
            {!! Breadcrumbs::render('listSubCategories', $default_category) !!}
        @endif
    </div>
    <div class="panel-heading">
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

    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <div style="text-align: center">
                    {{$subCategoriesData->render()}}
                </div>
                @if(! $subCategoriesData->isEmpty() )
                    <table class="table table-bordered table-inverse">
                        <thead>
                        <tr>
                            <th>Category name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Image</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th>Operations</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($subCategoriesData as $subCategory)

                            <tr>
                                @if($subCategory->hasChild($subCategory->id))
                                    <td>
                                        <a href="{!! URL::route('categories.listSubCategories', ['id' => $subCategory->id]) !!}">
                                            {!! $subCategory->name !!}
                                        </a>
                                    </td>
                                @else
                                    <td>
                                        {!! $subCategory->name !!}
                                    </td>
                                @endif

                                @if(isset($subCategory->description))
                                    <td>{!! $subCategory->description !!}</td>
                                @else
                                    <td> </td>
                                @endif

{{--                                    {{dd($subCategory->active)}}--}}
                                @if(isset($subCategory->active))
                                    @if($subCategory->active == $active[0]['key'])
                                        <td>{!! $active[0]['value'] !!}</td>
                                    @elseif($subCategory->active == $active[1]['key'])
                                        <td>{!! $active[1]['value'] !!}</td>
                                    @endif
                                @else
                                    <td> </td>
                                @endif

                                @if(isset($subCategory->image))
                                    <td>
                                        <img src="{{ asset('assets/images/usersImages/category/'.$subCategory->image ) }}" style="width: 50px; height: 50px;"/>
                                    </td>
                                @else
                                    <td> </td>
                                @endif
                                @if(isset($subCategory->created_at))
                                    <td>{!! $subCategory->created_at !!}</td>
                                @else
                                    <td> </td>
                                @endif
                                @if(isset($subCategory->updated_at))
                                    <td>{!! $subCategory->updated_at !!}</td>
                                @else
                                    <td> </td>
                                @endif
                                <td>
                                    @if( $subCategory->id)

                                        <a href="{!! URL::route('categories.edit', ['id' => $subCategory->id]) !!}">
                                            <i class="fa fa-pencil-square-o fa-2x"></i>
                                        </a>

                                        {!! Form::model($subCategory, [ 'url' => URL::route('categories.destroy', ['id' => $subCategory->id])] )  !!}
                                        {{ Form::hidden('_method', 'DELETE') }}
                                        {!! Form::submit('Delete', array("class"=>"btn btn-info pull-right sc_del_from_index", "style"=>"margin-left:25px;margin-top:-30px;")) !!}
                                        {!! Form::close() !!}
                                    @else
                                        <i class="fa fa-times fa-2x light-blue"></i>
                                        <i class="fa fa-times fa-2x margin-left-12 light-blue"></i>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                @else
                    <span class="text-warning"><h5>No results found.</h5></span>
                @endif
            </div>
            <div style="text-align: center">
                {{$subCategoriesData->render()}}
            </div>
        </div>
    </div>
</div>
@stop

@section('footer_scripts')
    <script>
        $(".sc_del_from_index").click(function(){
            return confirm("Are you sure to delete this item?");
        });

    </script>

    <style>
        .table > tbody > tr:nth-child(2n+1) > td, .table > tbody > tr:nth-child(2n+1) > th {
            background-color: #f9f9f9;
        }
        table, tr, td {
            font-size: 13px;
        }

        .pagination{margin: 0; margin-bottom: 10px;}
        thead{ background-color: #d9edf7}

    </style>
@stop


