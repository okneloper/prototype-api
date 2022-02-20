<?php

use App\Http\Controllers\DeliveryCostController;
use App\Http\Controllers\OrdersController;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:sanctum'], function (Router $router) {
    // Customer routes
    $router->group(['middleware' => 'ability:orders-create'], function (Router $router) {
        $router->post('/delivery/cost', [DeliveryCostController::class, 'calculate']);
        $router->post('/orders', [OrdersController::class, 'store']);
    });

    // Sales/Courier routes
    $router->get('/orders', [OrdersController::class, 'index'])->middleware('ability:orders-list');
    $router->get('/orders/{order_id}', [OrdersController::class, 'show'])->middleware('ability:orders-show');
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
