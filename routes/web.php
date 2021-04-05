<?php

// use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DisplayActionWithBalance;

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


/* Пополнение баланса */
$router->get('add', [
    'as' => 'top-up', 'uses' => 'Balance@TopUpBalance'
]);

/* Снятие с баланса */
$router->get('reduce', [
    'as' => 'reduce', 'uses' => 'Balance@ReduceBalance'
]);

/* Отмена транзакции */
$router->get('canceling', [
    'as' => 'canceling', 'uses' => 'Balance@CancelingTransaction'
]);
