<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

// Главная
Route::get('/', [HomeController::class, 'index'])->name('home');

// Товар
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

// Авторизация
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Профиль
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

// Корзина
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{id}', [CartController::class, 'add']);
Route::post('/cart/remove/{id}', [CartController::class, 'remove']);
Route::post('/cart/increase/{id}', [CartController::class, 'increase']);
Route::post('/cart/decrease/{id}', [CartController::class, 'decrease']);

// Заказы
Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::get('/checkout/{order_id}', [OrderController::class, 'show'])->name('checkout.show');
Route::post('/pay/{order_id}', [OrderController::class, 'pay'])->name('pay');
Route::post('/cancel/{order_id}', [OrderController::class, 'cancel'])->name('cancel');









// Админ
use App\Http\Controllers\AdminController;

Route::prefix('admin')->group(function () {

    Route::get('/users', [AdminController::class, 'users']);
    Route::get('/users/edit/{id}', [AdminController::class, 'editUser']);
    Route::post('/users/update/{id}', [AdminController::class, 'updateUser']);
    Route::get('/users/delete/{id}', [AdminController::class, 'deleteUser']);
    Route::get('/users/create', [AdminController::class, 'createUser']);
    Route::post('/users/store', [AdminController::class, 'storeUser']);


    Route::get('/categories', [AdminController::class, 'categories']);
    Route::get('/categories/create', [AdminController::class, 'createCategory']);
    Route::post('/categories/store', [AdminController::class, 'storeCategory']);
    Route::get('/categories/edit/{id}', [AdminController::class, 'editCategory']);
    Route::post('/categories/update/{id}', [AdminController::class, 'updateCategory']);
    Route::get('/categories/delete/{id}', [AdminController::class, 'deleteCategory']);


    Route::get('/products', [AdminController::class, 'products']);
    Route::get('/products/create', [AdminController::class, 'createProduct']);
    Route::post('/products/store', [AdminController::class, 'storeProduct']);
    Route::get('/products/edit/{id}', [AdminController::class, 'editProduct']);
    Route::post('/products/update/{id}', [AdminController::class, 'updateProduct']);
    Route::get('/products/delete/{id}', [AdminController::class, 'deleteProduct']);


    Route::get('/orders', [AdminController::class, 'orders']);
    Route::get('/orders/view/{id}', [AdminController::class, 'viewOrder']);
    Route::post('/orders/update-status/{id}', [AdminController::class, 'updateOrderStatus']);
    Route::get('/orders/delete/{id}', [AdminController::class, 'deleteOrder']);
});
