
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title bariol-thin"> Products </h3>
    </div>
    <div class="panel-body">
      <div class="row">
          <div class="col-md-12">

              @if(count($productSearchData) > 0)
                  <table class="table table-bordered table-inverse" style="font-size: 12px">
                      <thead>
                      <tr>
                          <th>Product ID</th>
                          <th>C-name</th>
                          <th>Name</th>
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
                      @foreach($productSearchData as $product)
                          @if($product->active == 0)
                              <tr id="process_block" style="background-color: rgba(205, 205, 205, 0.58); color: #000000;">

                                  @if(isset($product->id))
                                      <td style="text-align: center">{!! $product->id !!}</td>
                                  @else
                                      <td > </td>
                                  @endif
                                  @if(isset($product->category->name))
                                      <td >{!! $product->category->name !!}</td>
                                  @else
                                      <td > </td>
                                  @endif
                                  @if(isset($product->name))
                                      <td >{!! $product->name !!}</td>
                                  @else
                                      <td > </td>
                                  @endif
                                  @if(isset($product->weight))
                                      <td style="text-align: center">{!! $product->weight !!}</td>
                                  @else
                                      <td > </td>
                                  @endif
                                  @if(isset($product->flavors->first()->name))
                                      <td >{!! $product->flavors->first()->name!!}</td>
                                  @else
                                      <td > </td>
                                  @endif
                                  @if(isset($product->price))
                                      <td style="text-align: center">{!! $product->price !!}</td>
                                  @else
                                      <td > </td>
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
                                      <td > </td>
                                  @endif
                                  @if(isset($product->min_age))
                                      <td style="text-align: center">{!! $product->min_age !!}</td>
                                  @else
                                      <td > </td>
                                  @endif
                                  @if(isset($product->tag))
                                      <td >{!! $product->tag !!}</td>
                                  @else
                                      <td > </td>
                                  @endif

                                  @if(isset($product->image))
                                      <td>
                                          <img style="width: 50px; height: 50px;" src="{{ asset('assets/images/usersImages/product/'.$product->image ) }}"  style="width: 50px; height: 50px;"/>
                                      </td>
                                  @else
                                      <td > </td>
                                  @endif


                                  <td>
                                      @if( $product->id)

                                          <a href="{!! URL::route('products.edit', ['id' => $product->id]) !!}"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                          {!! Form::model($product, [ 'url' => URL::route('products.destroy', ['id' => $product->id])] )  !!}
                                          {{ Form::hidden('_method', 'DELETE') }}

                                          {{--Form for dlete request--}}
                                          {!! Form::submit('Delete', array("class"=>"btn btn-info pull-right p_del_from_index ", "style"=>"margin-left:30px;margin-top:-30px;")) !!}
                                          {!! Form::close() !!}
                                      @else
                                          <i class="fa fa-times fa-2x light-blue"></i>
                                          <i class="fa fa-times fa-2x margin-left-12 light-blue"></i>
                                      @endif
                                  </td>
                              </tr>
                          @else
                              <tr>
                                  @if(isset($product->id))
                                      <td style="text-align: center">{!! $product->id !!}</td>
                                  @else
                                      <td > </td>
                                  @endif
                                  @if(isset($product->category->name))
                                      <td >{!! $product->category->name !!}</td>
                                  @else
                                      <td > </td>
                                  @endif
                                  @if(isset($product->name))
                                      <td >{!! $product->name !!}</td>
                                  @else
                                      <td > </td>
                                  @endif
                                  @if(isset($product->weight))
                                      <td style="text-align: center">{!! $product->weight !!}</td>
                                  @else
                                      <td > </td>
                                  @endif
                                  @if(isset($product->flavors->first()->name))
                                      <td >{!! $product->flavors->first()->name!!}</td>
                                  @else
                                      <td > </td>
                                  @endif
                                  @if(isset($product->price))
                                      <td style="text-align: center">{!! $product->price !!}</td>
                                  @else
                                      <td > </td>
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
                                      <td > </td>
                                  @endif
                                  @if(isset($product->min_age))
                                      <td style="text-align: center">{!! $product->min_age !!}</td>
                                  @else
                                      <td > </td>
                                  @endif
                                  @if(isset($product->tag))
                                      <td >{!! $product->tag !!}</td>
                                  @else
                                      <td > </td>
                                  @endif
                                  @if(isset($product->image))
                                      <td>
                                          <img style="width: 50px; height: 50px;" src="{{ asset('assets/images/usersImages/product/'.$product->image ) }}"  style="width: 50px; height: 50px;"/>
                                      </td>
                                  @else
                                      <td > </td>
                                  @endif

                                  <td>
                                      @if( $product->id)

                                          <a href="{!! URL::route('products.edit', ['id' => $product->id]) !!}"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                          {!! Form::model($product, [ 'url' => URL::route('products.destroy', ['id' => $product->id])] )  !!}
                                          {{ Form::hidden('_method', 'DELETE') }}

                                          {{--Form for dlete request--}}
                                          {!! Form::submit('Delete', array("class"=>"btn btn-info pull-right p_del_from_index ", "style"=>"margin-left:30px;margin-top:-30px;")) !!}
                                          {!! Form::close() !!}
                                      @else
                                          <i class="fa fa-times fa-2x light-blue"></i>
                                          <i class="fa fa-times fa-2x margin-left-12 light-blue"></i>
                                      @endif
                                  </td>
                              </tr>
                          @endif
                      </tbody>
                      @endforeach
                  </table>
              @elseif(count($productsData) > 0)
                  <div style="text-align: center">
                      @if($productsData->render())
                          {{$productsData->render()}}
                      @endif
                  </div>
                  <table class="table table-bordered table-inverse" style="font-size: 12px">
                      <thead>
                      <tr>
                          <th>Product ID</th>
                          <th>C-name</th>
                          <th>Name</th>
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
                      @foreach($productsData as $product)
                          @if($product->active == 0)
                              <tr id="process_block" style="background-color: rgba(205, 205, 205, 0.58); color: #000000;">

                                  @if(isset($product->id))
                                      <td style="text-align: center">{!! $product->id !!}</td>
                                  @else
                                      <td > </td>
                                  @endif
                                  @if(isset($product->category->name))
                                      <td >{!! $product->category->name !!}</td>
                                  @else
                                      <td > </td>
                                  @endif
                                  @if(isset($product->name))
                                      <td >{!! $product->name !!}</td>
                                  @else
                                      <td > </td>
                                  @endif
                                  @if(isset($product->weight))
                                      <td style="text-align: center">{!! $product->weight !!}</td>
                                  @else
                                      <td > </td>
                                  @endif
                                  @if(isset($product->flavors->first()->name))
                                      <td >{!! $product->flavors->first()->name!!}</td>
                                  @else
                                      <td > </td>
                                  @endif
                                  @if(isset($product->price))
                                      <td style="text-align: center">{!! $product->price !!}</td>
                                  @else
                                      <td > </td>
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
                                      <td > </td>
                                  @endif
                                  @if(isset($product->min_age))
                                      <td style="text-align: center">{!! $product->min_age !!}</td>
                                  @else
                                      <td > </td>
                                  @endif
                                  @if(isset($product->tag))
                                      <td >{!! $product->tag !!}</td>
                                  @else
                                      <td > </td>
                                  @endif

                                  @if(isset($product->image))
                                      <td>
                                          <img style="width: 50px; height: 50px;" src="{{ asset('assets/images/usersImages/product/'.$product->image ) }}"  style="width: 50px; height: 50px;"/>
                                      </td>
                                  @else
                                      <td > </td>
                                  @endif


                                  <td>
                                      @if( $product->id)

                                          <a href="{!! URL::route('products.edit', ['id' => $product->id]) !!}"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                          {!! Form::model($product, [ 'url' => URL::route('products.destroy', ['id' => $product->id])] )  !!}
                                          {{ Form::hidden('_method', 'DELETE') }}

                                          {{--Form for dlete request--}}
                                          {!! Form::submit('Delete', array("class"=>"btn btn-info pull-right p_del_from_index ", "style"=>"margin-left:30px;margin-top:-30px;")) !!}
                                          {!! Form::close() !!}
                                      @else
                                          <i class="fa fa-times fa-2x light-blue"></i>
                                          <i class="fa fa-times fa-2x margin-left-12 light-blue"></i>
                                      @endif
                                  </td>
                              </tr>
                          @else
                              <tr>
                                  @if(isset($product->id))
                                      <td style="text-align: center">{!! $product->id !!}</td>
                                  @else
                                      <td > </td>
                                  @endif
                                  @if(isset($product->category->name))
                                      <td >{!! $product->category->name !!}</td>
                                  @else
                                      <td > </td>
                                  @endif
                                  @if(isset($product->name))
                                      <td >{!! $product->name !!}</td>
                                  @else
                                      <td > </td>
                                  @endif
                                  @if(isset($product->weight))
                                      <td style="text-align: center">{!! $product->weight !!}</td>
                                  @else
                                      <td > </td>
                                  @endif
                                  @if(isset($product->flavors->first()->name))
                                      <td >{!! $product->flavors->first()->name!!}</td>
                                  @else
                                      <td > </td>
                                  @endif
                                  @if(isset($product->price))
                                      <td style="text-align: center">{!! $product->price !!}</td>
                                  @else
                                      <td > </td>
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
                                      <td > </td>
                                  @endif
                                  @if(isset($product->min_age))
                                      <td style="text-align: center">{!! $product->min_age !!}</td>
                                  @else
                                      <td > </td>
                                  @endif
                                  @if(isset($product->tag))
                                      <td >{!! $product->tag !!}</td>
                                  @else
                                      <td > </td>
                                  @endif
                                  @if(isset($product->image))
                                      <td>
                                          <img style="width: 50px; height: 50px;" src="{{ asset('assets/images/usersImages/product/'.$product->image ) }}"  style="width: 50px; height: 50px;"/>
                                      </td>
                                  @else
                                      <td > </td>
                                  @endif

                                  <td>
                                      @if( $product->id)

                                          <a href="{!! URL::route('products.edit', ['id' => $product->id]) !!}"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                          {!! Form::model($product, [ 'url' => URL::route('products.destroy', ['id' => $product->id])] )  !!}
                                          {{ Form::hidden('_method', 'DELETE') }}

                                          {{--Form for dlete request--}}
                                          {!! Form::submit('Delete', array("class"=>"btn btn-info pull-right p_del_from_index ", "style"=>"margin-left:30px;margin-top:-30px;")) !!}
                                          {!! Form::close() !!}
                                      @else
                                          <i class="fa fa-times fa-2x light-blue"></i>
                                          <i class="fa fa-times fa-2x margin-left-12 light-blue"></i>
                                      @endif
                                  </td>
                              </tr>
                          @endif
                      </tbody>
                      @endforeach
                  </table>
                  <div style="text-align: center">
                      @if($productsData->render())
                          {{$productsData->render()}}
                      @endif
                  </div>
              @else
                  <span class="text-warning"><h5>No results found.</h5></span>
              @endif

          </div>
      </div>
    </div>
</div>

<style>
    .pagination{margin: 0; margin-bottom: 10px;}
    thead{ background-color: #d9edf7}
</style>