<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('/user')->group(function () {
    Route::post('/new', 'User\UserController@newUser');
    Route::post('/login', 'AuthController@login');

    // Route::group(['middleware' => ['auth:api']], function () {
    //     Route::post('/logout', 'AuthController@logout');
    //     Route::post('/refresh', 'AuthController@refresh');
    //     Route::post('/me', 'AuthController@me');
    // });
});

Route::prefix('/expenses')->group(function () {
    Route::get('/', 'Expenses\ExpensesController@all');
});
