<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WorkerController;

Route::get('/login-sign-up', [AuthController::class, 'showForm'])->name('login.view');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/search-product/{sn}', [App\Http\Controllers\HomeController::class, 'searchProduct']);

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/send-message', [HomeController::class, 'sendMessage'])->name('send.message');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/assign/{id}', [AdminController::class, 'assignWorker'])->name('admin.assign');
    Route::delete('/admin/user/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.user.delete');
});


Route::get('/setup-admin', function () {
    \App\Models\User::updateOrCreate(
        ['email' => 'admin.tc@gmail.com'],
        [
            'name' => 'Super Admin',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '00000000'
        ]
    );
    return "Admin Created Successfully!";
});
Route::middleware(['auth'])->group(function () {
    Route::get('/worker/dashboard', [WorkerController::class, 'dashboard'])->name('worker.dashboard');
    Route::post('/worker/accept-task/{id}', [WorkerController::class, 'acceptTask'])->name('worker.accept');
});
Route::get('/create-test-worker', function () {
    $worker = App\Models\User::updateOrCreate(
        ['email' => 'worker@gmail.com'],
        [
            'name' => 'worker One',
            'password' => Hash::make('worker123'),
            'role' => 'worker',
            'phone' => '111111'
        ]
    );
    return "Worker Created! You can now login with: email: ahmed.worker@example.com | password: 12345678";
});
Route::post('/admin/products/store', [AdminController::class, 'storeProduct'])->name('admin.product.store');

