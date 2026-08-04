<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Api\AnnouncementController;
use Illuminate\Support\Facades\Route;

// API (for header/footer JS)
Route::get('/api/announcement', [AnnouncementController::class, 'index']);

// Home
Route::get('/', [PageController::class, 'show'])->defaults('slug', 'index')->name('home');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// All other static pages (same URL as original .html, without extension)
$staticSlugs = [
    'about-us', 'abt', 'career', 'certificates', 'contact', 'story', 'news-events', 'news-single',
    'datasheet', 'user-manual', 'suggestions-grievances', 'privacy-policy', 'terms-conditions', 'refund-policy',
    'power-inverter', 'power-battery', 'solar-inverter', 'solar-street-light', 'bms', 'electric-cycle',
    'bms-1s', 'bms-2s', 'bms-3s', 'bms-4s', 'bms-8s', 'bms-10s', 'bms-12s', 'bms-16s',
    'ligen-power-300', 'ligen-power-850', 'ligen-power-1000', 'ligen-power-1500', 'ligen-power-2000',
    'ligen-power-3500', 'ligen-power-5000', 'ligen-power-600s',
    'ligen-inv300-pwm', 'ligen-inv600-pwm', 'ligen-inv850-pwm', 'ligen-inv1000-pwm', 'ligen-inv2000-pwm',
    'ligen-inv2000-24vdc', 'ligen-inv5000-48vdc', 'ligen-inv5000-96vdc', 'ligen-rrv1500-pwm',
    '48w-hybrid-solar-street-light', '24w-hybrid-solar-street-light', '48v-lfp-batteries',
    '12v-100ah-lfp-battery', '36v-15ah-lfp-battery',
    'checkout', 'order-success', 'tv-narendran-iit-patna-visit',
    'dashboard', 'configure-and-test-smtp', 'test-email', 'test-smtp-now', 'test-smtp-integration', 'test-menu',
];

foreach ($staticSlugs as $slug) {
    Route::get('/' . $slug, [PageController::class, 'show'])->defaults('slug', $slug)->name('page.' . str_replace(['-', '.'], '_', $slug));
}
