<?php
use Illuminate\Support\Facades\Route;
use LaravelAdminExt\Select2\Test\Controllers\TestController;

Route::get('/ping', function () {
    return 'pong';
});
Route::get('/admin/test/{id}', TestController::class . '@edit');
