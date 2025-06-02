<?php

use App\Http\Controllers\Web\Backend\AdminController;
use App\Http\Controllers\Web\Backend\BreedController;
use App\Http\Controllers\Web\Backend\CategoryController;
use App\Http\Controllers\Web\Backend\ContactController;
use App\Http\Controllers\Web\Backend\KeyFeatureController;
use App\Http\Controllers\Web\Backend\ProductController;
use App\Http\Controllers\Web\Backend\RetailerController;
use App\Http\Controllers\Web\Backend\SettingController;
use App\Http\Controllers\Web\Backend\SubscriptionController;
use App\Http\Controllers\Web\Backend\TipsCareController;
use App\Http\Controllers\Web\Backend\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        /*============ Users ==========*/
        Route::prefix('user')
            ->name('user.')
            ->controller(UserController::class)
            ->group(function () {
                Route::get('/index', 'index')->name('index');
                //Route::get('/view/{id}', 'view')->name('view');
                Route::delete('/destroy/{id}', 'destroy')->name('destroy');
            });

        /*============ Settings ==========*/
        Route::prefix('setting')
            ->name('setting.')
            ->controller(SettingController::class)
            ->group(function () {
                Route::get('/app-setting/edit', 'appSettingEdit')->name('appSetting.edit');
                Route::post('/app-setting/update', 'appSettingUpdate')->name('appSetting.update');
                //Route::get('/view/{id}', 'view')->name('view');
                Route::delete('/destroy/{id}', 'destroy')->name('destroy');
            });

        /*============ Contact ==========*/
        Route::prefix('contact-list')
            ->name('contact.')
            ->controller(ContactController::class)
            ->group(function () {
                Route::get('/index', 'index')->name('index');
                Route::get('/view/{id}', 'view')->name('view');
                Route::delete('/destroy/{id}', 'destroy')->name('destroy');
            });

        /*============ Subscription ==========*/
        Route::prefix('subscribe-list')
            ->name('subscribe.')
            ->controller(SubscriptionController::class)
            ->group(function () {
                Route::get('/index', 'index')->name('index');
                Route::get('/view/{id}', 'view')->name('view');
                Route::delete('/destroy/{id}', 'destroy')->name('destroy');
            });


        /*============ Contact ==========*/
        Route::prefix('category')
            ->name('category.')
            ->controller(CategoryController::class)
            ->group(function () {
                Route::get('/index', 'index')->name('index');
                Route::post('/store', 'store')->name('store');
                Route::delete('/destroy/{id}', 'destroy')->name('destroy');
            });


        /*============ Retailer routes ==========*/
        Route::prefix('retailer')
            ->name('retailer.')
            ->controller(RetailerController::class)
            ->group(function () {
                Route::get('/index', 'index')->name('index');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::post('/update/{id}', 'update')->name('update');
                Route::post('/status/{id}', 'status')->name('status');
                Route::delete('/destroy/{id}', 'destroy')->name('destroy');
            });


        /*============ product routes ==========*/
        Route::prefix('product')
            ->name('product.')
            ->controller(ProductController::class)
            ->group(function () {
                Route::get('/index', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::post('/update/{id}', 'update')->name('update');
                Route::post('/status/{id}', 'status')->name('status');
                Route::delete('/destroy/{id}', 'destroy')->name('destroy');
            });


        /*============ KEY FEATURES routes ==========*/
        Route::prefix('key-feature')
            ->name('key_feature.')
            ->controller(KeyFeatureController::class)
            ->group(function () {
                Route::get('/index', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::post('/update/{id}', 'update')->name('update');
                Route::delete('/destroy/{id}', 'destroy')->name('destroy');
            });

        /*============ tips and care routes ==========*/
        Route::prefix('tips-and-care')
            ->name('tips_care.')
            ->controller(TipsCareController::class)
            ->group(function () {
                Route::get('/index', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::post('/update/{id}', 'update')->name('update');
                Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });

        /*============ tips and care routes ==========*/
        Route::prefix('breed')
            ->name('breed.')
            ->controller(BreedController::class)
            ->group(function () {
                Route::get('/index', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::post('/update/{id}', 'update')->name('update');
                Route::delete('/destroy/{id}', 'destroy')->name('destroy');
            });



});

