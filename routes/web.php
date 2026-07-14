<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FabricController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryBasketController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/about', [PageController::class, 'show'])->defaults('slug', 'about')->name('about');
Route::get('/sourcing', [PageController::class, 'show'])->defaults('slug', 'sourcing')->name('sourcing');
Route::get('/sustainability', [PageController::class, 'show'])->defaults('slug', 'sustainability')->name('sustainability');

Route::get('/buyers', PartnerController::class)->name('buyers');

Route::get('/fabrics', [FabricController::class, 'index'])->name('fabrics.index');
Route::get('/fabrics/{fabric}', [FabricController::class, 'show'])->name('fabrics.show');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{post}', [NewsController::class, 'show'])->name('news.show');

Route::get('/inquiry', [InquiryBasketController::class, 'index'])->name('inquiry.index');
Route::post('/inquiry', [InquiryBasketController::class, 'store'])->middleware('throttle:submissions')->name('inquiry.store');
Route::post('/inquiry/{fabric}', [InquiryBasketController::class, 'add'])->name('inquiry.add');
Route::delete('/inquiry/{fabric}', [InquiryBasketController::class, 'remove'])->name('inquiry.remove');

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:submissions')->name('contact.store');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [Admin\AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [Admin\AuthController::class, 'login'])->middleware('throttle:login')->name('login.store');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/', Admin\DashboardController::class)->name('dashboard');
        Route::post('logout', [Admin\AuthController::class, 'logout'])->name('logout');

        Route::resource('categories', Admin\FabricCategoryController::class)->except(['show']);
        Route::resource('fabrics', Admin\FabricController::class)->except(['show']);
        Route::delete('fabric-images/{fabricImage}', [Admin\FabricController::class, 'destroyImage'])->name('fabric-images.destroy');
        Route::resource('posts', Admin\PostController::class)->except(['show']);
        Route::resource('partners', Admin\PartnerController::class)->except(['show']);
        Route::resource('hero-slides', Admin\HeroSlideController::class)->except(['show']);
        Route::resource('stats', Admin\StatController::class)->except(['show']);
        Route::resource('pages', Admin\PageController::class)->only(['index', 'edit', 'update']);
        Route::resource('inquiries', Admin\InquiryController::class)->only(['index', 'show', 'update', 'destroy']);
        Route::resource('messages', Admin\ContactMessageController::class)->only(['index', 'show', 'destroy']);

        Route::get('settings', [Admin\SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [Admin\SettingController::class, 'update'])->name('settings.update');

        Route::get('profile', [Admin\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile/password', [Admin\ProfileController::class, 'updatePassword'])->name('profile.password');
    });
});
