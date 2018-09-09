
<div class="panel panel-info">
    <div class="panel-heading">
        <p> Configuration Section</p>
    </div>
    <div class="panel-body">
      <div class="row">
          <div class="col-md-12">
              @if(! $configData->isEmpty() )
                  <div class="col-md-3">
                      <table class="table table-bordered table-inverse">
                          <thead>
                          <tr>
                              <th>Priority</th>
                              <th>Operations</th>
                          </tr>
                          </thead>
                          <tbody>
                          @foreach($configData as $priority)
                              <tr>
                                @if(isset($priority->key) && $priority->key == 'priority_value')
                                      <td>{!! $priority->value !!}</td>
                                      <td>
                                          @if( $priority->id)

                                            <a href="{!! URL::route('configuration.edit', ['id' => $priority->id ]) !!}"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                            <a href="{!! URL::route('configuration.delete', ['id' => $priority->id]) !!}"><i class="fa fa-trash-o fa-2x"></i></a>
                                            <a href="{!! URL::route('configuration.create') !!}"><i class="fa fa-plus-circle fa-2x"></i></a>

                                          @else
                                              <i class="fa fa-times fa-2x light-blue"></i>
                                              <i class="fa fa-times fa-2x margin-left-12 light-blue"></i>
                                          @endif
                                      </td>
                                @endif
                              </tr>
                          </tbody>
                          @endforeach
                      </table>

                  </div>
                  <div class="col-md-3">
                      <table class="table table-bordered table-inverse">
                          <thead>
                          <tr>
                              <th>Active</th>
                              <th>Operations</th>
                          </tr>
                          </thead>
                          <tbody>
                          @foreach($configData as $active)
                              <tr>
                                  @if(isset($active->key) && $active->key == 'active_value')
                                      <td>{!! $active->value !!}</td>
                                      <td>
                                          @if( $active->id)

                                              <a href="{!! URL::route('configuration.edit', ['id' => $active->id ]) !!}"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                              <a href="{!! URL::route('configuration.delete', ['id' => $active->id]) !!}"><i class="fa fa-trash-o fa-2x"></i></a>
                                              <a href="{!! URL::route('configuration.create') !!}"><i class="fa fa-plus-circle fa-2x"></i></a>

                                          @else
                                              <i class="fa fa-times fa-2x light-blue"></i>
                                              <i class="fa fa-times fa-2x margin-left-12 light-blue"></i>
                                          @endif
                                      </td>
                                  @endif
                              </tr>
                          </tbody>
                          @endforeach
                      </table>

                  </div>
                  <div class="col-md-3">
                      <table class="table table-bordered table-inverse">
                          <thead>
                          <tr>
                              <th>Order Type</th>
                              <th>Operations</th>
                          </tr>
                          </thead>
                          <tbody>
                          @foreach($configData as $orderType)
                              <tr>
                                  @if(isset($orderType->key) && $orderType->key == 'order_type_value')
                                      <td>{!! $orderType->value !!}</td>
                                      <td>
                                          @if( $orderType->id)

                                              <a href="{!! URL::route('configuration.edit', ['id' => $orderType->id ]) !!}"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                              <a href="{!! URL::route('configuration.delete', ['id' => $orderType->id]) !!}"><i class="fa fa-trash-o fa-2x"></i></a>
                                              <a href="{!! URL::route('configuration.create') !!}"><i class="fa fa-plus-circle fa-2x"></i></a>

                                              {{--{!! Form::model($configData, [ 'url' => URL::route('configuration.destroy', ['id' => $orderType->id])] )  !!}--}}
                                              {{--{{ Form::hidden('_method', 'DELETE') }}--}}
                                              {{--{!! Form::submit('Delete', array("class"=>"btn btn-danger pull-right", "style"=>" margin-right:10px; margin-left:25px; margin-top:-30px;")) !!}--}}
                                              {{--{!! Form::close() !!}--}}
                                          @else
                                              <i class="fa fa-times fa-2x light-blue"></i>
                                              <i class="fa fa-times fa-2x margin-left-12 light-blue"></i>
                                          @endif
                                      </td>
                                  @endif
                              </tr>
                          </tbody>
                          @endforeach
                      </table>

                  </div>
                  <div class="col-md-3">
                      <table class="table table-bordered table-inverse">
                          <thead>
                          <tr>
                              <th>Order Status</th>
                              <th>Operations</th>
                          </tr>
                          </thead>
                          <tbody>
                          @foreach($configData as $orderStatus)
                              <tr>
                                  @if(isset($orderStatus->key) && $orderStatus->key == 'order_status_value')
                                      <td>{!! $orderStatus->value !!}</td>
                                      <td>
                                          @if( $orderStatus->id)

                                              <a href="{!! URL::route('configuration.edit', ['id' => $orderStatus->id ]) !!}"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                              <a href="{!! URL::route('configuration.delete', ['id' => $orderStatus->id]) !!}"><i class="fa fa-trash-o fa-2x"></i></a>
                                              <a href="{!! URL::route('configuration.create') !!}"><i class="fa fa-plus-circle fa-2x"></i></a>

                                          @else
                                              <i class="fa fa-times fa-2x light-blue"></i>
                                              <i class="fa fa-times fa-2x margin-left-12 light-blue"></i>
                                          @endif
                                      </td>
                                  @endif
                              </tr>
                          </tbody>
                          @endforeach
                      </table>

                  </div>
              @else
                  <span class="text-warning"><h5>No results found.</h5></span>
              @endif
          </div>
      </div>
      <div class="row">
          <div class="col-md-12">
              @if(! $configData->isEmpty() )
                  <div class="col-md-3">
                      <table class="table table-bordered table-inverse">
                          <thead>
                          <tr>
                              <th>Payment Type</th>
                              <th>Operations</th>
                          </tr>
                          </thead>
                          <tbody>
                          @foreach($configData as $paymentType)
                              <tr>
                                  @if(isset($paymentType->key) && $paymentType->key == 'payment_type_value')
                                      <td>{!! $paymentType->value !!}</td>
                                      <td>
                                          @if( $paymentType->id)

                                              <a href="{!! URL::route('configuration.edit', ['id' => $paymentType->id ]) !!}"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                              <a href="{!! URL::route('configuration.delete', ['id' => $paymentType->id]) !!}"><i class="fa fa-trash-o fa-2x"></i></a>
                                              <a href="{!! URL::route('configuration.create') !!}"><i class="fa fa-plus-circle fa-2x"></i></a>

                                          @else
                                              <i class="fa fa-times fa-2x light-blue"></i>
                                              <i class="fa fa-times fa-2x margin-left-12 light-blue"></i>
                                          @endif
                                      </td>
                                  @endif
                              </tr>
                          </tbody>
                          @endforeach
                      </table>

                  </div>
                  <div class="col-md-3">
                      <table class="table table-bordered table-inverse">
                          <thead>
                          <tr>
                              <th>Payment Status</th>
                              <th>Operations</th>
                          </tr>
                          </thead>
                          <tbody>
                          @foreach($configData as $paymentStatus)
                              <tr>
                                @if(isset($paymentStatus->key) && $paymentStatus->key == 'payment_status_value')
                                      <td>{!! $paymentStatus->value !!}</td>
                                      <td>
                                          @if( $paymentStatus->id)

                                            <a href="{!! URL::route('configuration.edit', ['id' => $paymentStatus->id ]) !!}"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                            <a href="{!! URL::route('configuration.delete', ['id' => $paymentStatus->id]) !!}"><i class="fa fa-trash-o fa-2x"></i></a>
                                            <a href="{!! URL::route('configuration.create') !!}"><i class="fa fa-plus-circle fa-2x"></i></a>

                                          @else
                                              <i class="fa fa-times fa-2x light-blue"></i>
                                              <i class="fa fa-times fa-2x margin-left-12 light-blue"></i>
                                          @endif
                                      </td>
                                @endif
                              </tr>
                          </tbody>
                          @endforeach
                      </table>

                  </div>
                  <div class="col-md-3">
                      <table class="table table-bordered table-inverse">
                          <thead>
                          <tr>
                              <th>Branch</th>
                              <th>Operations</th>
                          </tr>
                          </thead>
                          <tbody>
                          @foreach($configData as $branch)
                              <tr>
                                  @if(isset($branch->key) && $branch->key == 'branch_name')
                                      <td>{!! $branch->value !!}</td>
                                      <td>
                                          @if( $branch->id)

                                              <a href="{!! URL::route('configuration.edit', ['id' => $branch->id ]) !!}"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                              <a href="{!! URL::route('configuration.delete', ['id' => $branch->id]) !!}"><i class="fa fa-trash-o fa-2x"></i></a>
                                              <a href="{!! URL::route('configuration.create') !!}"><i class="fa fa-plus-circle fa-2x"></i></a>
                                          @else
                                              <i class="fa fa-times fa-2x light-blue"></i>
                                              <i class="fa fa-times fa-2x margin-left-12 light-blue"></i>
                                          @endif
                                      </td>
                                  @endif
                              </tr>
                          </tbody>
                          @endforeach
                      </table>
                  </div>
              @else
                  <span class="text-warning"><h5>No results found.</h5></span>
              @endif
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