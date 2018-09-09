
<div class="panel panel-info">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-12">
                <h3 class="panel-title bariol-thin">Branches</h3>
            </div>
        </div>
    </div>
    <div class="panel-body">
      <div class="row">
          <div class="col-md-12">
              <div style="text-align: center">
                  {{$branchData->render()}}
              </div>
              @if(! $branchData->isEmpty() )
              <table class="table table-bordered table-inverse">
                      <thead>
                          <tr>
                              <th>B-name</th>
                              <th>B-code</th>
                              <th>Status</th>
                              <th>B-address</th>
                              <th>B-phone</th>
                              <th>Operations</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($branchData as $branch)
                          <tr>
                              @if(isset($branch->name))
                                  <td>{!! $branch->name !!}</td>
                              @else
                                  <td></td>
                              @endif
                              @if(isset($branch->code))
                                  <td>{!! $branch->code !!}</td>
                              @else
                                  <td></td>
                              @endif
                              @if(isset($branch->active))
                                  @if($branch->active == $active[0]['key'])
                                      <td>{!! $active[0]['value'] !!}</td>
                                  @elseif($branch->active == $active[1]['key'])
                                      <td>{!! $active[1]['value'] !!}</td>
                                  @endif
                              @else
                                  <td> </td>
                              @endif
                              @if(isset($branch->address))
                                  <td>{!! $branch->address !!}</td>
                              @else
                                  <td></td>
                              @endif
                              @if(isset($branch->phone))
                                  <td>{!! $branch->phone !!}</td>
                              @else
                                  <td></td>
                              @endif
                              <td>
                                  @if( $branch->id)

                                      <a href="{!! URL::route('branch.edit', ['id' => $branch->id]) !!}"><i class="fa fa-pencil-square-o fa-2x"></i></a>

                                      {!! Form::model($branch, [ 'url' => URL::route('branch.destroy', ['id' => $branch->id])] )  !!}
                                      {{ Form::hidden('_method', 'DELETE') }}
                                      {!! Form::submit('Delete', array("class"=>"btn btn-info pull-right delete", "style"=>"margin-left:15px;margin-top:-30px;")) !!}
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
              {{$branchData->render()}}
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