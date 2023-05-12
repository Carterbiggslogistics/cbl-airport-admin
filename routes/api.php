<?php

use App\Http\Controllers\API\RiderDeviceController;
use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('/role', 'RoleController@store');
// Route::post('/auth-login', 'UserController@login');
// Route::post('/create-order', 'OrderController@store');
// Route::post('/auth-register', 'UserController@register');
// Route::get('/logout', 'UserController@logout');
// Route::post('/cat', 'CategoryController@store');

Route::prefix('auth')->group(function () {
    Route::post('login', 'API\\AuthenticationController@login');
});

Route::middleware('auth:api')->group(function () {
    // /api/request/riders
    Route::prefix('request')->group(function () {
        Route::prefix('riders')->group(function () {
            Route::post('update-location', 'API\\RiderController@updateLocation');
            Route::post('device/register', [RiderDeviceController::class, 'registerDevice'])->name("onesignal.registerDevice");
            Route::get('device/{playerId}/update-status', [RiderDeviceController::class, 'updateNotificationStatus']);
        });

        // /api/request/sample
        Route::prefix('sample')->group(function () {
            Route::get('/', 'API\\SampleRequestController@index');
            Route::get('show/{id}', 'API\\SampleRequestController@show');
            Route::get('statuses', 'API\\SampleRequestController@getStatuses');
            Route::post('update-status', 'API\\SampleRequestController@changeStatus');
            Route::get('status-image/{id}', 'API\\SampleRequestController@getStatusImage');
        });

        // /api/request/pack
        Route::prefix('pack')->group(function () {
            Route::get('statuses', 'API\\PackRequestController@getStatuses');
            Route::post('update-status', 'API\\PackRequestController@changeStatus');
            Route::get('', 'API\\PackRequestController@index');
            Route::get('show/{id}', 'API\\PackRequestController@show');
            Route::get('status-image/{id}', 'API\\PackRequestController@getStatusImage');
        });
    });
});
