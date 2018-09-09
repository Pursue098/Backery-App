
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title bariol-thin"> Flavors </h3>
    </div>
    <div class="panel-body">
      <div class="row">
          <div class="col-md-12">
              <div style="text-align: center">
                  {{$flavourData->render()}}
              </div>
              @if(! $flavourData->isEmpty() )
              <table class="table table-bordered table-inverse">
                      <thead>
                          <tr>
                              <th>Flavor Name</th>
                              <th>Status</th>
                              <th>Created at</th>
                              <th>Updated at</th>
                              <th>Operations</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($flavourData as $flavour)
                          <tr>
                              @if(isset($flavour->name))
                                  <td>{!! $flavour->name !!}</td>
                              @else
                                  <td> </td>
                              @endif
                              @if(isset($flavour->active))
                                  @if($flavour->active == $active[0]['key'])
                                      <td>{!! $active[0]['value'] !!}</td>
                                  @elseif($flavour->active == $active[1]['key'])
                                      <td>{!! $active[1]['value'] !!}</td>
                                  @endif
                              @else
                                  <td> </td>
                              @endif
                              @if(isset($flavour->created_at))
                                  <td>{!! $flavour->created_at !!}</td>
                              @else
                                  <td> </td>
                              @endif
                              @if(isset($flavour->updated_at))
                                  <td>{!! $flavour->updated_at !!}</td>
                              @else
                                  <td> </td>
                              @endif
                              <td>
                                  @if( $flavour->id)
                                      <a href="{!! URL::route('flavour.edit', ['id' => $flavour->id]) !!}"><i class="fa fa-pencil-square-o fa-2x"></i></a>

                                      {!! Form::model($flavour, [ 'url' => URL::route('flavour.destroy', ['id' => $flavour->id])] )  !!}
                                      {{ Form::hidden('_method', 'DELETE') }}
                                      {!! Form::submit('Delete', array("class"=>"btn btn-info pull-right delete",
                                       "style"=>"margin-left:15px;margin-top:-30px;")) !!}
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
              {{$flavourData->render()}}
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