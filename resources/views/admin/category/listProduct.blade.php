@extends('laravel-authentication-acl::admin.layouts.base-2cols')

@section('title')
    Admin area: category list
@stop

@section('content')
<div class="panel panel-info">
    <div class="panel-body">
      <div class="row">
          <div class="col-md-12">
              @if(! $products->isEmpty() )
              <table class="table table-bordered table-inverse">
                      <thead>
                          <tr>
                              <th>Category name</th>
                              <th>Product Name</th>
                              <th>Weight</th>
                              <th>Flavor</th>
                              <th>Price</th>
                              <th>Status</th>
                              <th>Max_age</th>
                              <th>Min_age</th>
                              <th>Tag</th>
                              <th>Image</th>
                              <th>Operations</th>
                          </tr>
                      </thead>
                      <tbody>
                          {{--@foreach($category as $cat)--}}
                          {{--<tr>--}}

                              @foreach($products as $product)
                              <tr>

                                  @if(isset($product->category->name))
                                      <td>{!! $product->category->name !!}</td>
                                  @else
                                      <td> </td>
                                  @endif
                                  @if(isset($product->name))
                                      <td>{!! $product->name !!}</td>
                                  @else
                                      <td> </td>
                                  @endif
                                  @if(isset($product->weight))
                                      <td style="text-align: center">{!! $product->weight !!}</td>
                                  @else
                                      <td> </td>
                                  @endif
                                  @if(isset($product->flavors()->first()->name))
                                      <td>{!! $product->flavors()->first()->name !!}</td>
                                  @else
                                      <td> </td>
                                  @endif
                                  @if(isset($product->price))
                                      <td style="text-align: center">{!! $product->price !!}</td>
                                  @else
                                      <td> </td>
                                  @endif
                                  @if(isset($product->active))
                                      @if($product->active == $active[0]['key'])
                                          <td>{!! $active[0]['value'] !!}</td>
                                      @elseif($product->active == $active[1]['key'])
                                          <td>{!! $active[1]['value'] !!}</td>
                                      @endif
                                  @else
                                      <td> </td>
                                  @endif
                                  @if(isset($product->max_age))
                                      <td style="text-align: center">{!! $product->max_age !!}</td>
                                  @else
                                      <td> </td>
                                  @endif
                                  @if(isset($product->min_age))
                                      <td style="text-align: center">{!! $product->min_age !!}</td>
                                  @else
                                      <td> </td>
                                  @endif
                                  @if(isset($product->tag))
                                      <td>{!! $product->tag !!}</td>
                                  @else
                                      <td> </td>
                                  @endif
                                  @if(isset($product->image))
                                      <td>
                                        <img style="width: 50px; height: 50px;" src="{{ asset('assets/images/usersImages/product/'.$product->image ) }}" />
                                      </td>
                                  @else
                                      <td> </td>
                                  @endif
                                  <td>
                                      @if( $product->id)

                                          <a href="{!! URL::route('products.edit', ['id' => $product->id]) !!}"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                          {!! Form::model($product, [ 'url' => URL::route('products.destroy', ['id' => $product->id])] )  !!}
                                          {{ Form::hidden('_method', 'DELETE') }}

                                          {{--Form for dlete request--}}
                                          {!! Form::submit('Delete', array("class"=>"btn btn-info pull-right ", "style"=>"margin-left:30px;margin-top:-30px;")) !!}
                                          {!! Form::close() !!}
                                      @else
                                          <i class="fa fa-times fa-2x light-blue"></i>
                                          <i class="fa fa-times fa-2x margin-left-12 light-blue"></i>
                                      @endif
                                  </td>
                              </tr>
                              {{--@endforeach--}}
                          {{--</tr>--}}
                      </tbody>
                      @endforeach
              </table>
              @else
                  <span class="text-warning"><h5>Haven't products.</h5></span>
              @endif
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
