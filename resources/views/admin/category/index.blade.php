

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title bariol-thin"> Categories</h3>
    </div>
    <div class="panel-body">
      <div class="row">
          <div class="col-md-12">
              <div style="text-align: center">
                  {{$categoriesData->render()}}
              </div>
              @if(! $categoriesData->isEmpty() )
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

                      @foreach($categoriesData as $category)
                          <tr>

                                @if($category->hasChild($category->id) == true)
                                    <td>
                                        <a href="{!! URL::route('categories.listSubCategories', ['id' => $category->id]) !!}" style="text-align: center">
                                            {!! $category->name !!}
                                        </a>
                                    </td>
                                @elseif($category->hasChild($category->id) == false)
                                    <td>
                                        {!! $category->name !!}
                                    </td>
                                @endif
                                @if(isset($category->description))
                                    <td>{!! $category->description !!}</td>
                                @else
                                    <td> </td>
                                @endif
                                @if(isset($category->active))
                                    @if($category->active == $active[0]['key'])
                                        <td>{!! $active[0]['value'] !!}</td>
                                    @elseif($category->active == $active[1]['key'])
                                        <td>{!! $active[1]['value'] !!}</td>
                                    @endif
                                @else
                                    <td> </td>
                                @endif
                                @if(isset($category->image))
                                    <td>
                                        <img src="{{ asset('assets/images/usersImages/category/'.$category->image ) }}" style="width: 50px; height: 50px;"/>
                                    </td>
                                @else
                                    <td> </td>
                                @endif
                                @if(isset($category->created_at))
                                    <td>{!! $category->created_at !!}</td>
                                @else
                                    <td> </td>
                                @endif
                                @if(isset($category->updated_at))
                                    <td>{!! $category->updated_at !!}</td>
                                @else
                                    <td> </td>
                                @endif
                              <td>
                                  @if( $category->id)

                                      {{--Form for edit request--}}
                                      <a href="{!! URL::route('categories.edit', ['id' => $category->id]) !!}">
                                          <i class="fa fa-pencil-square-o fa-2x"></i>
                                      </a>

                                      {{--Form for delete request--}}
                                      {!! Form::model($category, [ 'url' => URL::route('categories.destroy', ['id' => $category->id])] )  !!}
                                      {{ Form::hidden('_method', 'DELETE') }}
                                      {!! Form::submit('Delete', array("class"=>"btn btn-info pull-right c_del_from_index", "style"=>" margin-right:10px; margin-left:25px; margin-top:-30px;")) !!}
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
              {{$categoriesData->render()}}
          </div>

      </div>
    </div>
</div>

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