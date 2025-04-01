<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ApplyPermitController;
use App\Http\Controllers\PkCertificateController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PSGCController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\BusinessTypeController;
use App\Models\Barangay;
use App\Models\Province;
use App\Models\Town;
use Barryvdh\DomPDF\Facade\Pdf;

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

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [ApplyPermitController::class, 'adminDashboard'])->name('admin.dashboard');
});

// User Dashboard Route (Ensure this exists)
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
});
Route::get('/generate-pdf', function () {
    set_time_limit(300);
    ini_set('memory_limit', '512M');

    $pdf = PDF::loadView('pdf.business_permit')->setPaper('A4', 'portrait');
    return $pdf->download('business_permit.pdf');
});
#Apply Permit
Route::prefix('user')->group(function () {
    Route::get('/apply-permit', [ApplyPermitController::class, 'index'])->name('apply-permit');
    Route::post('/apply-permit', [ApplyPermitController::class, 'store'])->name('apply-permit.store');
    // Route::get('/apply-permit', [PSGCController::class, 'fetchLocations'])->name('apply-permit');
});

#Transactions
Route::get('/dashboard', [ApplyPermitController::class, 'dashboardStats'])->name('user.dashboard');
Route::get('/user/transactions', [ApplyPermitController::class, 'transactions'])->name('user.transactions');
Route::get('/apply-permit/{id}/edit', [ApplyPermitController::class, 'edit'])->name('apply-permit.edit');
Route::put('/apply-permit/{id}', [ApplyPermitController::class, 'update'])->name('apply-permit.update');
// Route::put('/applications/{id}', [ApplyPermitController::class, 'update'])
// ->name('applications.update');


#AdminApplications
Route::get('/admin/applications', [ApplyPermitController::class, 'adminIndex'])->name('admin.applications');
Route::post('/admin/applications/{id}/update-status', [ApplyPermitController::class, 'updateStatus'])
    ->name('admin.applications.update-status');
Route::get('/admin/archive', [ArchiveController::class, 'index'])->name('admin.archive');


Route::prefix('admin')->group(function () {
    Route::get('/business-types', [BusinessTypeController::class, 'index'])->name('admin.business-types');
    Route::post('/business-types', [BusinessTypeController::class, 'store'])->name('admin.add-business-type');
    Route::delete('/business-types/{id}', [BusinessTypeController::class, 'destroy'])->name('admin.delete-business-type');
});

// Show the report generation form
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::post('/admin/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/pk-certificates', [PkCertificateController::class, 'index'])->name('pk-certificates.index');
    Route::get('/pk-certificates/create', [PkCertificateController::class, 'create'])->name('pk-certificates.create');
    Route::post('/pk-certificates', [PkCertificateController::class, 'store'])->name('pk-certificates.store');
    Route::get('/pk-certificates/{id}', [PkCertificateController::class, 'show'])->name('pk-certificates.show');
    Route::delete('/pk-certificates/{id}', [PkCertificateController::class, 'destroy'])->name('pk-certificates.destroy');
    });

#notifications
Route::get('/mark-notification/{id}', function ($id) {
    $user = Auth::user();
    $notification = $user->notifications->where('id', $id)->first();

    if ($notification) {
        $notification->markAsRead();
    }

    return redirect()->back();
})->middleware('auth')->name('mark-notification');

Route::get('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])
    ->name('notifications.markAsRead');


#PSGC 
Route::get('/locations', [PSGCController::class, 'fetchLocations']);
Route::get('/get-municipalities', [PSGCController::class, 'getMunicipalities']);
Route::get('/get-barangays', [PSGCController::class, 'getBarangays']);

#locationController
Route::post('/save-address', [LocationController::class, 'storeAddress']);
