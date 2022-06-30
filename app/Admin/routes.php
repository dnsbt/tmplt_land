<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

    $router->resource('/config', 'SiteConfigurationController');
    $router->resource('/file', 'FileController');
    $router->resource('/project', 'ProjectController');
    $router->resource('/client_message', 'ClientMessageController');
});
