<?php

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

Auth::routes();

Route::get('register', function (){
    return abort(404);
})->name('register');
Route::post('register', function (){
    return abort(404);
});


Route::group(['middleware' => ['auth'] ], function (){

    // Dashboard Controller
    Route::get('/', 'DashboardController@index')->name('home');

    Route::get('/logs', 'DashboardController@logs')->middleware('can:logs_show')->name('logs.index');


    // Components Group
    Route::group(['prefix'=>'components'], function (){

        // view all Components
        Route::get('/', 'ComponentController@index')->name('components.index')
            ->middleware('can:components_show');

        // create Component
        Route::get('/create', 'ComponentController@create')->name('components.create')
            ->middleware('can:components_create');

        Route::post('/create', 'ComponentController@store')->name('components.store')
            ->middleware('can:components_create');

        // show Component
        Route::get('/{component}', 'ComponentController@show')->name('components.show')
            ->middleware('can:components_show');

        // edit Component
        Route::get('/{component}/edit', 'ComponentController@edit')->name('components.edit')
            ->middleware('can:components_edit');

        Route::patch('/{component}/edit', 'ComponentController@update')->name('components.update')
            ->middleware('can:components_edit');

        // delete Component
        Route::delete('/{component}/delete', 'ComponentController@destroy')->name('components.delete')
            ->middleware('can:components_delete');

    });


    // Items Group
    Route::group(['prefix'=>'items'], function (){

        // view all Items
        Route::get('/', 'ItemController@index')->name('items.index')
            ->middleware('can:items_show');

        // create Item
        Route::get('/create', 'ItemController@create')->name('items.create')
            ->middleware('can:items_create');

        Route::post('/create', 'ItemController@store')->name('items.store')
            ->middleware('can:items_create');

        // create Item
        Route::get('/import', 'ItemController@import')->name('items.import')
            ->middleware('can:items_create');

        Route::post('/import', 'ItemController@importStore')->name('items.import.store')
            ->middleware('can:items_create');

        // show Item
        Route::get('/{item}', 'ItemController@show')->name('items.show')
            ->middleware('can:items_show');

        // edit Item
        Route::get('/{item}/edit', 'ItemController@edit')->name('items.edit')
            ->middleware('can:items_edit');

        Route::patch('/{item}/edit', 'ItemController@update')->name('items.update')
            ->middleware('can:items_edit');

        // delete Item
        Route::delete('/{item}/delete', 'ItemController@destroy')->name('items.delete')
            ->middleware('can:items_delete');
        Route::get('/{item}/make_copy', 'ItemController@makeItemCopy')->name('items.make_copy');
//            ->middleware('can:items_delete');

    });

    // Mixes Group
    Route::group(['prefix'=>'mixes'], function (){

        // view all Mixes
        Route::get('/', 'MixController@index')->name('mixes.index')
            ->middleware('can:mixes_show');

        // create Mix
        Route::get('/create', 'MixController@create')->name('mixes.create')
            ->middleware('can:mixes_create');

        Route::post('/create', 'MixController@store')->name('mixes.store')
            ->middleware('can:mixes_create');

        // show Mix
        Route::get('/{mix}', 'MixController@show')->name('mixes.show')
            ->middleware('can:mixes_show');

        // edit Mix
        Route::get('/{mix}/edit', 'MixController@edit')->name('mixes.edit')
            ->middleware('can:mixes_edit');

        Route::patch('/{mix}/edit', 'MixController@update')->name('mixes.update')
            ->middleware('can:mixes_edit');

        // delete Mix
        Route::delete('/{mix}/delete', 'MixController@destroy')->name('mixes.delete')
            ->middleware('can:mixes_delete');

    });

    // users Group
    Route::group(['prefix'=>'users','middleware'=>'role:super_admin'], function (){

        // view all users
        Route::get('/', 'UserController@index')->name('users.index');
        // create user
        Route::get('/create', 'UserController@create')->name('users.create');
        Route::post('/create', 'UserController@store')->name('users.store');

        // show user
        Route::get('/{user}', 'UserController@show')->name('users.show');
        // edit user
        Route::get('/{user}/edit', 'UserController@edit')->name('users.edit');
        Route::patch('/{user}/edit', 'UserController@update')->name('users.update');
        // delete user
        Route::delete('/{user}/delete', 'UserController@destroy')->name('users.delete');

    });

    // roles routes
    Route::group(['prefix'=>'roles','middleware'=>'role:super_admin'], function (){

        Route::get('/', 'RoleController@index')->name('roles.index');
        Route::get('/create', 'RoleController@create')->name('roles.create');
        Route::get('/getGuardPermissions', 'RoleController@getGuardPermissions')->name('roles.getGuardPermissions');
        Route::post('/create', 'RoleController@store')->name('roles.store');
        Route::get('/{role}/edit', 'RoleController@edit')->name('roles.edit');
        Route::patch('/{role}/edit', 'RoleController@update')->name('roles.update');
        Route::delete('/{role}/delete', 'RoleController@destroy')->name('roles.delete');
        Route::get('/{role}', 'RoleController@show')->name('roles.show');

    });

    // Account Setting Group
    Route::group(['prefix'=>'account/settings'], function(){

        // Settings Routes
        Route::get('/', 'AccountController@settings')->name('account.settings');
        Route::patch('/', 'AccountController@settingsUpdate')->name('account.settings.update');

        // mobile verify
        Route::post('/verifyMobileToken', 'AccountController@verifyMobileToken')
            ->name('account.settings.verifyMobileToken');
        Route::post('/mobileToken/resend', 'AccountController@sendMobileToken')
            ->name('account.settings.mobileTokenResend');

        // email verify
        Route::get('/verifyEmailToken', 'AccountController@verifyEmailToken')
            ->name('account.settings.verifyEmailToken');
        Route::post('/emailToken/resend', 'AccountController@sendEmailToken')
            ->name('account.settings.emailTokenResend');
    });

});


Route::get('install', function (){
    \Illuminate\Support\Facades\Artisan::call('migrate:fresh');
    \Illuminate\Support\Facades\Artisan::call('db:seed');
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    \Illuminate\Support\Facades\Artisan::call('clean');

});
