<?php

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

use Illuminate\Support\Facades\Route;

$router->get('/products', 'ProductsController@show');
$router->post('/products/{productId}', 'ProductsController@store');
$router->put('/products/{productId}', 'ProductsController@update');
$router->delete('/products/{productId}', 'ProductsController@delete');


