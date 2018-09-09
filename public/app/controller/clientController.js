

app.constant('API_URL', 'client/v1/');

app.controller('clientController', function($scope, $log, $http, API_URL, $timeout, Lightbox) {

    $scope.imageBasePath = 'assets';

    $scope.subcategories = [];
    $scope.subcategories1 = [];
    $scope.category_products = [];
    $scope.product_images = [];
    $scope.breadcrumbs = [];
    $scope.breadcrumbs_module_item = [];

    $scope.categoiesFlag = false;
    $scope.sub_categoiesFlag = false;
    $scope.productFlag = false;
    $scope.productGridViewFlag = false;
    $scope.productSingleViewFlag = false;
    $scope.productPreviewFlag = false;
    $scope.orderFlag = false;
    $scope.customOrderFlag = false;
    $scope.thanxPageFlag = false;
    $scope.breadcrumbFlag = false;
    $scope.printDivFlag = false;
    $scope.productsSection = false;

    $scope.moduelName = '';

    $scope.order_id = '';
    $scope.token = '';
    $scope.cust_name = '';
    $scope.cust_phone = '';
    $scope.flavor = '';
    $scope.d_date = '';
    $scope.d_time = '';
    $scope.branch = '';
    $scope.remarks = '';
    $scope.price = '';
    $scope.advance_price = '';
    $scope.quantity = '';
    $scope.weight = '';
    $scope.total_price = 0;


    $scope.range = function(min, max, step) {
        step = step || 1;
        var input = [];
        for (var i = min; i <= max; i += step) {
            input.push(i);
        }
        return input;
    };

    ///////////////////////////////////
    //      Carousal                //
    //////////////////////////////////
    $scope.myInterval = 0;
    $scope.noWrapSlides = false;
    $scope.activeSlide = 0;



    ///////////////////////////////////
    //      Date picker             //
    //////////////////////////////////

    $scope.today = function() {
        $scope.dt = new Date();
        $('.order_delivery_date').val($scope.dt)
    };
    $scope.today();

    $scope.clear = function() {
        $scope.dt = null;
        $('.order_delivery_date').val($scope.dt)

    };

    $scope.inlineOptions = {
        customClass: getDayClass,
        minDate: new Date(),
        showWeeks: true
    };

    $scope.dateOptions = {
        dateDisabled: disabled,
        formatYear: 'yy',
        maxDate: new Date(2020, 5, 22),
        minDate: new Date(),
        startingDay: 1
    };

// Disable weekend selection
    function disabled(data) {
        var date = data.date,
            mode = data.mode;
        return mode === 'day' && (date.getDay() === 0 || date.getDay() === 6);
    }

    $scope.toggleMin = function() {
        $scope.inlineOptions.minDate = $scope.inlineOptions.minDate ? null : new Date();
        $scope.dateOptions.minDate = $scope.inlineOptions.minDate;
    };

    $scope.toggleMin();

    $scope.open1 = function() {
        $scope.popup1.opened = true;
    };

    $scope.open2 = function() {
        $scope.popup2.opened = true;
    };

    $scope.setDate = function(year, month, day) {
        $scope.dt = new Date(year, month, day);
    };

    $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
    $scope.format = $scope.formats[0];
    $scope.altInputFormats = ['M!/d!/yyyy'];

    $scope.popup1 = {
        opened: false
    };

    $scope.popup2 = {
        opened: false
    };

    var tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    var afterTomorrow = new Date();
    afterTomorrow.setDate(tomorrow.getDate() + 1);
    $scope.events = [
        {
            date: tomorrow,
            status: 'full'
        },
        {
            date: afterTomorrow,
            status: 'partially'
        }
    ];

    function getDayClass(data) {
        var date = data.date,
            mode = data.mode;
        if (mode === 'day') {
            var dayToCheck = new Date(date).setHours(0,0,0,0);

            for (var i = 0; i < $scope.events.length; i++) {
                var currentDay = new Date($scope.events[i].date).setHours(0,0,0,0);

                if (dayToCheck === currentDay) {
                    return $scope.events[i].status;
                }
            }
        }

        return '';
    }


    ///////////////////////////////////
    //      Time picker             //
    //////////////////////////////////


    $scope.mytime = new Date();

    $scope.hstep = 1;
    $scope.mstep = 1;
    $scope.minTime = 59;

    $scope.options = {
        hstep: [1, 2, 3],
        mstep: [1, 5, 10, 15, 25, 30]
    };

    $scope.ismeridian = true;
    $scope.toggleMode = function () {
        $scope.ismeridian = !$scope.ismeridian;
    };

    $scope.update = function () {
        var d = new Date();
        d.setHours(14);
        d.setMinutes(0);
        $scope.mytime = d;
    };

    $scope.changed = function () {

        $log.log('Time changed to: ' + $scope.mytime);
    };

    $scope.clear = function () {
        $scope.mytime = null;
    };

    ///////////////////////////////////
    //      Price formula           //
    //////////////////////////////////

    $scope.calculatePrice = function() {

        console.log('enter in calculatePrice formula');

        var weight, quantity, price, advance_price, totalPrice, input_price;

        $(".advance_error_message").hide();

        if($('.weight').val()){
            weight = $('.weight').val();
            weight = Number(weight);

            if($scope.products.weight){

                weight = weight - $scope.products.weight + 1;
                weight = Number(weight);
            }

        } else if( $('.weight').val() == ''){
            weight = 1;
            weight = Number(weight);

        }

        if($('.quantity').val()){
            quantity = $('.quantity').val();
            quantity = Number(quantity);

            if( !Number(quantity) ){
                quantity = 1;
                quantity = Number(quantity);

            }

        }

        if($('.total_price').val()){
            totalPrice = $('.total_price').val();
            totalPrice = Number(totalPrice);

        } else if( $('.total_price').val() == ''){
            totalPrice = 0;
            totalPrice = Number(totalPrice);

        }

        if($('.price').val()){
            input_price = $('.price').val();
            input_price = Number(input_price);

        } else if( $('.price').val() == ''){
            input_price = 0;
            input_price = Number(input_price);
            $(".price").prop('disabled', false);

        }

        var advance;

        $(".advance_price").keydown(function () {

            $(this).data("old", $(this).val());
            $('.advance_hidden_price').val($(this).val());
            $(".advance_error_message").hide();


        });
        $(".advance_price").keyup(function () {

            $(".advance_error_message").hide();


            if($('.price').val()){
                input_price = $('.price').val();
                input_price = Number(input_price);

            } else if( $('.price').val() == ''){
                input_price = 0;
                input_price = Number(input_price);

            }

            if (parseInt($(this).val()) <= input_price && parseInt($(this).val()) >= 0) {

                advance_price = $(this).val();
                advance_price = Number(advance_price);

                $(this).val(advance_price);

            }else{

                var old_price = $(this).data("old");
                old_price = Number(old_price);

                $(this).val(old_price);
                $('.advance_price').val(old_price);
                $('.advance_hidden_price').val(old_price);

                $(".advance_error_message").show();

                if(old_price >= input_price){
                    // $(".advance_price").prop('disabled', true);

                }
                if(advance_price > input_price){
                    // $(".advance_price").prop('disabled', false);

                }
            }
        });


        if($scope.products.price.length > 0){

            price = $scope.products.price;
            price = Number(price);
            console.log('enter in 1 price www: ', price);


        }else{
            price = 0;
            price = Number(price);

        }

        if (price > 0 && weight > 0 && quantity > 0){

            console.log('enter in 1 price: ', price);

            price = price * weight * quantity;
            price = Number(price);

            $('.price').val(price);
            $('.product_price').val(price);

            $scope.total_price = price;
            $scope.total_price = Number($scope.total_price);

            if($('.advance_price').val()){

                advance_price = $('.advance_price').val();
                advance_price = Number(advance_price);

            }else{
                advance_price = 0;
                advance_price = Number(advance_price);

            }

            if(advance_price > 0 && advance_price <= price){

                console.log('enter in 1 if advance_price: ', advance_price);

                $scope.total_price = $scope.total_price - advance_price;
                $scope.total_price = Number($scope.total_price);

                $('.total_price').val($scope.total_price);
                $('.total_blance').val($scope.total_price);
                // $(".advance_price").prop('disabled', false);

            } else if(advance_price > 0 && advance_price >= price){

                console.log('enter in 1 elseif advance_price: ', advance_price);

                var advance_price = $('.advance_hidden_price').val();
                advance_price = Number(advance_price);
                console.log('enter in 1 advance_hidden_price', advance_price);

                $scope.total_price = price - advance_price;
                $scope.total_price = Number($scope.total_price);

                $('.total_price').val($scope.total_price);
                $('.total_blance').val($scope.total_price);
                // $(".advance_price").prop('disabled', false);

                console.log('input_price', price);
            }
        }else if( input_price > 0 && weight > 0 && quantity > 0){

            console.log('enter in 2 input_price: ', input_price);

            input_price = input_price * weight * quantity;
            input_price = Number(input_price);

            $('.price').val(input_price);
            $('.product_price').val(input_price);

            $scope.total_price = input_price;
            $scope.total_price = Number($scope.total_price);

            if($('.advance_price').val()){

                advance_price = $('.advance_price').val();
                advance_price = Number(advance_price);

            }else{
                advance_price = 0;
                advance_price = Number(advance_price);
            }

            if(advance_price > 0 && advance_price <= input_price){

                $scope.total_price = $scope.total_price - advance_price;
                $scope.total_price = Number($scope.total_price);

                $('.total_price').val($scope.total_price);
                $('.total_blance').val($scope.total_price);
                // $(".advance_price").prop('disabled', false);

            } else if(advance_price > 0 && advance_price >= input_price){

                // $(".advance_price").prop('disabled', false);

                console.log('input_price', input_price);
            }
        }
    }

    $scope.calculatePriceCustomOrder = function() {

        $(".advance_error_message").hide();

        var weight, quantity, price, advance_price, totalPrice, input_price, first_price;

        if($('.weight').val()){
            weight = $('.weight').val();
            weight = Number(weight);

            if($scope.products.weight){

                weight = weight - $scope.products.weight + 1;
                weight = Number(weight);

            }

        }

        if($('.quantity').val()){
            quantity = $('.quantity').val();
            quantity = Number(quantity);

            if( !Number(quantity) ){
                quantity = 1;
                quantity = Number(quantity);

            }

        }

        if($('.price').val()){
            input_price = $('.price').val();
            input_price = Number(input_price);

        } else if( $('.price').val() == ''){
            input_price = 0;
            input_price = Number(input_price);

        }

        $(".advance_price").keydown(function () {

            $(this).data("oldCustom", $(this).val());
            $('.advance_hidden_price').val($(this).val());

            $(".advance_error_message").hide();

        });
        $(".advance_price").keyup(function () {

            $(".advance_error_message").hide();

            if($('.price').val()){
                input_price = $('.price').val();
                input_price = Number(input_price);

            } else if( $('.price').val() == ''){
                input_price = 0;
                input_price = Number(input_price);

            }

            if (parseInt($(this).val()) <= input_price && parseInt($(this).val()) >= 0) {

                advance_price = $(this).val();
                advance_price = Number(advance_price);

                $(this).val(advance_price);

            }else{

                console.log('111');

                var old_price = $(this).data("oldCustom");
                old_price = Number(old_price);

                $(this).val(old_price);
                $('.advance_price').val(old_price);
                $('.advance_hidden_price').val(old_price);

                if(old_price >= input_price){
                    // $(".advance_price").prop('disabled', true);
                    console.log('222');

                }
                if(advance_price > input_price){
                    // $(".advance_price").prop('disabled', false);

                }
            }
        });

        $(".advance_error_message").hide();

        if($('.advance_price').val()){

            advance_price = $('.advance_price').val();
            advance_price = Number(advance_price);

        }else{
            advance_price = 0;
            advance_price = Number(advance_price);

        }

        console.log('quantity', quantity);
        console.log('input_price', input_price);
        console.log('weight', weight);

        if (quantity > 0 && input_price > 0){

            if(weight > 0){

                console.log('enter in 1');

                if($('.product_hidden_price').val()){
                    first_price = $('.product_hidden_price').val();
                    first_price = Number(first_price);

                } else if( $('.product_hidden_price').val() == ''){
                    first_price = 0;
                    first_price = Number(first_price);

                }

                var input_price1 = first_price * weight * quantity;
                input_price1 = Number(input_price1);

                $('.price').val(input_price1);
                $('.product_price').val(input_price1);

                var price;
                if($('.price').val()){
                    price = $('.price').val();
                    price = Number(price);

                } else if( $('.price').val() == ''){
                    price = 0;
                    price = Number(price);

                }
                var advance_price;
                if($('.advance_price').val()){
                    advance_price = $('.advance_price').val();
                    advance_price = Number(advance_price);

                } else if( $('.advance_price').val() == ''){
                    advance_price = 0;
                    advance_price = Number(advance_price);

                }

                $scope.total_price = price;
                $scope.total_price = Number($scope.total_price);

                console.log('enter in 1 price', $scope.total_price);

                if(advance_price > 0 && advance_price <= price){

                    console.log('enter in 1 advance_price', advance_price);

                    $scope.total_price = $scope.total_price - advance_price;
                    $scope.total_price = Number($scope.total_price);

                    $('.total_price').val($scope.total_price);
                    $('.total_blance').val($scope.total_price);
                    // $(".advance_price").prop('disabled', false);

                } else if(advance_price > 0 && advance_price > price){

                    var advance_price = $('.advance_hidden_price').val();
                    advance_price = Number(advance_price);
                    console.log('enter in 1 advance_hidden_price', advance_price);

                    $scope.total_price = price - advance_price;
                    $scope.total_price = Number($scope.total_price);

                    $('.total_price').val($scope.total_price);
                    $('.total_blance').val($scope.total_price);
                    // $(".advance_price").prop('disabled', false);

                } else{

                    console.log('enter in 1 if if else');

                    var input_price1 = first_price * weight * quantity;
                    input_price1 = Number(input_price1);

                    $('.total_price').val(input_price1);
                    $('.total_blance').val(input_price1);
                    // $(".advance_price").prop('disabled', false);

                }

            }
            else{
                console.log('enter in 2');

                if($('.product_hidden_price').val()){
                    first_price = $('.product_hidden_price').val();
                    first_price = Number(first_price);

                } else if( $('.product_hidden_price').val() == ''){
                    first_price = 0;
                    first_price = Number(first_price);

                }

                var  input_price1 = first_price * quantity;
                input_price1 = Number(input_price1);

                $('.price').val(input_price1);
                $('.product_price').val(input_price1);


                var price;
                if($('.price').val()){
                    price = $('.price').val();
                    price = Number(price);

                } else if( $('.price').val() == ''){
                    price = 0;
                    price = Number(price);

                }
                var advance_price;
                if($('.advance_price').val()){
                    advance_price = $('.advance_price').val();
                    advance_price = Number(advance_price);

                } else if( $('.advance_price').val() == ''){
                    advance_price = 0;
                    advance_price = Number(advance_price);

                }

                $scope.total_price = price;
                $scope.total_price = Number($scope.total_price);


                console.log('enter in main else advance_price: ', advance_price, 'price: ', price);

                if(advance_price > 0 && advance_price <= price){


                    $scope.total_price = $scope.total_price - advance_price;
                    $scope.total_price = Number($scope.total_price);

                    console.log('enter in main else www', $scope.total_price);

                    $('.total_price').val($scope.total_price);
                    $('.total_blance').val($scope.total_price);
                    // $(".advance_price").prop('disabled', false);

                } else if(advance_price > 0 && advance_price > price){


                    var advance_price = $('.advance_hidden_price').val();
                    advance_price = Number(advance_price);

                    $scope.total_price = $scope.total_price - advance_price;
                    $scope.total_price = Number($scope.total_price);

                    console.log('enter in main else vvv', $scope.total_price, 'advance_price: ', advance_price);

                    $('.total_price').val($scope.total_price);
                    $('.total_blance').val($scope.total_price);
                    // $(".advance_price").prop('disabled', false);

                } else{

                    var  input_price1 = input_price * quantity;
                    input_price1 = Number(input_price1);

                    $('.total_price').val(input_price1);
                    $('.total_blance').val(input_price1);
                    // $(".advance_price").prop('disabled', false);

                }
            }
        }
        else if(weight > 0 && input_price > 0){

            if(quantity > 0){
                console.log('enter in 3');

                if($('.product_hidden_price').val()){
                    first_price = $('.product_hidden_price').val();
                    first_price = Number(first_price);

                } else if( $('.product_hidden_price').val() == ''){
                    first_price = 0;
                    first_price = Number(first_price);

                }

                var input_price1 = first_price * weight * quantity;
                input_price1 = Number(input_price1);

                $('.price').val(input_price1);
                $('.product_price').val(input_price1);

                var price;
                if($('.price').val()){
                    price = $('.price').val();
                    price = Number(price);

                } else if( $('.price').val() == ''){
                    price = 0;
                    price = Number(price);

                }
                var advance_price;
                if($('.advance_price').val()){
                    advance_price = $('.advance_price').val();
                    advance_price = Number(advance_price);

                } else if( $('.advance_price').val() == ''){
                    advance_price = 0;
                    advance_price = Number(advance_price);

                }

                $scope.total_price = price;
                $scope.total_price = Number($scope.total_price);


                if(advance_price > 0 && advance_price <= price){

                    console.log('enter in elseif 1 if if');

                    $scope.total_price = $scope.total_price - advance_price;
                    $scope.total_price = Number($scope.total_price);

                    $('.total_price').val($scope.total_price);
                    $('.total_blance').val($scope.total_price);
                    // $(".advance_price").prop('disabled', false);

                } else if(advance_price > 0 && advance_price > price){
                    console.log('enter in elseif 1 if else if');

                    var advance_price = $('.advance_hidden_price').val();
                    advance_price = Number(advance_price);

                    $scope.total_price = price - advance_price;
                    $scope.total_price = Number($scope.total_price);

                    $('.total_price').val($scope.total_price);
                    $('.total_blance').val($scope.total_price);
                    // $(".advance_price").prop('disabled', false);

                } else{

                    console.log('enter in elseif 1 if else');

                    var input_price1 = first_price * weight * quantity;
                    input_price1 = Number(input_price1);

                    $('.total_price').val(input_price1);
                    $('.total_blance').val(input_price1);
                    // $(".advance_price").prop('disabled', false);

                }

            }
            else{
                console.log('enter in 4');

                if($('.product_hidden_price').val()){
                    first_price = $('.product_hidden_price').val();
                    first_price = Number(first_price);

                } else if( $('.product_hidden_price').val() == ''){
                    first_price = 0;
                    first_price = Number(first_price);

                }
                var input_price1 = first_price * weight;
                input_price1 = Number(input_price1);

                $('.price').val(input_price1);
                $('.product_price').val(input_price1);

                var price;
                if($('.price').val()){
                    price = $('.price').val();
                    price = Number(price);

                } else if( $('.price').val() == ''){
                    price = 0;
                    price = Number(price);

                }
                var advance_price;
                if($('.advance_price').val()){
                    advance_price = $('.advance_price').val();
                    advance_price = Number(advance_price);

                } else if( $('.advance_price').val() == ''){
                    advance_price = 0;
                    advance_price = Number(advance_price);

                }

                $scope.total_price = price;
                $scope.total_price = Number($scope.total_price);

                if(advance_price > 0 && advance_price <= price){

                    $scope.total_price = price - advance_price;
                    $scope.total_price = Number($scope.total_price);

                    console.log('enter in elseif 1 else if: ', $scope.total_price, 'price: ', price);

                    $('.total_price').val($scope.total_price);
                    $('.total_blance').val($scope.total_price);
                    // $(".advance_price").prop('disabled', false);

                } else if(advance_price > 0 && advance_price > price){

                    console.log('enter in elseif 1 else else if', advance_price, ' :: ', price);

                    var advance_price = $('.advance_hidden_price').val();
                    advance_price = Number(advance_price);

                    $scope.total_price = price - advance_price;
                    $scope.total_price = Number($scope.total_price);

                    $('.total_price').val($scope.total_price);
                    $('.total_blance').val($scope.total_price);
                    // $(".advance_price").prop('disabled', false);

                } else{

                    console.log('enter in elseif 1 else else');

                    var input_price1 = first_price * weight;
                    input_price1 = Number(input_price1);

                    $scope.total_price = input_price1;
                    $scope.total_price = Number($scope.total_price);

                    $('.total_price').val(input_price1);
                    $('.total_blance').val(input_price1);
                    // $(".advance_price").prop('disabled', false);

                }
            }
        }
        else if (input_price > 0){

            console.log('enter in 5');

            var price;
            if($('.price').val()){
                price = $('.price').val();
                price = Number(price);

            } else if( $('.price').val() == ''){
                price = 0;
                price = Number(price);

            }
            var advance_price;
            if($('.advance_price').val()){
                advance_price = $('.advance_price').val();
                advance_price = Number(advance_price);

            } else if( $('.advance_price').val() == ''){
                advance_price = 0;
                advance_price = Number(advance_price);

            }

            $scope.total_price = price;
            $scope.total_price = Number($scope.total_price);

            if(advance_price > 0 && advance_price <= price){
                console.log('advance_price <= price');

                $scope.total_price = $scope.total_price - advance_price;
                $scope.total_price = Number($scope.total_price);

                $('.total_price').val($scope.total_price);
                $('.total_blance').val($scope.total_price);
                // $(".advance_price").prop('disabled', false);

            } else if(advance_price > 0 && advance_price > price){

                var advance_price = $('.advance_hidden_price').val();
                advance_price = Number(advance_price);

                $scope.total_price = price - advance_price;
                $scope.total_price = Number($scope.total_price);

                console.log('advance_price > price', advance_price);

                $('.total_price').val($scope.total_price);
                $('.total_blance').val($scope.total_price);
                // $(".advance_price").prop('disabled', false);

            }else{
                console.log('enter in else else');

                $('.total_price').val(price);
                $('.total_blance').val(price);
                // $(".advance_price").prop('disabled', false);

            }
        }
    }


    $http.get(API_URL + "categories")
        .success(function(response) {
            console.log("Azam");
            $scope.categories = response;

            $scope.categoiesFlag = true;
            $scope.sub_categoiesFlag = false;
            $scope.productFlag = false;
            $scope.productGridViewFlag = false;
            $scope.productSingleViewFlag = false;
            $scope.productPreviewFlag = false;
            $scope.orderFlag = false;
            $scope.customOrderFlag = false;
            $scope.breadcrumbFlag = false;
            $scope.thanxPageFlag = false;

            $scope.breadcrumbs.length = 0;

            $("#body-element").css('background-image', 'none');
            $("#body-element").css('background-image', 'url(assets/images/staticImage/fixed_background_third.jpg)');
            $("#body-element").css('background-repeat', 'no-repeat');
            $("#body-element").css('position', 'fixed');
            $("#body-element").css('background-size', 'cover');
            $("#body-element").css('top', '0');
            $("#body-element").css('left', '0');
            $("#body-element").css('width', '100%');
            $("#body-element").css('height', '100%');

        })
        .error(function (e) {
            console.log("Error: ", e);

        });


    ///////////////////////////////////
    //   Load HTML by modelstate    //
    //////////////////////////////////
    $scope.categoryName = function(modalstate, id, name, index) {
        $scope.modalstate = modalstate;
        // $(".left-sec-view-pro").hide();

        switch (modalstate) {

            case 'categories':
                $scope.id = id;
                $http.get(API_URL + 'categories/' + id)
                    .success(function(response) {

                        if(response.collection){
                            console.log('response.collection: ', response.collection);
                        }

                        // return;
                        var count = 0;
                        for(var i = 0; i < $scope.breadcrumbs.length; i++) {

                            if ($scope.breadcrumbs[i].name == 'MAIN MENU') {

                                if($scope.breadcrumbs[i].module == modalstate){

                                    $scope.breadcrumbs.length = i+1;

                                }
                                count = 1;break;
                            }
                        }

                        if(count == 0){
                            $scope.breadcrumbs.push({'name' : 'MAIN MENU', 'id': id, 'module': 'MAIN MENU', 'state': '1', "separator":'»'});

                        }

                        if(response.status != 'failed') {

                            $scope.subcategories = response.sub_categories;
                            $scope.category_products = response.category_products;

                            if(response.product_images){

                                $scope.product_images = response.product_images;

                            }else {
                                $scope.product_images = response.product_images;

                            }

                            if($scope.subcategories.length > 0){

                                $scope.categoiesFlag = false;
                                $scope.sub_categoiesFlag = true;
                                $scope.productFlag = false;
                                $scope.productGridViewFlag = false;
                                $scope.productSingleViewFlag = false;
                                $scope.productPreviewFlag = false;
                                $scope.orderFlag = false;
                                $scope.customOrderFlag = false;
                                $scope.breadcrumbFlag = true;
                                $scope.productsSection = false;
                                $scope.thanxPageFlag = false;

                                $scope.moduelName = name;

                                $("#body-element").css('background-image', 'none');
                                $("#body-element").css('background-image', 'url(assets/images/staticImage/fixed_background_third.jpg)');
                                $("#body-element").css('background-repeat', 'no-repeat');
                                $("#body-element").css('position', 'fixed');
                                $("#body-element").css('background-size', 'cover');
                                $("#body-element").css('top', '0');
                                $("#body-element").css('left', '0');
                                $("#body-element").css('width', '100%');
                                $("#body-element").css('height', '100%');

                                var count = 0;
                                for(var i = 1; i < $scope.breadcrumbs.length; i++) {

                                    if ($scope.breadcrumbs[i].name == name) {

                                        if($scope.breadcrumbs[i].module == modalstate){

                                            $scope.breadcrumbs.length = i+1;

                                        }

                                        count = 1;break;
                                    }
                                }

                                if(count == 0){
                                    $scope.breadcrumbs.push({'name' : name, 'id': id, 'module': modalstate, 'state': '1', "separator":'»'});
                                    $scope.breadcrumbs_module_item.push({'category':'  Select Sub-cat'});

                                }

                                console.log('breadcrumbs_module_item', $scope.breadcrumbs_module_item[0].item);
                                if($scope.category_products.length > 0){

                                    $scope.categoiesFlag = false;
                                    $scope.sub_categoiesFlag = true;
                                    $scope.productFlag = false;
                                    $scope.productGridViewFlag = false;
                                    $scope.productSingleViewFlag = false;
                                    $scope.productPreviewFlag = false;
                                    $scope.orderFlag = false;
                                    $scope.customOrderFlag = false;
                                    $scope.breadcrumbFlag = true;
                                    $scope.productsSection = true;
                                    $scope.thanxPageFlag = false;

                                    $("#body-element").css('background-image', 'none');
                                    $("#body-element").css('position', 'relative');

                                    var length = $scope.breadcrumbs.length;
                                    // console.log("length: ", length);

                                    var count = 0;
                                    for(var i = 0; i < $scope.breadcrumbs.length; i++) {

                                        if ($scope.breadcrumbs[i].name == name) {

                                            if($scope.breadcrumbs[i].module == modalstate){

                                                $scope.breadcrumbs.length = i+1;

                                            }
                                            count = 1;break;
                                        }
                                    }

                                    if(count == 0){

                                        $scope.breadcrumbs.push({'name' : name, 'id': id, 'module': modalstate, "separator":'»'});
                                        $scope.breadcrumbs_module_item.push({'product':'  Select Product'});

                                        // console.log('products count 1', $scope.breadcrumbs);
                                    }
                                }


                            }else if($scope.category_products.length > 0){

                                $scope.categoiesFlag = false;
                                $scope.sub_categoiesFlag = false;
                                $scope.productFlag = false;
                                $scope.productGridViewFlag = false;
                                $scope.productSingleViewFlag = false;
                                $scope.productPreviewFlag = false;
                                $scope.orderFlag = false;
                                $scope.customOrderFlag = false;
                                $scope.breadcrumbFlag = true;
                                $scope.productsSection = true;
                                $scope.thanxPageFlag = false;

                                $("#body-element").css('background-image', 'none');
                                $("#body-element").css('position', 'relative');

                                if($scope.category_products.length > 0 && $scope.subcategories.length == 0) {
                                    $scope.productFlag = true;

                                }

                                var length = $scope.breadcrumbs.length;
                                console.log("length: ", length);

                                var count = 0;
                                for(var i = 0; i < $scope.breadcrumbs.length; i++) {

                                    if ($scope.breadcrumbs[i].name == name) {
                                        console.log('2');

                                        if($scope.breadcrumbs[i].module == modalstate){

                                            $scope.breadcrumbs.length = i+1;

                                        }

                                        count = 1;break;
                                    }
                                }

                                if(count == 0){
                                    $scope.breadcrumbs.push({'name' : name, 'id': id, 'module': modalstate, "separator":'»'});
                                    $scope.breadcrumbs_module_item.push({'product':'  Select Product'});

                                }

                                if($scope.subcategories.length > 0){

                                    $scope.categoiesFlag = false;
                                    $scope.sub_categoiesFlag = true;
                                    $scope.productFlag = false;
                                    $scope.productGridViewFlag = false;
                                    $scope.productSingleViewFlag = false;
                                    $scope.productPreviewFlag = false;
                                    $scope.orderFlag = false;
                                    $scope.customOrderFlag = false;
                                    $scope.breadcrumbFlag = true;
                                    $scope.productsSection = false;
                                    $scope.thanxPageFlag = false;


                                    $scope.moduelName = name;

                                    $("#body-element").css('background-image', 'none');
                                    $("#body-element").css('background-image', 'url(assets/images/staticImage/fixed_background_third.jpg)');
                                    $("#body-element").css('background-repeat', 'no-repeat');
                                    $("#body-element").css('position', 'fixed');
                                    $("#body-element").css('background-size', 'cover');
                                    $("#body-element").css('top', '0');
                                    $("#body-element").css('left', '0');
                                    $("#body-element").css('width', '100%');
                                    $("#body-element").css('height', '100%');


                                    var length = $scope.breadcrumbs.length;

                                    var count = 0;
                                    for(var i = 0; i < $scope.breadcrumbs.length; i++) {

                                        if ($scope.breadcrumbs[i].name == name) {

                                            if($scope.breadcrumbs[i].module == modalstate){

                                                $scope.breadcrumbs.length = i+1;

                                            }

                                            count = 1;break;
                                        }
                                    }

                                    if(count == 0){
                                        $scope.breadcrumbs.push({'name' : name, 'id': id, 'module': modalstate, "separator":'»'});
                                        $scope.breadcrumbs_module_item.push({'category':'  Select Sub-cat'});

                                    }


                                }
                            }
                        }
                        else {

                            $scope.errorCount = true;
                            $scope.formErrorBlock = false;

                            // alert("Haven't sub category or product");

                            $('.custom_message_block').html('<div class="alert alert-danger alert-dismissible fade in" role="alert" style="background: #be1238; color: #FFFFFF; border-color: #be1238; margin-top: -5px;"> <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: #FFFFFF;"> <span aria-hidden="true">&times;</span> </button> <strong>No Sub Category or Product. </strong></div>')
                            $('.custom_message_block').css('display', 'block');
                            $('.custom_message_block').css('float', 'right');

                        }

                    });
                break;
            case 'product':

                console.log('Azam ali ali')
                $scope.id = id;
                $http.get(API_URL + 'products/' + id)
                    .success(function(response) {

                        if(response.status != 'failed'){


                            if(response.products[0]){
                                $scope.products = response.products[0];

                            } else {
                                $scope.products = response.products;

                            }

                            $scope.quantity = 1;

                            $scope.total_price = $scope.products.price;

                            $scope.branches = response.branch;
                            $scope.flavours = response.flavours;
                            $scope.normalOrderremarksLimits = response.remarksLimits;

                            $scope.quantityDrpdown = [
                                {key: 1, value: 1},
                                {key: 2, value: 2},
                                {key: 3, value: 3},
                                {key: 4, value: 4},
                                {key: 5, value: 5},
                                {key: 6, value: 6},
                                {key: 7, value: 7},
                                {key: 8, value: 8},
                                {key: 9, value: 9},
                                {key: 10, value: 10},
                                {key: 11, value: 11},
                                {key: 12, value: 12},
                                {key: 13, value: 13},
                                {key: 14, value: 14}
                            ];

                            // $scope.quantityDefaultValue = $scope.quantityDrpdown[0];


                            console.log('quantityDefaultValue: ',$scope.quantityDefaultValue);

                            $scope.priorities = [
                                {key: 0, value: 'Heigh'},
                                {key: 1, value: 'Medium'},
                                {key: 2, value: 'Low'},
                            ];

                            $scope.defaultSelectedPropery = $scope.priorities[1].key;

                            $scope.orderStatus = [
                                {key: 0, value: 'un-rocessed'},
                                {key: 1, value: 'processed'},
                                {key: 2, value: 'padding'},
                                {key: 3, value: 'canceled'}
                            ];

                            $scope.paymentType = [
                                {key: 0, value: 'Debit'},
                                {key: 1, value: 'Credit'},
                                {key: 2, value: 'Cash'},
                            ];

                            // console.log('$scope.priorities: ', $scope.priorities);return;

                            $scope.products.maxWeight = $scope.products.weight;

                            $scope.branchId = null;
                            $scope.categoiesFlag = false;
                            $scope.sub_categoiesFlag = false;
                            $scope.productFlag = false;
                            $scope.productGridViewFlag = false;
                            $scope.productSingleViewFlag = false;
                            $scope.productPreviewFlag = false;
                            $scope.orderFlag = true;
                            $scope.customOrderFlag = false;
                            $scope.breadcrumbFlag = true;
                            $scope.thanxPageFlag = false;


                            $timeout(function () {
                                $(".cust_name").focus();

                            });
                            $("#body-element").css('background-image', 'none');
                            $("#body-element").css('position', 'relative');

                            var count = 0;
                            for(var i = 0; i < $scope.breadcrumbs.length; i++) {

                                if ($scope.breadcrumbs[i].name == name) {

                                    if($scope.breadcrumbs[i].module == modalstate){

                                        $scope.breadcrumbs.length = i;

                                    }

                                    count = 1;break;
                                }
                            }

                            if(count == 0){
                                $scope.breadcrumbs.push({'name' : name, 'id': id, 'module': modalstate, "separator":'»'});
                                $scope.breadcrumbs_module_item.push({'product':'  Select Product'});
                            }
                        }


                    });

                break;
            case 'viewProducts':

                $scope.categoiesFlag = false;
                $scope.sub_categoiesFlag = false;
                $scope.productFlag = true;
                $scope.productGridViewFlag = false;
                $scope.productSingleViewFlag = false;
                $scope.productPreviewFlag = false;
                $scope.orderFlag = false;
                $scope.customOrderFlag = false;
                $scope.breadcrumbFlag = true;
                $scope.thanxPageFlag = false;


                $("#body-element").css('background-image', 'none');

                break;
            case 'productGridView':

                $scope.id = id;

                if($scope.sub_categoiesFlag == true){
                    $scope.sub_categoiesFlag = true;
                } else {
                    $scope.sub_categoiesFlag = false;
                }

                $scope.categoiesFlag = false;
                // $scope.sub_categoiesFlag = false;
                $scope.productFlag = false;
                $scope.productGridViewFlag = true;
                $scope.productSingleViewFlag = false;
                $scope.productPreviewFlag = false;
                $scope.orderFlag = false;
                $scope.customOrderFlag = false;
                $scope.breadcrumbFlag = true;
                $scope.thanxPageFlag = false;

                $("#body-element").css('background-image', 'none');
                $("#body-element").css('position', 'relative');


                break;
            case 'productSingleView':

                $scope.id = id;

                if($scope.sub_categoiesFlag == true){
                    $scope.sub_categoiesFlag = true;
                } else {
                    $scope.sub_categoiesFlag = false;
                }
                $scope.categoiesFlag = false;
                // $scope.sub_categoiesFlag = false;
                $scope.productFlag = false;
                $scope.productGridViewFlag = false;
                $scope.productSingleViewFlag = true;
                $scope.productPreviewFlag = false;
                $scope.orderFlag = false;
                $scope.customOrderFlag = false;
                $scope.breadcrumbFlag = true;
                $scope.thanxPageFlag = false;

                $("#body-element").css('background-image', 'none');

                break;
            case 'productPreviewSection':

                $scope.index = index;
                $scope.id = id;

                Lightbox.openModal($scope.product_images, $scope.index, $scope.id);

                break;
            case 'customOrder':

                console.log('Azam ali ali');

                $http.get(API_URL + 'flavor')
                    .success(function(response) {

                        if(response.status != 'failed') {

                            $scope.total_price = 0;

                            if (response.products) {
                                $scope.products = response.products;

                            }
                            // else {
                            //     $scope.products = response.products;
                            //
                            // }
                            $scope.branches = response.branch;
                            $scope.flavours = response.flavours;
                            $scope.customOrderRemarksLimits = response.remarksLimits;

                            console.log('$scope.branches: ', $scope.branches);
                            console.log('$scope.flavours: ', $scope.flavours);

                            $scope.quantityDrpdown = [
                                {key: 1, value: 1},
                                {key: 2, value: 2},
                                {key: 3, value: 3},
                                {key: 4, value: 4},
                                {key: 5, value: 5},
                                {key: 6, value: 6},
                                {key: 7, value: 7},
                                {key: 8, value: 8},
                                {key: 9, value: 9},
                                {key: 10, value: 10},
                                {key: 11, value: 11},
                                {key: 12, value: 12},
                                {key: 13, value: 13},
                                {key: 14, value: 14}
                            ];

                            $scope.quantityDefaultValue = $scope.quantityDrpdown[0];

                            $scope.quantityDefaultValue = $scope.quantityDefaultValue.key;
                            console.log('quantityDefaultValue: ', $scope.quantityDefaultValue);

                            $scope.priorities = [
                                {key: 0, value: 'Heigh'},
                                {key: 1, value: 'Medium'},
                                {key: 2, value: 'Low'},
                            ];

                            $scope.defaultSelectedPropery = $scope.priorities[1].key;

                            $scope.orderStatus = [
                                {key: 0, value: 'Un-Processed'},
                                {key: 1, value: 'Processed'},
                                {key: 2, value: 'Padding'},
                                {key: 3, value: 'Canceled'}
                            ];

                            $scope.paymentType = [
                                {key: 0, value: 'Debit'},
                                {key: 1, value: 'Credit'},
                                {key: 2, value: 'Cash'},
                            ];

                            $scope.branchId = null;


                            $scope.categoiesFlag = false;
                            $scope.sub_categoiesFlag = false;
                            $scope.productFlag = false;
                            $scope.productGridViewFlag = false;
                            $scope.productSingleViewFlag = false;
                            $scope.productPreviewFlag = false;
                            $scope.orderFlag = false;
                            $scope.customOrderFlag = true;
                            $scope.breadcrumbFlag = true;
                            $scope.thanxPageFlag = false;

                            $timeout(function () {
                                $(".product_name").focus();

                            });
                            // $('input[@type="text"]')[0].focus();

                            $("#body-element").css('background-image', 'none');
                            $("#body-element").css('position', 'relative');


                            var count = 0;
                            for(var i = 0; i < $scope.breadcrumbs.length; i++) {

                                if ($scope.breadcrumbs[i].name == 'MAIN MENU') {

                                    if($scope.breadcrumbs[i].module == modalstate){

                                        $scope.breadcrumbs.length = i+1;

                                    }
                                    count = 1;break;
                                }
                            }

                            if(count == 0){
                                $scope.breadcrumbs.push({
                                    'name' : 'MAIN MENU',
                                    'id': id,
                                    'module': 'MAIN MENU',
                                    'state': '1',
                                    "separator":'»'
                                });

                            }

                            var count = 0;
                            for (var i = 0; i < $scope.breadcrumbs.length; i++) {

                                if ($scope.breadcrumbs[i].name == name) {

                                    if ($scope.breadcrumbs[i].module == modalstate) {

                                        $scope.breadcrumbs.length = i;

                                    }

                                    count = 1;
                                    break;
                                }
                            }

                            if (count == 0) {
                                $scope.breadcrumbs.push({
                                    'name': 'Custom order',
                                    'module': modalstate,
                                    "separator": '»'
                                });
                            }

                        }
                    });

                break;
            case 'submitOrderForm':


                var formData = id;


                var product_id, normalForm, product_price, price, advance_price, total_price,
                    product_weight, order_delivery_date, order_delivery_time, priority, weight,
                    cust_name, paymentType, normalOrderRemarks;

                if($('.product_id1').val()){
                    product_id = $('.product_id1').val();
                }

                if($('.normalForm').val()){
                    normalForm = $('.normalForm').val();
                }else{
                    normalForm = 1
                }

                if($('.product_price').val()){
                    product_price = $('.product_price').val();

                }

                if($('.price').val()){
                    price = $('.price').val();

                }

                if($('.advance_hidden_price').val()){
                    advance_price = $('.advance_hidden_price').val();

                }

                if($('.total_price').val()){
                    total_price = $('.total_price').val();

                }

                if($('.product_weight').val()){
                    product_weight = $('.product_weight').val();

                }
                if($('.order_delivery_date').val()){
                    order_delivery_date = $('.order_delivery_date').val();

                }
                if($('.order_delivery_time').val()){
                    order_delivery_time = $('.order_delivery_time').val();

                }

                if($('.weight').val()){
                    weight = $('.weight').val();

                }

                if($('.quantity').val()){
                    quantity = $('.quantity').val();

                }
                if($('.cust_name').val()){
                    cust_name = $('.cust_name').val();

                }
                if($('.normalOrderRemarks').val()){
                    normalOrderRemarks = $('.normalOrderRemarks').val();

                }

                priority = formData['priority'];
                priority = priority['key'];

                paymentType = formData['paymentType'];
                paymentType = paymentType['key'];

                if(cust_name == null){

                    $timeout(function () {
                        $(".cust_name").focus();

                    });
                    return;
                }

                if(weight == null || weight < $scope.products.weight){

                    $timeout(function () {
                        $(".weight").focus();

                    });
                    return;
                }

                if(quantity == null){

                    $timeout(function () {
                        $(".quantity").focus();

                    });
                    return;
                }

                if(total_price < 0){

                    $timeout(function () {

                        $(".advance_error_message").show();
                        $(".advance_price").focus();

                    });
                    return;
                }
                if(normalOrderRemarks){
                    if(normalOrderRemarks.length > $scope.normalOrderremarksLimits){

                        $timeout(function () {

                            $(".normalOrderRemarks").focus();

                        });
                        return;
                    }

                }

                var data = {
                    product_id: product_id,
                    normalForm: normalForm,
                    price: price,
                    weight: weight,
                    quantity: quantity,
                    priority: priority,
                    total_price: total_price,
                    paymentType: paymentType,
                    product_price: product_price,
                    advance_price: advance_price,
                    product_weight: product_weight,
                    remarks: normalOrderRemarks,
                    order_delivery_date: order_delivery_date,
                    order_delivery_time: order_delivery_time,
                }

                // console.log('data', data); return;

                $http({
                    method  : 'POST',
                    url     : 'client/v1/order',
                    data    : {'formData': formData, 'data': data},  // pass in data as strings
                    // headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
                })
                    .success(function(data) {
                        console.log(data);
                        if(data.status == 'success'){

                            $scope.categoiesFlag = false;
                            $scope.sub_categoiesFlag = false;
                            $scope.productFlag = false;
                            $scope.productGridViewFlag = false;
                            $scope.productSingleViewFlag = false;
                            $scope.productPreviewFlag = false;
                            $scope.orderFlag = false;
                            $scope.customOrderFlag = false;
                            $scope.breadcrumbFlag = false;
                            $scope.thanxPageFlag = true;

                            console.log('success', data.page);

                            if(data.page){

                                var count = 0;
                                for(var i = 1; i < $scope.breadcrumbs.length; i++) {

                                    if ($scope.breadcrumbs[i].name == name) {

                                        if($scope.breadcrumbs[i].module == modalstate){

                                            $scope.breadcrumbs.length = i;

                                        }

                                        count = 1;break;
                                    }
                                }

                                if(count == 0){
                                    $scope.breadcrumbs.push({'name' : name, 'id': id, 'module': modalstate, 'state': '1', "separator":'»'});

                                }

                                var delay = 3000;
                                setTimeout(function(){

                                    var originalContents = document.body.innerHTML;

                                    document.body.innerHTML = data.page;

                                    window.print();

                                    document.body.innerHTML = originalContents;

                                    window.location.reload();
                                }, delay);

                            }

                        } else if(data.status == 'failed'){
                            console.log('failed');

                            $scope.formErrorBlock = true;
                            $scope.errorCount = false;

                            $( ".error-block" ).append( '<div class="alert alert-danger">Order does not submit. Please provide the correct informations</div>' );

                        }
                    });

                break;
            case 'submitCustomOrderForm':

                var formData = id;

                var price, product_price, advance_price, total_price, product_weight, order_delivery_date,
                    order_delivery_time, priority, quantity, weight, cust_name, product_name,
                    paymentType, customOrderRemarks;


                if($('.product_price').val()){
                    product_price = $('.product_price').val();

                }else {
                    product_price = 0;
                }

                if($('.price').val()){
                    price = $('.price').val();

                }else {
                    price = 0;
                }

                if($('.advance_hidden_price').val()){
                    advance_price = $('.advance_hidden_price').val();

                }else {
                    advance_price = 0;
                }

                if($('.total_price').val()){
                    total_price = $('.total_price').val();

                }else {
                    total_price = 0;
                }

                if($('.product_weight1').val()){
                    product_weight = $('.product_weight1').val();

                }else {
                    product_weight = 1;
                }

                if($('.order_delivery_date').val()){
                    order_delivery_date = $('.order_delivery_date').val();

                }

                if($('.order_delivery_time').val()){
                    order_delivery_time = $('.order_delivery_time').val();

                }


                if ($('#uploadFile').val()){

                    var file_name = $('#uploadFile').val();
                    file_name = file_name.replace(/\\/g, '/').replace(/.*\//, '')

                }

                if($('.order_delivery_time').val()){
                    order_delivery_time = $('.order_delivery_time').val();

                }

                if($('.weight').val()){
                    weight = $('.weight').val();

                }
                if($('.product_name').val()){
                    product_name = $('.product_name').val();

                }
                if($('.cust_name').val()){
                    cust_name = $('.cust_name').val();

                }

                if($('.quantity').val()){
                    quantity = $('.quantity').val();

                }
                if($('.customOrderRemarks').val()){
                    customOrderRemarks = $('.customOrderRemarks').val();

                }
                // Return on invalid form submition

                if(product_name == null){

                    $timeout(function () {
                        $(".product_name").focus();

                    });
                    return;
                }

                if(price == 0){

                    $timeout(function () {
                        $(".price").focus();

                    });
                    return;
                }

                if(cust_name == null){

                    $timeout(function () {
                        $(".cust_name").focus();

                    });
                    return;
                }
                if(weight == null){

                    $timeout(function () {
                        $(".weight").focus();

                    });
                    return;
                }

                if(quantity == null){

                    $timeout(function () {
                        $(".quantity").focus();

                    });
                    return;
                }
                if(order_delivery_time == null){

                    $timeout(function () {

                        $(".order_delivery_time").attr("tabindex", 1);
                        $(".order_delivery_time").focus();
                        $(".time_error_message").show();

                    });
                    $(".time_error_message").show();

                    return;
                }
                if(total_price < 0){

                    $timeout(function () {

                        $(".advance_error_message").show();
                        $(".advance_price").focus();

                    });
                    return;
                }

                if(customOrderRemarks){

                    if(customOrderRemarks.length > $scope.customOrderRemarksLimits){

                        $timeout(function () {

                            $(".customOrderRemarks").focus();

                        });
                        return;
                    }
                }


                priority = formData['priority'];
                priority = priority['key'];

                paymentType = formData['paymentType'];
                paymentType = paymentType['key'];

                var data = {
                    weight: weight,
                    quantity: quantity,
                    priority: priority,
                    file_name: file_name,
                    total_price: total_price,
                    paymentType: paymentType,
                    product_price: product_price,
                    advance_price: advance_price,
                    product_weight: product_weight,
                    remarks: customOrderRemarks,
                    order_delivery_date: order_delivery_date,
                    order_delivery_time: order_delivery_time,
                }

                console.log('data: ', data); return;

                $http({
                    method  : 'POST',
                    url     : 'client/v1/order',
                    data    : {'formData': formData, 'data': data},  // pass in data as strings
                    // headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
                })
                    .success(function(data) {
                        console.log(data);
                        if(data.status == 'success'){



                            $scope.categoiesFlag = false;
                            $scope.sub_categoiesFlag = false;
                            $scope.productFlag = false;
                            $scope.productGridViewFlag = false;
                            $scope.productSingleViewFlag = false;
                            $scope.productPreviewFlag = false;
                            $scope.orderFlag = false;
                            $scope.customOrderFlag = false;
                            $scope.breadcrumbFlag = false;
                            $scope.thanxPageFlag = true;


                            $scope.product = data.product;
                            $scope.order = data.order;


                            if(data.page){

                                var count = 0;
                                for(var i = 1; i < $scope.breadcrumbs.length; i++) {

                                    if ($scope.breadcrumbs[i].name == name) {

                                        if($scope.breadcrumbs[i].module == modalstate){

                                            $scope.breadcrumbs.length = i;

                                        }

                                        count = 1;break;
                                    }
                                }

                                if(count == 0){
                                    $scope.breadcrumbs.push({'name' : name, 'id': id, 'module': modalstate, 'state': '1', "separator":'»'});

                                }


                                var delay = 3000;
                                setTimeout(function(){

                                    var originalContents = document.body.innerHTML;

                                    document.body.innerHTML = data.page;

                                    window.print();

                                    document.body.innerHTML = originalContents;

                                    window.location.reload();
                                }, delay);
                            }

                        } else if(data.status == 'failed'){
                            console.log('failed');

                            $scope.formErrorBlock = true;
                            $scope.errorCount = false;

                            $( ".error-block" ).append( '<div class="alert alert-danger">Order does not submit. Please provide the correct informations</div>' );

                        }
                    });

                break;
            case 'MAIN MENU':

                console.log('Home category');

                $http.get(API_URL + "categories")
                    .success(function(response) {
                        console.log("Azam");
                        $scope.categories = response;
                        console.log($scope.categories);

                        $scope.categoiesFlag = true;
                        $scope.sub_categoiesFlag = false;
                        $scope.productFlag = false;
                        $scope.productGridViewFlag = false;
                        $scope.productSingleViewFlag = false;
                        $scope.orderFlag = false;
                        $scope.customOrderFlag = false;
                        $scope.breadcrumbFlag = false;
                        $scope.thanxPageFlag = false;

                        $scope.breadcrumbs = [];

                        $("#body-element").css('background-image', 'none');
                        $("#body-element").css('background-image', 'url(assets/images/staticImage/fixed_background_third.jpg)');
                        $("#body-element").css('background-repeat', 'no-repeat');
                        $("#body-element").css('position', 'fixed');
                        $("#body-element").css('background-size', 'cover');
                        $("#body-element").css('top', '0');
                        $("#body-element").css('left', '0');
                        $("#body-element").css('width', '100%');
                        $("#body-element").css('height', '100%');
                    })
                    .error(function (e) {
                        console.log("Error: ", e);

                    });

                break;
            case 'submitOrderFormCencel':

                var confirm1 = confirm("Are you sure?");
                if(confirm1 != true){
                    return;
                }

                $http.get(API_URL + "categories")
                    .success(function(response) {
                        console.log("Azam");
                        $scope.categories = response;

                        $scope.categoiesFlag = true;
                        $scope.sub_categoiesFlag = false;
                        $scope.productFlag = false;
                        $scope.productGridViewFlag = false;
                        $scope.productSingleViewFlag = false;
                        $scope.productPreviewFlag = false;
                        $scope.orderFlag = false;
                        $scope.customOrderFlag = false;
                        $scope.breadcrumbFlag = false;
                        $scope.thanxPageFlag = false;

                        $scope.breadcrumbs.length = 0;

                        $("#body-element").css('background-image', 'none');
                        $("#body-element").css('background-image', 'url(assets/images/staticImage/fixed_background_third.jpg)');
                        $("#body-element").css('background-repeat', 'no-repeat');
                        $("#body-element").css('position', 'fixed');
                        $("#body-element").css('background-size', 'cover');
                        $("#body-element").css('top', '0');
                        $("#body-element").css('left', '0');
                        $("#body-element").css('width', '100%');
                        $("#body-element").css('height', '100%');
                    })
                    .error(function (e) {
                        console.log("Error: ", e);

                    });
                break;
            case 'submitCustomOrderFormCencel':

                var confirm1 = confirm("Are you sure?");

                if(confirm1 != true){
                    return;
                }

                $http.get(API_URL + "categories")
                    .success(function(response) {
                        console.log("Azam");
                        $scope.categories = response;

                        $scope.categoiesFlag = true;
                        $scope.sub_categoiesFlag = false;
                        $scope.productFlag = false;
                        $scope.productGridViewFlag = false;
                        $scope.productSingleViewFlag = false;
                        $scope.productPreviewFlag = false;
                        $scope.orderFlag = false;
                        $scope.customOrderFlag = false;
                        $scope.breadcrumbFlag = false;
                        $scope.thanxPageFlag = false;

                        $scope.breadcrumbs.length = 0;

                        $("#body-element").css('background-image', 'none');
                        $("#body-element").css('background-image', 'url(assets/images/staticImage/fixed_background_third.jpg)');
                        $("#body-element").css('background-repeat', 'no-repeat');
                        $("#body-element").css('position', 'fixed');
                        $("#body-element").css('background-size', 'cover');
                        $("#body-element").css('top', '0');
                        $("#body-element").css('left', '0');
                        $("#body-element").css('width', '100%');
                        $("#body-element").css('height', '100%');
                    })
                    .error(function (e) {
                        console.log("Error: ", e);

                    });
                break;
            default:
                break;
        }
    }

});