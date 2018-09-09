<h3 class="bariol-thin"><i class="fa fa-search"></i> Search Order</h3>
{!! Form::model('order', [ 'url' => URL::route('v1.employee.order.search')] )  !!}
{{ Form::hidden('_method', 'POST') }}

<div class="form-group row">
    {!! Form::label('order_no','Search By: ', ['class'=>"col-xs-2 col-form-label", 'for'=>"text-input-product"]) !!}
    <div class="col-xs-7">
        {!! Form::text('employee_order_search', null, ['style'=>'border:1px solid gray;border-radius: 0;', 'class' => 'form-control', 'id' => 'text-input-product', 'placeholder' => 'Order No or Product Name']) !!}
    </div>
</div>
<span class="text-danger">{!! $errors->first('order_no') !!}</span>

<a href="{!! URL::route('v1.employee.order.index') !!}" class="btn btn-default search-reset" style='margin-left: 18%; border-radius: 0'>All products</a>
{!! Form::submit('Search', ["class" => "btn btn-info", "id" => "search-submit", 'style'=>'border-radius: 0; margin-left:8px;']) !!}

{!! Form::close() !!}

<div class="form-group row">
    <div class="col-xs-12">
        <div class="col-xs-10" style="text-align: center;">
            <h3 style="text-align: center">Order Queue</h3>
        </div>
    </div>
    <div class="col-xs-2" style="float: right;">
        <select class="form-control order_status_id" style="border-radius: 0px">
            @if((isset($orderStatus_1) || isset($orderStatus)) && isset($order_status_key))
                @if(isset($orderStatus_1))

                    @foreach ($orderStatus_1 as $status)
                        @if ($status['key'] == $order_status_key)
                            <option selected value="{{ $status['key'] }}">{{ $status['value'] }}</option>
                        @else
                            <option value="{{ $status['key'] }}">{{ $status['value'] }}</option>
                        @endif
                    @endforeach

                @else

                    @foreach ($orderStatus as $status)
                        @if ($status['key'] == $order_status_key)
                            <option selected value="{{ $status['key'] }}">{{ $status['value'] }}</option>
                        @else
                            <option value="{{ $status['key'] }}">{{ $status['value'] }}</option>
                        @endif
                    @endforeach

                @endif
            @elseif(isset($orderStatus))

                @foreach ($orderStatus as $status)
                    <option value="{{ $status['key'] }}">{{ $status['value'] }}</option>
                @endforeach

            @endif
        </select>
    </div>
    <div class="col-xs-2" style="float: right;">
        <select class="form-control priority" style="border-radius: 0px">
            @if(isset($priority_4))
                @foreach ($priority_4 as $priority)
                    @if ($priority['key'] == $priority_4_key)
                        <option selected value="{{ $priority['key'] }}">{{ $priority['value'] }}</option>
                    @else
                        <option value="{{ $priority['key'] }}">{{ $priority['value'] }}</option>
                    @endif
                @endforeach
            @endif
        </select>
    </div>

    <!-- Delivery date & time field -->
    <div class="col-xs-2" style="float: right;">
        <div class="form-group">
            <div class='input-group datepicker3'>
                {!! Form::text('delivery_date', null, ['id' => 'dates3','class' => 'form-control datepicker3',
                 'style' => 'border-radius: 0px']) !!}
                <span class="input-group-addon">
                <span class="glyphicon glyphicon-time"></span>
            </span>
            </div>
        </div>
    </div>
</div>

@section('footer_scripts')
    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.datepicker3').datetimepicker({
            format: 'YYYY-MM-DD',
            defaultDate: new Date(),
            //            disabledDates: ['2016-12-22', '2016-12-21'],
//            disabledDates: ["2016-12-22","2016-12-21","2016-12-20"],
//            disabledDates: [moment("2016-12-20"), moment("2016-12-21")]
//            disabledDates: [
////                moment("2016-12-22"),
////                "2016-12-22 00:53",
//                "2016-12-22", "2016-12-21", "2016-12-20"
//            ]
        });

        $(".datepicker3").on("dp.change", function(e) {

            var date = $('#dates3').val();
            var order_status_id = $('.order_status_id').val();
            var url = null;

            if(order_status_id && date){
                url = '{{env('APP_URL')}}'+'employee/v1/order_by_date/'+date+'?date='+date+'&order_status_id='+order_status_id;

            }else if(date){
                url = '{{env('APP_URL')}}'+'employee/v1/order_by_date/'+date+'?date='+date;

            }
            console.log('url:', url);

//            console.log('url: ', url); return;

            $.ajax({
                type: "GET",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
//                data:data,
                success: function(data) {

                    $( ".render-order-block" ).html(data);

                },
                error: function(data) {
                    console.log(data);
                    return;
                }
            },"json");

            return;
        });

        $('.priority').on('change', function(e){

            var priority = $('.priority').val();
            var order_status_id = $('.order_status_id').val();
            var url = null;

            if(order_status_id && priority){
                url = '{{env('APP_URL')}}'+'employee/v1/order_by_priority/'+priority+'?priority='+priority+'&order_status_id='+order_status_id;

            }else if(priority){
                url = '{{env('APP_URL')}}'+'employee/v1/order_by_priority/'+priority+'?priority='+priority;

            }
            console.log('url:', url);

//            console.log('url:', url); return;

            $.ajax({
                type: "GET",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
//                data:data,
                success: function(data) {

                    $( ".render-order-block" ).html(data);

                },
                error: function(data) {
                    console.log(data);
                    return;
                }
            },"json");

            return;
        });

        $('.order_status_id').on('change', function(e){

            var order_status = $('.order_status_id').val();
            var url = null;

            if(order_status){
                url = '{{env('APP_URL')}}'+'employee/v1/order/'+order_status+'?order_status='+order_status;

            }

            $.ajax({
                type: "GET",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
//                data:data,
                success: function(data) {

                    $( ".render-order-block" ).html(data);

                },
                error: function(data) {
                    console.log(data);
                    return;
                }
            },"json");

            return;
        });

        function changeStatus(value) {

            function getParameterByName(name, url) {
                if (!url) {
                    url = window.location.href;
                }
                name = name.replace(/[\[\]]/g, "\\$&");
                var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                        results = regex.exec(url);
                if (!results) return null;
                if (!results[2]) return '';
                return decodeURIComponent(results[2].replace(/\+/g, " "));
            }

            var page = getParameterByName('page');

            var order_id = value.id;
            var order_status = value.value;

            var url = null;

            if(order_status){
                url = '{{env('APP_URL')}}'+'employee/v1/change_order_status/'+order_status+'?order_status='+order_status+'&order_id='+order_id;

            }

            if(page) {

//                console.log('stop'); return;

                $.ajax({
                    type: "GET",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {

                        console.log(data)

                        $( ".render-order-block" ).html(data);

                    },
                    error: function(data) {
                        console.log(data);
                    }
                },"json");

                return;

            }else {

                $.ajax({
                    type: "GET",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {

                        console.log(data)

                        $( ".render-order-block" ).html(data);

                    },
                    error: function(data) {
                        console.log(data);
                    }
                },"json");

                return;

            }
        }

    </script>
@stop
