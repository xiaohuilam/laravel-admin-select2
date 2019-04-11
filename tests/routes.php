<?php
use Illuminate\Support\Facades\Route;
use LaravelAdminExt\Select2\Test\Controllers\TestController;
use Illuminate\Routing\Router;

Route::get('/ping', function () {
    return 'pong';
});

Route::group(['middleware' => ['web', 'admin', 'admin.permission:allow,administrator'],], function (Router $router) {
    $router->resource('/test', TestController::class);
});
