<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Supplychain_controller;
use App\Http\Controllers\WorkerController;

// --- مسارات العامة والمصادقة ---
Route::get('/login-sign-up', [AuthController::class, 'showForm'])->name('login.view');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/search-product/{sn}', [HomeController::class, 'searchProduct']);

// --- مسارات الزبون ---
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/send-message', [HomeController::class, 'sendMessage'])->name('send.message');
});

// --- مسارات الأدمن (Admin) ---
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/home', [AdminController::class, 'dashboard'])->name('admin.home');
    Route::get('/spare-parts', [AdminController::class, 'sparePage'])->name('admin.spare');
    Route::get('/workers-control', [AdminController::class, 'workersPage'])->name('admin.workers');
    Route::post('/assign-task', [AdminController::class, 'assignTask'])->name('admin.assign.task');
    Route::delete('/user/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.user.delete');
    Route::post('/products/store', [AdminController::class, 'storeProduct'])->name('admin.product.store');
});

// --- مسارات العامل (Worker) ---
Route::middleware(['auth'])->prefix('worker')->group(function () {
    Route::get('/dashboard', [WorkerController::class, 'workerDashboard'])->name('worker.dashboard');
    Route::get('/spare-parts', [WorkerController::class, 'sparePage'])->name('worker.spare');
    Route::post('/accept-task/{id}', [WorkerController::class, 'acceptTask'])->name('worker.accept');
    Route::post('/complete-task/{id}', [WorkerController::class, 'completeTask'])->name('worker.complete');
    Route::post('/delete-task/{id}', [WorkerController::class, 'destroyTask'])->name('worker.destroy');
    Route::post('/update-parts/{id}', [WorkerController::class, 'updateParts'])->name('worker.update.parts');
});

// --- مسارات الـ Supply Chain (المعدلة والمصححة) ---
Route::middleware(['auth'])->prefix('supply-chain')->group(function () {
    // الصفحة الرئيسية للمخزون
    Route::get('/dashboard', [Supplychain_controller::class, 'index'])->name('supply.dashboard');

    // إضافة منتج جديد
    Route::get('/create', [Supplychain_controller::class, 'create'])->name('supply.create');
    Route::post('/store', [Supplychain_controller::class, 'store'])->name('supply.store');

    // التعديل (تم الربط بالكنترولر الصحيح Supplychain_controller)
    Route::get('/edit/{id}', [Supplychain_controller::class, 'edit'])->name('supply.edit');
    Route::put('/update/{id}', [Supplychain_controller::class, 'update'])->name('supply.update');

    // حفظ قطع الغيار (الزر الفرعي في صفحة التعديل)
    Route::post('/spare-parts/store', [Supplychain_controller::class, 'storeSparePart'])->name('spare-parts.store');

    // الحذف
    Route::delete('/destroy/{id}', [Supplychain_controller::class, 'destroy'])->name('supply.destroy');

    // تحديث المخزون السريع (الكمية)
    Route::post('/update-stock/{id}/{action}', [Supplychain_controller::class, 'updateStock'])->name('supply.updateStock');
});

// --- روابط المساعدة (Development) ---
Route::get('/setup-admin', function () {
    \App\Models\User::updateOrCreate(['email' => 'admin.tc@gmail.com'], ['name' => 'Super Admin', 'password' => Hash::make('admin123'), 'role' => 'admin', 'phone' => '00000000']);
    return "Admin Created Successfully!";
});
