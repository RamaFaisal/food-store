<?php

namespace App\Livewire;

use App\Livewire\Account\MyOrders\Index;
use App\Livewire\Account\MyOrders\Show;
use App\Livewire\Account\MyProfile\Index as MyProfileIndex;
use App\Livewire\Account\Password\Index as PasswordIndex;
use App\Livewire\Web\Category\Show as CategoryShow;
use App\Livewire\Web\Home\Index as HomeIndex;
use App\Livewire\Web\Products\Index as ProductsIndex;
use App\Livewire\Web\Products\Show as ProductsShow;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('filamentCourse.index');
});

Route::get('/register', Auth\Register::class)->name('register');

Route::get('/login', Auth\Login::class)->name('login');

Route::middleware('auth:customer')->group(function () {
    Route::group(['prefix' => 'account'], function() {
        Route::get('/my-orders', Index::class)->name('account.my-orders.index');
        Route::get('/my-orders/{snap_token}', Show::class)->name('account.my-orders.show');
        Route::get('/my-profile', MyProfileIndex::class)->name('account.my-profile');
        Route::get('/password', PasswordIndex::class)->name('account.password');
    });
});

Route::get('/', HomeIndex::class)->name('home');
Route::get('/products', ProductsIndex::class)->name('web.product.index');
Route::get('/category/{slug}', CategoryShow::class)->name('web.category.show');
Route::get('/products/{slug}', ProductsShow::class)->name('web.product.show');