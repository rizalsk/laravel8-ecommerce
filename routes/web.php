<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\HomeComponent;
use App\Http\Livewire\ShopComponent;
use App\Http\Livewire\CartComponent;
use App\Http\Livewire\CheckoutComponent;
use App\Http\Livewire\User\UserDashboardComponent;
use App\Http\Livewire\ProductDetailsComponent;


use App\Http\Livewire\Admin\AdminDashboardComponent;
use App\Http\Livewire\Admin\Auth\Login as AdminLoginComponent;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Livewire\Admin\AdminCategoryComponent;
use App\Http\Livewire\Admin\AdminCategoryAddComponent;
use App\Http\Livewire\Admin\AdminCategoryEditComponent;

use App\Http\Livewire\Admin\AdminProductComponent;
use App\Http\Livewire\Admin\AdminProductAddComponent;
use App\Http\Livewire\Admin\AdminProductEditComponent;

use App\Http\Livewire\Admin\AdminAttributeComponent;
use App\Http\Livewire\Admin\AdminAttributeAddComponent;
use App\Http\Livewire\Admin\AdminAttributeEditComponent;

use App\Http\Livewire\Admin\Categories\SetProductAttributeComponent;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', HomeComponent::class);
Route::get('/shop', ShopComponent::class);
Route::get('/cart', CartComponent::class);
Route::get('/checkout', CheckoutComponent::class);
Route::get('/product/{slug}', ProductDetailsComponent::class)->name('product.details');

/* Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
}); */

//for user
Route::middleware(['auth:sanctum','verified'])->group(function () {
    Route::get('/user/dashboard', UserDashboardComponent::class)->name('user.dashboard');
});

//for admin
Route::prefix('admin')->name('admin.')->group(function(){
    Route::group(['middleware' => 'guest'], function(){
        Route::get('login', AdminLoginComponent::class)->name('login');
        Route::post('login', [AdminLoginController::class, 'login'])->name('login.post');
    });

    Route::middleware(['authadmin:admin'])->group(function () {
        Route::get('/', AdminDashboardComponent::class)->name('dashboard');

        Route::get('/categories', AdminCategoryComponent::class)->name('categories');
        Route::prefix('categories')->name('categories.')->group(function(){
            Route::get('/add', AdminCategoryAddComponent::class)->name('add');
            Route::get('/{slug}', AdminCategoryEditComponent::class)->name('edit');
            // set products attribute
            Route::prefix('attributes')->name('attributes.')->group(function(){
                Route::get('/products/{slug}', SetProductAttributeComponent::class)->name('products');
            });
        });

        Route::get('/products', AdminProductComponent::class)->name('products');
        Route::prefix('products')->name('products.')->group(function(){
            Route::get('/add', AdminProductAddComponent::class)->name('add');
            Route::get('/{slug}', AdminProductEditComponent::class)->name('edit');
        });

        Route::get('/attributes', AdminAttributeComponent::class)->name('attributes');
        Route::prefix('attributes')->name('attributes.')->group(function(){
            Route::get('/add', AdminAttributeAddComponent::class)->name('add');
            Route::get('/{id}', AdminAttributeEditComponent::class)->name('edit');
        });
        
    });
});


