<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserDeviceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('pages.auth.login');
    })->name('login');

    Route::get('/auth-login', function () {
        return view('pages.auth.login');
    });

    Route::get('/admin-auth-register', function () {
        return view('pages.auth.register');
    });
    Route::post('/auth-login', 'UserController@login');
    Route::post('/admin-auth-register', 'UserController@register');
});

//OneSignal's routes
Route::middleware("auth")->group(function () {
    Route::post('user-device/register', [UserDeviceController::class, 'registerDevice'])->name("onesignal.registerDevice");
    Route::get('user-device/{playerId}/update-status', [UserDeviceController::class, 'updateNotificationStatus']);
});


Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        if (auth()->user()->can('oxygen-admin'))
            return redirect('/oxygen/overview');
        return redirect('/dashboard');
    });
    Route::get('/', function () {
        if (auth()->user()->can('oxygen-admin'))
            return redirect('/oxygen/overview');
        return redirect('/dashboard');
    });

    // Register supervisor routes
    Route::get('/register-supervisor', function () {
        return view('pages.auth.register_supervisor');
    });
    Route::post('/register-supervisor', 'UserController@registerSupervisor');

    Route::get('/auth-forgot-password', function () {
        return view('pages.auth.forgot_password');
    });


    Route::get('/logout', 'UserController@logout');

    Route::get('/dashboard', 'DashboardController@index');
    Route::get('/my-lab', 'DashboardController@myLab')->middleware('can:isLabAdmin');

    Route::get('/user-profile', function () {
        return view('pages.user.profile');
    });
    Route::get('/auth-password-reset/{uuid}', 'UserController@settings');
    Route::post('/auth-password-reset/{id}', 'UserController@password');
    Route::get('/user-profile/{uuid}', 'UserController@editProfile');
    Route::post('/user-profile/{id}', 'UserController@profileSettings');
    Route::get('/download-user-export-sheet', "UserController@downloadUserExportSheet");

    // Rider Route
    Route::get('/create-rider', 'RiderController@create')->middleware('can:isSuperAdmin');
    Route::post('/create-rider', 'RiderController@store')->middleware('can:isSuperAdmin');
    Route::get('/manage-rider', 'RiderController@index')->middleware('can:isSuperAdmin');
    Route::get('/edit-rider/{uuid}', 'RiderController@edit')->middleware('can:isSuperAdmin');
    Route::get('/update-rider/{uuid}', 'RiderController@updateDetails');
    Route::post('/update-rider/{id}', 'RiderController@update');
    Route::post('/delete-rider', 'RiderController@destroy');

    // Lab Route
    Route::get('/create-lab', 'LabController@create')->middleware('can:isSuperAdmin');
    Route::post('/create-lab', 'LabController@store')->middleware('can:isSuperAdmin');
    Route::get('/manage-lab', 'LabController@index')->middleware('can:isSuperAdmin')->name('manage.lab');
    Route::get('/edit-lab/{uuid}', 'LabController@edit')->middleware('can:isSuperAdmin');
    Route::get('/edit-lab-details/{uuid}', 'LabController@editLabDetials')->middleware('can:isSuperAdmin');
    Route::post('/delete-lab', 'LabController@destroy')->middleware('can:isSuperAdmin')->name('delete.lab');
    Route::post('/update-lab/{uuid}', 'LabController@update')->middleware('can:isSuperAdmin')->name('update.lab');
    Route::get('/download-lab-export-sheet', "LabController@downloadLabExportSheet");

    // Warehouse Route
   
    Route::post('/create-warehouse', 'WarehouseController@store')->middleware('can:isSuperAdmin');
    Route::get('/edit-warehouse/{uuid}', 'WarehouseController@edit')->middleware('can:isSuperAdmin');
    Route::post('/warehouse/cancel', 'WarehouseController@cancelWarehouse')->middleware('can:isSuperAdmin')->name('cancel.warehouse');
    Route::get('/download-warehouse-sheet', 'WarehouseController@downloadWarehouseSheet');

    // Admin Route
    Route::get('/manage-admin', 'AdminController@index')->middleware('can:isSuperAdmin');
    Route::get('/edit-admin/{uuid}', 'AdminController@edit')->middleware('can:isSuperAdmin');
    Route::get('/show-update-form/{uuid}', 'AdminController@showUpdateForm')->middleware('can:isSuperAdmin');
    Route::get('/create-admin', 'AdminController@create')->middleware('can:isSuperAdmin');
    Route::post('/create-admin', 'AdminController@store')->middleware('can:isSuperAdmin');
    Route::post('/revoke-admin', 'AdminController@revokeAdminPriviledges')->middleware('can:isSuperAdmin');
    Route::post('/update-admin/{id}', 'AdminController@update')->middleware('can:isSuperAdmin');

    // Transaction Route
    Route::get('/generate-transaction/{uuid}', 'TransactionController@create');
    Route::post('/generate-transaction', 'TransactionController@store');
    Route::get('/all-transactions', 'TransactionController@index');
    Route::get('/transaction-detail/{uuid}', 'TransactionController@edit');

    // Order Route
    Route::post('/admin-order', 'OrderController@adminOrder');
    Route::get('/create-order', 'OrderController@create');
    Route::post('/create-order', 'OrderController@store');
    Route::get('/incomplete-orders', 'OrderController@incompleteOrders')->middleware('can:isSuperAdmin');
    Route::get('/incomplete-order-details/{uuid}', 'OrderController@editIncompleteOrder');
    Route::post('/incomplete-order/{id}', 'OrderController@assignRiderToIncompleteOrder');
    Route::get('/open-orders', 'OrderController@show');
    Route::get('/order-details/{uuid}', 'OrderController@edit');
    Route::post('/completed', 'OrderController@orderCompleted')->middleware('can:isSuperAdmin');
    Route::post('/edit-status/{id}', 'OrderController@changeStatus')->middleware('can:isSuperAdmin');
    Route::get('/all-orders', 'OrderController@index');
    Route::get('/deleted-orders', 'OrderController@deletedOrders')->middleware('can:isSuperAdmin');
    Route::get('/deleted-order-details/{uuid}', 'OrderController@deletedOrderDetails')->middleware('can:isSuperAdmin');
    Route::post('/delete-order/{id}', 'OrderController@destroy')->middleware('can:isSuperAdmin');
    Route::post('/update-status', 'OrderController@updateStatus');
    Route::get('/completed-orders', 'OrderController@completedOrders');
    Route::get('/download-order-info-template', "OrderController@downloadOrderInfoTemplate");
    Route::post('/order-bulk-import', 'OrderController@importBulk');

    // Receipt Route
    Route::get('/generate-receipt/{uuid}', 'TransactionController@generateReceipt');
    Route::get('/view-receipts', 'TransactionController@viewReceipts');

    // Share route 
    Route::get('/share-requests', 'ShareController@index')->middleware('can:isSuperAdmin');
    Route::get('/all-share-requests', 'ShareController@show')->middleware('can:isSuperOrLabAdmin');
    Route::post('/share-supplies', 'ShareController@store');
    Route::post('/cbl-share', 'ShareController@cblShare')->middleware('can:isSuperAdmin');
    Route::get('/share-details/{uuid}', 'ShareController@edit')->middleware('can:isSuperOrLabAdmin');
    Route::post('/assign-rider/{id}', 'ShareController@assignRider')->middleware('can:isSuperAdmin');
    Route::post('/delivered-samples', 'ShareController@deliveredSamples')->middleware('can:isSuperAdmin');
    Route::get('/all-delivered-samples', 'ShareController@allDeliveredSamples')->middleware('can:isSuperOrLabAdmin');
    Route::post('/change-status/{id}', 'ShareController@changeStatus')->middleware('can:isSuperAdmin');

    // Profiler
    Route::post('/create-profiler', 'UserController@createProfiler'); // ->middleware('can:isSupervisor')
    Route::get('/manage-profilers', 'UserController@manageProfilers'); // ->middleware('can:isSupervisor')

    // Flight
    Route::get('/create-flight', 'FlightController@create'); //->middleware('can:isSupervisor');
    Route::post('/create-flight', 'FlightController@store');
    Route::get('/all-flights', 'FlightController@index');
    Route::get('/canceled-flights', 'FlightController@canceledFlights');
    Route::post('/upload-flight', 'FlightController@importFlight');
    Route::get('/download-flight', 'FlightController@exportFlight');
    Route::get('/download-flight-info-template', 'FlightController@downloadTemplate');
    Route::post('/search', 'FlightController@search');

    Route::post('/flight/cancel', 'FlightController@cancelFlight')->name('cancel.flight'); //

    Route::get('/manage-packs', 'PackController@index'); // Pack
    Route::post('/add-pack', 'PackController@store');
    Route::post('/add-item', 'ItemController@store'); // Item

    // Activity
    Route::get('/inventory-activity', 'ActivityController@index');
    Route::get('/inventory-category', 'CategoryController@index'); // Category
    Route::post('/add-category', 'CategoryController@store');
    Route::get('/activity-details/{uuid}', 'ActivityController@edit');

    // Inventory
    Route::get('/incomplete-inventories', 'InventoryController@incompleteInventories');
    Route::get('/inventories-details/{uuid}', 'InventoryController@edit');
    Route::post('/incomplete-inventory/{id}', 'InventoryController@assignRider');
    Route::get('/delivered-care-packs', 'InventoryController@deliveredCarePacks');
    Route::post('/delivered-care-packs', 'InventoryController@inventoryDelivered');
    Route::post('/admin-request', 'InventoryController@adminRequest'); // Admin pack request


    // Paystack
    Route::get('/verify-transactions/{reference}', 'PaymentController@handleGatewayCallback');

    //Riders
    Route::get('/download-riders-sheet', 'RiderController@downloadRidersSheet');


    //PackRequests
    Route::get('/download-pack-info-template', 'PackRequestController@downloadPackInfoTemplate');
    Route::get('/all-care-pack-requests', 'PackRequestController@index');
    Route::get('/pack-request', 'PackRequestController@create');
    Route::post('/pack-request', 'PackRequestController@store');
    Route::post('/pack-bulk-import', 'PackRequestController@importBulk');
    Route::post('/change-pack-status', 'PackRequestController@changeStatus');

    //Pack Transfer
    Route::post('/transfer-pack', 'PackTransferController@store');


    //Oxygen
    Route::prefix('oxygen')->group(function () {

        Route::prefix('inventory')->group(function () {
            Route::get('/', 'OxygenInventoryController@index');
            Route::get('add-actions', 'OxygenInventoryController@addActions');
        });

        // Oxygen Add Request
        Route::prefix('add-requests')->group(function () {
            Route::post('create', 'OxygenAddRequestController@store');
        });
        //Oxygen Plant
        Route::prefix('plant')->group(function () {
            Route::get('manage', 'OxygenPlantController@index');
            Route::get('create', 'OxygenPlantController@create');
            Route::post('create', 'OxygenPlantController@store');
        });

        //Oxygen Client
        Route::prefix('client')->group(function () {
            Route::get('manage', 'OxygenClientController@index');
            Route::get('create', 'OxygenClientController@create');
            Route::post('create', 'OxygenClientController@store');
        });

        //Oxygen Request
        Route::prefix('request')->group(function () {
            Route::get('manage', 'OxygenRequestController@index');
            Route::get('create', 'OxygenRequestController@create');
            Route::post('create', 'OxygenRequestController@store');
            Route::post('change-status', 'OxygenRequestController@changeStatus');
            Route::post('request-pickup', 'OxygenRequestController@requestPickup');
            Route::get('/{id}', 'OxygenRequestController@show');
        });
    });
});//end middleware route group
Route::get('/manage-warehouse', 'WarehouseController@index')->middleware('can:isSuperAdmin');