{{--Search Area--}}
<h3 class="bariol-thin"><i class="fa fa-search"></i> Search Order</h3>
{!! Form::model('order', [ 'url' => URL::route('order.search'), 'style' => 'margin-bottom:10px'] )  !!}
{{ Form::hidden('_method', 'POST') }}
<div class="form-group row">
    {!! Form::label('order_no','Search By: ', ['class'=>"col-xs-2 col-form-label", 'for'=>"text-input-product"]) !!}
    <div class="col-xs-7">
        {!! Form::text('order_search', null, ['style'=>'border:1px solid gray;border-radius: 0;', 'class' => 'form-control', 'id' => 'text-input-product', 'placeholder' => 'Order No Or Customer name or Product name']) !!}
    </div>
</div>
<span class="text-danger">{!! $errors->first('order_no') !!}</span>


<a href="{!! URL::route('order.index') !!}" class="btn btn-default search-reset" style='margin-left: 17%; border-radius: 0'>All products</a>
{!! Form::submit('Search', ["class" => "btn btn-info", "id" => "search-submit", 'style'=>'border-radius: 0; margin-left:8px;']) !!}

{!! Form::close() !!}


<div class="form-group row">

    @if(isset($branches))
        {!! Form::open(array('route' => array('order.index'), 'class' => 'ajax', 'method' => 'GET')) !!}

            <div class="col-xs-2" style="float: right; margin-top: 7px; ">
                {!! Form::select('branch_id', $branches, null, ['class' => 'form-control branch_id', 'style' => '-webkit-border-radius: 0; -moz-border-radius: 0; border-radius: 0;']) !!}

                <input type="hidden" id="branch_hidden_id">
            </div>

        {{ Form::close() }}
    @endif

    @if(isset($orderStatus))
        {!! Form::open(array('route' => array('order.index'), 'class' => 'ajax', 'method' => 'GET')) !!}
        <div class="col-xs-2" style="float: right; margin-top: 7px; ">
            {!! Form::select('order_status', $orderStatus, null, ['class' => 'form-control order_status', 'style' => '-webkit-border-radius: 0; -moz-border-radius: 0; border-radius: 0;']) !!}
        </div>
        {{ Form::close() }}

    @endif

    <div class="col-xs-2" style="float: right; margin-top: 7px; ">
        <select class="form-control order_status" style="border-radius: 0px">
            @if((isset($orderStatus_4) || isset($orderStatus)) && isset($order_status_key))
                @if(isset($orderStatus_4))

                    @foreach ($orderStatus_4 as $status)
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

    <div class="col-xs-2" style="float: right; margin-top: 7px; ">
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

    {{--<div class="col-xs-2" style="float: right; margin-top: 7px; ">--}}
        {{--<select class="form-control dates" style="border-radius: 0px">--}}
            {{--@if(isset($dates))--}}
                {{--@foreach ($dates as $date)--}}
                    {{--<option selected value="{{ $date['day'] }}">{{ $date['day'] }}</option>--}}
                {{--@endforeach--}}
            {{--@endif--}}
        {{--</select>--}}
    {{--</div>--}}

    <!-- Delivery date & time field -->
        <div class="col-xs-2" style="float: right; margin-top: 7px; ">
            <div class="form-group">
                <div class='input-group datepicker1'>
                    {!! Form::text('delivery_date1', null, ['id' => 'dates1','class' => 'form-control datepicker1',
                     'style' => 'border-radius: 0px']) !!}
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span>
                    </span>
                </div>
            </div>
        </div>

    <div class="sidebar_items" style="float: right; margin-top: 7px; margin-left: 17px;">
        @if(isset($sidebar_items) && $sidebar_items)
            @foreach($sidebar_items as $name => $data)
                <a type="button" href="{!! $data['url'] !!}" class="{!! LaravelAcl\Library\Views\Helper::get_active($data['url']) !!} btn btn-default" style=" -webkit-border-radius: 0; -moz-border-radius: 0; border-radius: 0;">
                    {!! $data['icon'] !!}{{$name}}
                </a>
            @endforeach
        @endif
    </div>

</div>


@section('footer_scripts')
    <script>

        $(".OrderDelete").on("submit", function(){
            return confirm("Do you want to delete this item?");
        });


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $('.datepicker1').datetimepicker({
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

        $(".datepicker1").on("dp.change", function(e) {

            var date = $('#dates1').val();
            var branch_id = $('.branch_id').val();
            var url = null;

            if(branch_id){
                url = '{{env('APP_URL')}}'+'admin/order/order_by_date/'+date+'?date='+date+'&branch_id='+branch_id;

            }else{
                url = '{{env('APP_URL')}}'+'admin/order/order_by_date/'+date+'?date='+date;

            }

//            console.log('url: ', url); return;

            $.ajax({
                type: "GET",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
//                data:data,
                success: function(data) {

                    $( ".renderOrderData" ).html(data);

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
            var branch_id = $('.branch_id').val();
            var url = null;

            if(branch_id){
                url = '{{env('APP_URL')}}'+'admin/order/order_by_priority/'+priority+'?priority='+priority+'&branch_id='+branch_id;

            }else{
                url = '{{env('APP_URL')}}'+'admin/order/order_by_priority/'+priority+'?priority='+priority;

            }

//            console.log('url:', url); return;

            $.ajax({
                type: "GET",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
//                data:data,
                success: function(data) {

                    $( ".renderOrderData" ).html(data);

                },
                error: function(data) {
                    console.log(data);
                    return;
                }
            },"json");

            return;
        });


        $('.branch_id').on('change', function(e){

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
            var branch_id = $('.branch_id').val();
//            var order_status = $('.order_status').val();
            var order_status ;
            var url = null;

            if(order_status){
                url = '{{env('APP_URL')}}'+'admin/order/'+branch_id+'?branch_id='+branch_id+'&order_status='+order_status;

                console.log('order_status:', order_status);
            }else{
                url = '{{env('APP_URL')}}'+'admin/order/'+branch_id+'?branch_id='+branch_id;
                console.log('branch_id:');
            }

//            console.log('url:', url); return;

            if(page){
                $.ajax({
                        type: "GET",
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
//                        data:data,
                        success: function(data) {

                            $( ".renderOrderData" ).html(data);

                        },
                        error: function(data) {
                            console.log(data);
                            return;
                        }
                    },"json");

                return;
            }else{

                $.ajax({
                    type: "GET",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
//                    data:data,
                    success: function(data) {

                        $( ".renderOrderData" ).html(data);

                    },
                    error: function(data) {
                        console.log(data);
                        return;
                    }
                },"json");
            }

            return;
        });


        $('.order_status').on('change', function(e){

            var order_status = $('.order_status').val();
            var branch_id = $('.branch_id').val();
            var url = null;

            if(branch_id){
                url = '{{env('APP_URL')}}'+'admin/order/'+order_status+'?order_status='+order_status+'&branch_id='+branch_id;

            }else{
                url = '{{env('APP_URL')}}'+'admin/order/'+order_status+'?order_status='+order_status;

            }

//            console.log('url:', url); return;

            $.ajax({
                type: "GET",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
//                data:data,
                success: function(data) {

                    $( ".renderOrderData" ).html(data);

                },
                error: function(data) {
                    console.log(data);
                    return;
                }
            },"json");

            return;
        });

    </script>
@stop