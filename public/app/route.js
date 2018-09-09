
var app = angular.module('client-app',['ngRoute', 'ui.bootstrap', 'bootstrapLightbox']).config(function (LightboxProvider) {

    LightboxProvider.templateUrl = 'app/template/imagePreviewTemplate.html';

    LightboxProvider.getImageUrl = function (image) {
        return "assets/images/usersImages/product/" + image.image;
    };

    LightboxProvider.fullScreenMode = true;

});

app.directive('customOrderFocus', function() {
    return {
        restrict: 'A',
        link: function($scope,elem,attrs) {

            var focusables = $(":focusable");
            elem.bind('keydown', function(e) {

                var code = e.keyCode || e.which;

                if (code === 9) {
                    var current = focusables.index(this);
                    var next;

                    console.log('current: ', current);
                    if(current === 9){
                        next = focusables.eq(12);

                    }else if(current === 12){
                        next = focusables.eq(10);

                    }else if(current === 11){
                        next = focusables.eq(13);

                    }else{
                        next = focusables.eq(current + 1).length ? focusables.eq(current + 1) : focusables.eq(0);
                    }

                    $('.btn-link').attr('tabindex', -1);

                    if(!next){
                        $('.product_name').focus();

                    }
                    next.focus();
                    e.preventDefault();
                }

            });
        }
    }
});
app.directive('normalOrderFocus', function() {
    return {
        restrict: 'A',
        link: function($scope,elem,attrs) {

            var focusables = $(":focusable");
            elem.bind('keydown', function(e) {

                var code = e.keyCode || e.which;

                if (code === 9) {
                    var current = focusables.index(this);

                    $('.btn-link').attr('tabindex', -1);

                    var next = focusables.eq(current + 1).length ? focusables.eq(current + 1) : focusables.eq(0);

                    if(!next){
                        $('.product_name').focus();

                    }
                    next.focus();
                    e.preventDefault();
                }

            });
        }
    }
});

app.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider.
        when('/', {
            templateUrl: 'app/template/tehzeeb.html',
            controller: 'clientController'
        });
        // $routeProvider.otherwise({redirectTo : '/customer'});
    }]);

