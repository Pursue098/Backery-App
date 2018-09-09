<!DOCTYPE html>
<html lang="en" ng-app="client-app">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>.*. Tehzeeb Cake App .*. single</title>
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,300italic,300,600,700,800' rel='stylesheet' type='text/css'>

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Bootstrap Core CSS -->
    <link href="{{  asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{  asset('assets/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" />
    <link href="{{  asset('assets/css/shop-homepage.css') }}" rel="stylesheet">
    <link href="{{  asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{  asset('assets/css/style_third.css') }}" rel="stylesheet">
{{--    <link href="{{  asset('assets/css/style1.css') }}" rel="stylesheet">--}}
    <link href="{{  asset('assets/css/angular-bootstrap-lightbox.css') }}" rel="stylesheet">
    <link href="{{  asset('assets/css/portfolio-item.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{  asset('assets/css/angular-material.css') }}" />

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

</head>

<body ng-controller="clientController as ctrl" id="body-element" >

<div id="view" ng-view></div>

<script src="{{  asset('assets/js/jquery-1.9.1.min.js') }}"></script>
<script src="{{  asset('assets/js/jquery-ui.min.js') }}"></script>
<script src="{{  asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{  asset('assets/js/angular-1.5.8/angular.min.js') }}"></script>
<script src="{{  asset('assets/js/angular-1.5.8/angular-touch.js') }}"></script>
<script src="{{  asset('assets/js/angular-1.5.8/angular-aria.js') }}"></script>
<script src="{{  asset('assets/js/angular-1.5.8/angular-animate.min.js') }}"></script>
<script src="{{  asset('assets/js/angular-1.5.8/angular-messages.min.js') }}"></script>
<script src="{{  asset('assets/js/angular-1.5.8/angular-message-format.min.js') }}"></script>
<script src="{{  asset('assets/js/angular-1.5.8/angular-resource.min.js') }}"></script>
<script src="{{  asset('assets/js/angular-1.5.8/angular-route.min.js') }}"></script>
<script src="{{  asset('assets/js/angular-1.5.8/angular-sanitize.min.js') }}"></script>

<script src="{{  asset('assets/js/ui-bootstrap-tpls-2.2.0.min.js') }}"></script>
<script src="{{  asset('assets/js/sticky_footer.js') }}"></script>

<script src="https://ajax.googleapis.com/ajax/libs/angular_material/1.0.5/angular-material.min.js"></script>

{{--<script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-1.2.1.js"></script>--}}

<script src="{{  asset('assets/js/ui-bootstrap-tpls-2.3.0.min.js') }}"></script>

<script type="text/javascript" src="{{  asset('assets/bower_components/moment/min/moment.min.js') }}"></script>
<script type="text/javascript" src="{{  asset('assets/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{  asset('assets/js/angular-bootstrap-lightbox.js') }}"></script>


<script src="{{  asset('/app/route.js') }}"></script>
<script src="{{  asset('/app/controller/clientController.js') }}"></script>

<style>
    .full button span {
        background-color: limegreen;
        border-radius: 32px;
        color: black;
    }
    .partially button span {
        background-color: orange;
        border-radius: 32px;
        color: black;
    }

    .input-group-btn:last-child>.btn, .input-group-btn:last-child>.btn-group{
        z-index: 1;
        margin-left: 0;
    }

    .uib-datepicker-popup.dropdown-menu{
        z-index: 0;
        top: 0;
    }
</style>
<script type="text/javascript">

    $(document).ready(function () {


        $(document).on('click', '.singleViewIcon', function () {
            var get = $(this).find(".carousalHoverImage");
            $(get.selector).hide();

        }).on('mouseenter', '.carousel-caption', function () {
            $(this).find(".carousalHoverImage").show();
        }).on('mouseleave', '.carousel-caption', function () {
            $(this).find(".carousalHoverImage").hide();
        });


        $(document).on('keydown', '.ingredients', function () {

            $(".advance_error_message").hide();

            var get = $(this).find("#custom-price");
            if(get.val() != null){
                var input_value = Number(get.val());

                $('.product_hidden_price').val(input_value);
                $(this).data("oldPriceCustom", input_value);
            }

        }).on('keyup', '.ingredients', function () {

            $(".advance_error_message").hide();

            var get = $(this).find("#custom-price");
            var zero_value = 0;
            var one_value = 1;

            if(get.val() != null){
                var input_value = Number(get.val());

                $('.product_hidden_price').val(input_value);
                $(".advance_price").prop('disabled', false);

                var oldPriceCustom = $(this).data("oldPriceCustom");
                var oldPriceCustom = Number(oldPriceCustom);

                console.log('oldPriceCustom: ', oldPriceCustom, '$(this).val(): ', get.val());

                if (parseInt(input_value) != oldPriceCustom) {

                    $('.product_price').val(zero_value);
                    $('.advance_price').val(zero_value);
                    $('.weight').val(zero_value);
                    $('.quantity').val(one_value);
                    $('.total_price').val(get.val());
                    $('.total_blance').val(get.val());
                }
            }
        });


    });

</script>
</body>
</html>



































