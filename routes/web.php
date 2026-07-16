<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PublicVerificationController;
use App\Http\Controllers\LecturerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public Verification & Tracking
Route::get('/verify/{hash}', [PublicVerificationController::class, 'verify'])->name('verify');
Route::get('/track/{id}', [PublicVerificationController::class, 'track'])->name('track');
Route::get('/api/documents/{document}/status', [DocumentController::class, 'getStatus'])->name('documents.status-api');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Documents
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('documents.show');
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::get('/documents/{document}/preview', [DocumentController::class, 'preview'])->name('documents.preview');
    Route::get('/documents/{document}/download-stamped', [DocumentController::class, 'downloadStamped'])->name('documents.download-stamped');
    Route::get('/documents/{document}/download-signed', [DocumentController::class, 'downloadSigned'])->name('documents.download-signed');
    Route::patch('/documents/{document}/status', [DocumentController::class, 'updateStatus'])->name('documents.update-status');
    Route::post('/documents/{document}/revert', [DocumentController::class, 'revert'])->name('documents.revert');
    Route::delete('/documents/bulk-delete', [DocumentController::class, 'bulkDestroy'])->name('documents.bulk-destroy');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');

    // Lecturer Management
    Route::middleware(['role:admin,super_admin'])->group(function () {
        Route::resource('lecturers', LecturerController::class);
    });
});
