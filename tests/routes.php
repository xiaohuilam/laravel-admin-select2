<?php
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use LaravelAdminExt\Select2\Test\Controllers\QuestionController;
use LaravelAdminExt\Select2\Test\Controllers\AnswerController;
use LaravelAdminExt\Select2\Test\Controllers\CommentController;

Route::get('/ping', function () {
    return 'pong';
});

Route::group(['middleware' => ['web', 'admin', 'admin.permission:allow,administrator'],], function (Router $router) {
    $router->resource('/question', QuestionController::class);
    $router->resource('/answer', AnswerController::class);
    $router->resource('/comment', CommentController::class);
});
