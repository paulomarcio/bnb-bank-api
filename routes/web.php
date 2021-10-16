<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->post('/users', ['as' => 'users', 'uses' => 'UsersController@create']);
$router->post('/sessions', ['as' => 'sessions', 'uses' => 'SessionsController@create']);
$router->get('/transactions', ['middleware' => 'auth', 'as' => 'transactions.index', 'uses' => 'TransactionsController@index']);
$router->post('/transactions', ['middleware' => 'auth', 'as' => 'transactions.create', 'uses' => 'TransactionsController@create']);
$router->put('/transactions/{id}', ['middleware' => 'auth', 'as' => 'transactions.update', 'uses' => 'TransactionsController@update']);
$router->get('/expenses', ['middleware' => 'auth', 'as' => 'expenses', 'uses' => 'ExpensesController@index']);
$router->get('/incomes', ['middleware' => 'auth', 'as' => 'incomes', 'uses' => 'IncomesController@index']);
$router->get('/balances', ['middleware' => 'auth', 'as' => 'balances', 'uses' => 'BalancesController@index']);
