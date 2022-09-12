<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('/user')->group(function () {
    Route::post('/login', 'AuthController@login')->name('user.login');
    Route::get('/login', 'AuthController@verifyLogin')->name('login');
    Route::post('/new', 'User\UserController@newUser')->name('user.new');

    Route::group(['middleware' => ['auth:api']], function () {
        Route::post('/me', 'AuthController@me');
        Route::post('/logout', 'AuthController@logout');
        Route::post('/refresh', 'AuthController@refresh');
    });
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::prefix('/expenses')->group(function () {
        Route::post('/', 'Expenses\ExpensesController@store');
        Route::get('/', 'Expenses\ExpensesController@index');
        Route::get('/{expenseId}', 'Expenses\ExpensesController@show');
        Route::put('/', 'Expenses\ExpensesController@update');
        Route::delete('/{expenseId}', 'Expenses\ExpensesController@destroy');
    });
});

