<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\PincodeController;
use App\Models\Dealer;
use App\Http\Controllers\DealerRegistrationController;

// CORS helper for public APIs
$corsHeaders = function () {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Accept');
    if (request()->getMethod() === 'OPTIONS') {
        return response('', 200);
    }
    return null;
};

// Public API for main site dashboard (Store Locator stats) – read-only, CORS allowed
Route::get('/api/dealer-stats', function () use ($corsHeaders) {
    if ($r = $corsHeaders()) return $r;
    return response()->json([
        'success' => true,
        'total' => Dealer::count(),
        'active' => Dealer::active()->count(),
        'dealers' => Dealer::byType('dealer')->count(),
        'distributors' => Dealer::byType('distributor')->count(),
    ]);
});

// Public API: dealers/distributors by pincode (for checkout)
Route::get('/api/dealers-by-pincode', function () use ($corsHeaders) {
    if ($r = $corsHeaders()) return $r;
    $pincode = trim(request()->get('pincode', ''));
    if (strlen($pincode) !== 6 || !ctype_digit($pincode)) {
        return response()->json(['success' => false, 'message' => 'Invalid pincode', 'dealers' => []]);
    }
    $dealers = Dealer::active()
        ->with(['state', 'district'])
        ->where('pincode', $pincode)
        ->orderBy('type')
        ->orderBy('business_name')
        ->get()
        ->map(function ($d) {
            return [
                'name' => $d->business_name,
                'type' => $d->type,
                'contact' => $d->contact_person,
                'phone' => $d->phone,
                'alt_phone' => $d->alternate_phone,
                'address' => $d->address,
                'city' => $d->city,
                'state' => $d->state ? $d->state->name : null,
                'district' => $d->district ? $d->district->name : null,
                'pincode' => $d->pincode,
            ];
        });
    return response()->json(['success' => true, 'dealers' => $dealers]);
});

// Public API: pincode lookup (city, state for checkout auto-fill)
Route::get('/api/pincode-lookup', function () use ($corsHeaders) {
    if ($r = $corsHeaders()) return $r;
    $pincode = trim(request()->get('pincode', ''));
    if (strlen($pincode) !== 6 || !ctype_digit($pincode)) {
        return response()->json(['success' => false, 'message' => 'Invalid pincode', 'serviceable' => false]);
    }
    $record = \App\Models\Pincode::where('pincode', $pincode)->first();
    if (!$record) {
        return response()->json([
            'success' => true,
            'serviceable' => false,
            'city' => null,
            'state' => null,
            'district' => null,
        ]);
    }
    return response()->json([
        'success' => true,
        'serviceable' => (bool) $record->is_serviceable,
        'city' => $record->city,
        'state' => $record->state,
        'district' => $record->district,
    ]);
});

// Home page
Route::get('/', function () {
    return view('home');
})->name('home');

// Public merchant / dealer self-registration (pending until admin approves → status inactive → active)
Route::get('/register', [DealerRegistrationController::class, 'showForm'])->name('register');
Route::post('/register', [DealerRegistrationController::class, 'store'])->name('register.store');

Route::match(['GET', 'OPTIONS'], '/api/states', function () use ($corsHeaders) {
    if ($r = $corsHeaders()) return $r;
    return app(DealerRegistrationController::class)->apiStates();
});
Route::match(['GET', 'OPTIONS'], '/api/districts', function () use ($corsHeaders) {
    if ($r = $corsHeaders()) return $r;
    return app(DealerRegistrationController::class)->apiDistricts(request());
});
Route::match(['POST', 'OPTIONS'], '/api/dealer-register', function () use ($corsHeaders) {
    if ($r = $corsHeaders()) return $r;
    return app(DealerRegistrationController::class)->apiStore(request());
});

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

// Protected Admin Routes (specific routes MUST come before {dealer} catch-all)
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/create', [AdminController::class, 'create'])->name('create');
    Route::post('/create', [AdminController::class, 'store'])->name('store');

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

    // Pincode Management Routes (pincode by city)
    Route::get('/pincodes', [PincodeController::class, 'index'])->name('pincodes.index');
    Route::get('/pincodes/create', [PincodeController::class, 'create'])->name('pincodes.create');
    Route::post('/pincodes', [PincodeController::class, 'store'])->name('pincodes.store');
    Route::get('/pincodes/import', [PincodeController::class, 'showImport'])->name('pincodes.import');
    Route::get('/pincodes/export', [PincodeController::class, 'exportCsv'])->name('pincodes.export');
    Route::get('/pincodes/template', [PincodeController::class, 'downloadTemplate'])->name('pincodes.template');
    Route::post('/pincodes/import-india', [PincodeController::class, 'importIndiaPost'])->name('pincodes.import.india');
    Route::post('/pincodes/import', [PincodeController::class, 'importCsv'])->name('pincodes.import.post');
    Route::get('/pincodes/by-area', [PincodeController::class, 'getByArea'])->name('pincodes.by-area');
    Route::get('/pincodes/cities-by-state', [PincodeController::class, 'getCitiesByState'])->name('pincodes.cities-by-state');
    Route::get('/pincodes/districts-by-state', [PincodeController::class, 'getDistrictsByState'])->name('pincodes.districts-by-state');
    Route::post('/pincodes/apply-by-area', [PincodeController::class, 'applyByArea'])->name('pincodes.apply-by-area');
    Route::get('/pincodes/{pincode}/edit', [PincodeController::class, 'edit'])->name('pincodes.edit');
    Route::put('/pincodes/{pincode}', [PincodeController::class, 'update'])->name('pincodes.update');
    Route::delete('/pincodes/{pincode}', [PincodeController::class, 'destroy'])->name('pincodes.destroy');
    Route::patch('/pincodes/{pincode}/toggle-status', [PincodeController::class, 'toggleStatus'])->name('pincodes.toggle-status');

    // Dealer routes with {dealer} - numeric ID only, won't match 'pincodes', 'states', etc.
    Route::get('/{dealer}/edit', [AdminController::class, 'edit'])->name('edit')->where('dealer', '[0-9]+');
    Route::put('/{dealer}/edit', [AdminController::class, 'update'])->name('update')->where('dealer', '[0-9]+');
    Route::delete('/{dealer}', [AdminController::class, 'destroy'])->name('destroy')->where('dealer', '[0-9]+');
    Route::patch('/{dealer}/toggle-status', [AdminController::class, 'toggleStatus'])->name('toggle-status')->where('dealer', '[0-9]+');
});
