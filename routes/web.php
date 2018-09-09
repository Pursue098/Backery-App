<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['middleware' => array('admin_logged')], function () {
    Route::get('/', function () {
        return view('client/base/index');
    });
});

Route::post('/user/custom_login', [
    "uses" => 'Auth\LoginController@userAthentication',
    "as"   => "user.custom_login"
]);

Route::group(['middleware' => array('admin_logged'), 'prefix' => 'admin'], function () {

    Route::get('/order/{id}/print_screen', 'Admin\OrderController@printScreen');

    Route::post('/categories/{id}/delete_image', 'Admin\CategoryController@destroyImageFromDir');

    Route::get('/configuration/{id}/delete', ['as' => 'configuration.delete', 'uses' => 'Admin\ConfigurationController@delete']);

    Route::post('/branch/assign_user', 'Admin\BranchController@assignUserToBranch');
    Route::post('/products/{id}/p_delete_image', 'Admin\ProductController@destroyImageFromDir');

    Route::get('/categories/showSubCategories/{id}', ['as' => 'categories.listSubCategories', 'uses' => 'Admin\CategoryController@listSubCategories']);

    Route::post('/order/{id}/get_product_image', 'Admin\OrderController@get_image');
    Route::get('/order/order_by_priority/{id}', 'Admin\OrderController@getOrderByPriority');
    Route::get('/order/order_by_date/{id}', 'Admin\OrderController@getOrderByDate');

    Route::post('/products/search', ['as' => 'products.search', 'uses' => 'Admin\ProductController@getList']);
    Route::post('/order/search', ['as' => 'order.search', 'uses' => 'Admin\OrderController@getList']);


    Route::get('/', [
        'as'   => 'dashboard',
        'uses' => '\LaravelAcl\Authentication\Controllers\DashboardController@base'
    ]);
    
    Route::resource('categories', 'Admin\CategoryController');
    Route::resource('products', 'Admin\ProductController');
    Route::resource('order', 'Admin\OrderController');
    Route::resource('branch', 'Admin\BranchController');
    Route::resource('flavour', 'Admin\FlavourController');
    Route::resource('configuration', 'Admin\ConfigurationController');

});
Route::group(['middleware' => array('admin_logged',  'can_see'), 'prefix' => 'client'], function () {

//    Route::get('/', function () {
//        return view('client/base/index');
//    });


    Route::resource('v1/categories', 'Client\CategoryController', ['names' => [
        'index' => 'v1.client.categories.index',
        'store' => 'v1.client.categories.store',
        'create' => 'v1.client.categories.create',
        'destroy' => 'v1.client.categories.destroy',
        'update' => 'v1.client.categories.update',
        'show' => 'v1.client.categories.show',
        'edit' => 'v1.client.categories.edit',

    ]]);

    Route::resource('v1/products', 'Client\ProductController', ['names' => [
        'index' => 'v1.client.products.index',
        'store' => 'v1.client.products.store',
        'create' => 'v1.client.products.create',
        'destroy' => 'v1.client.products.destroy',
        'update' => 'v1.client.products.update',
        'show' => 'v1.client.products.show',
        'edit' => 'v1.client.products.edit',
    ]]);

    Route::resource('v1/order', 'Client\OrderController', ['names' => [
        'index' => 'v1.client.order.index',
        'store' => 'v1.client.order.store',
        'create' => 'v1.client.order.create',
        'destroy' => 'v1.client.order.destroy',
        'update' => 'v1.client.order.update',
        'show' => 'v1.client.order.show',
        'edit' => 'v1.client.order.edit',
    ]]);
    Route::resource('v1/flavor', 'Client\FlavourController', ['names' => [
        'index' => 'v1.client.flavor.index',
        'store' => 'v1.client.flavor.store',
        'create' => 'v1.client.flavor.create',
        'destroy' => 'v1.client.flavor.destroy',
        'update' => 'v1.client.flavor.update',
        'show' => 'v1.client.flavor.show',
        'edit' => 'v1.client.flavor.edit',
    ]]);

});

Route::group(['middleware' => array('admin_logged', 'can_see'), 'prefix' => 'employee', 'as' => 'v1.employee.'], function () {

    Route::get('/list', function () {
        return view('employee/orders/index');
    });

    Route::get('/v1/change_order_status/{status_key}', 'Employee\EmployeeController@changeOrderStatusTo');
    Route::post('/v1/search', ['as' => 'order.search', 'uses' => 'Employee\EmployeeController@getList']);
    Route::get('v1/order_by_priority/{id}', 'Employee\EmployeeController@getOrderByPriority');
    Route::get('v1/order_by_date/{id}', 'Employee\EmployeeController@getOrderByDate');

    Route::resource('v1/order', 'Employee\EmployeeController');
    
});

Route::group(['middleware' => array('admin_logged', 'can_see'), 'prefix' => 'employee_admin', 'as' => 'v1.employee_admin.'], function () {

    Route::post('/v1/change_order_status', 'EmployeeAdmin\EmployeeAdminController@changeOrderStatusTo');
    Route::post('/products/search', ['as' => 'products.search', 'uses' => 'EmployeeAdmin\EmployeeAdminController@getList']);
    Route::get('v1/order/order_by_priority/{id}', 'EmployeeAdmin\EmployeeAdminController@getOrderByPriority');
    Route::get('v1/order/order_by_date/{id}', 'EmployeeAdmin\EmployeeAdminController@getOrderByDate');

    Route::resource('v1/order', 'EmployeeAdmin\EmployeeAdminController');

});
