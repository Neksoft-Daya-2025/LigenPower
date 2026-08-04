<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\DistrictController;

// Home page
Route::get('/', function () {
    return view('home');
})->name('home');

// Dealer Registration Routes - REMOVED (Admin Only)
// Public registration is now disabled - only admins can register dealers

// Search Routes
Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::post('/search', [SearchController::class, 'search'])->name('search.results');
Route::get('/search/districts', [SearchController::class, 'getDistricts'])->name('search.districts');

// Admin Authentication Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Protected Admin Routes
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/create', [AdminController::class, 'create'])->name('create');
    Route::post('/create', [AdminController::class, 'store'])->name('store');
    Route::get('/{dealer}/edit', [AdminController::class, 'edit'])->name('edit');
    Route::put('/{dealer}/edit', [AdminController::class, 'update'])->name('update');
    Route::delete('/{dealer}', [AdminController::class, 'destroy'])->name('destroy');
    Route::patch('/{dealer}/toggle-status', [AdminController::class, 'toggleStatus'])->name('toggle-status');
    
    // CSV Import/Export Routes
    Route::get('/import', [AdminController::class, 'showImport'])->name('import');
    Route::get('/export', [AdminController::class, 'exportCsv'])->name('export');
    Route::get('/template', [AdminController::class, 'downloadTemplate'])->name('template');
    Route::post('/import', [AdminController::class, 'importCsv'])->name('import.post');
    
    // State Management Routes
    Route::get('/states', [StateController::class, 'index'])->name('states.index');
    Route::get('/states/create', [StateController::class, 'create'])->name('states.create');
    Route::post('/states', [StateController::class, 'store'])->name('states.store');
    Route::get('/states/{state}/edit', [StateController::class, 'edit'])->name('states.edit');
    Route::put('/states/{state}', [StateController::class, 'update'])->name('states.update');
    Route::delete('/states/{state}', [StateController::class, 'destroy'])->name('states.destroy');
    Route::patch('/states/{state}/toggle-status', [StateController::class, 'toggleStatus'])->name('states.toggle-status');
    
    // District Management Routes
    Route::get('/districts', [DistrictController::class, 'index'])->name('districts.index');
    Route::get('/districts/create', [DistrictController::class, 'create'])->name('districts.create');
    Route::post('/districts', [DistrictController::class, 'store'])->name('districts.store');
    Route::get('/districts/{district}/edit', [DistrictController::class, 'edit'])->name('districts.edit');
    Route::put('/districts/{district}', [DistrictController::class, 'update'])->name('districts.update');
    Route::delete('/districts/{district}', [DistrictController::class, 'destroy'])->name('districts.destroy');
    Route::patch('/districts/{district}/toggle-status', [DistrictController::class, 'toggleStatus'])->name('districts.toggle-status');
    Route::get('/districts/by-state', [DistrictController::class, 'getByState'])->name('districts.by-state');
});
