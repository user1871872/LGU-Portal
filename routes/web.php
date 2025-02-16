<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ApplyPermitController;

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

Route::get('/', function () {
    return view('welcome');
})->name('home');


// Login Route (Single Page for Users & Admins)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Show the registration form
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');

// Handle registration form submission
Route::post('register', [RegisterController::class, 'register']);

// Admin Dashboard (Only for Admins)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// User Dashboard Route (Ensure this exists)
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
});

#Apply Permit
Route::prefix('user')->group(function () {
    Route::get('/apply-permit', [ApplyPermitController::class, 'index'])->name('apply-permit');
    Route::post('/apply-permit', [ApplyPermitController::class, 'store'])->name('apply-permit.store');
});

#Transactions
Route::get('/user/transactions', [ApplyPermitController::class, 'transactions'])->name('user.transactions');
Route::get('/apply-permit/{id}/edit', [ApplyPermitController::class, 'edit'])->name('apply-permit.edit');
Route::put('/user/apply-permit/{id}/update', [ApplyPermitController::class, 'update'])->name('apply-permit.update');

#AdminApplications
Route::get('/admin/applications', [ApplyPermitController::class, 'adminIndex'])->name('admin.applications');
Route::post('/admin/applications/{id}/update-status', [ApplyPermitController::class, 'updateStatus'])
    ->name('admin.applications.update-status');
