<?php

namespace App\Providers;

use App\Enums\InquiryStatus;
use App\Models\ContactMessage;
use App\Models\Inquiry;
use App\Models\Setting;
use App\Services\InquiryBasket;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('login', fn (Request $request) => Limit::perMinute(5)->by($request->ip()));
        RateLimiter::for('submissions', fn (Request $request) => Limit::perMinute(10)->by($request->ip()));

        View::composer(['layouts.public', 'home', 'contact'], function (\Illuminate\View\View $view) {
            $settings = Setting::allCached();
            $whatsappDigits = preg_replace('/\D+/', '', $settings['whatsapp'] ?? '');

            $view->with('settings', $settings)
                ->with('whatsappUrl', $whatsappDigits ? 'https://wa.me/'.$whatsappDigits : null)
                ->with('basketCount', app(InquiryBasket::class)->count());
        });

        View::composer('layouts.admin', function (\Illuminate\View\View $view) {
            $view->with('settings', Setting::allCached())
                ->with('newInquiryCount', Inquiry::query()->where('status', InquiryStatus::New)->count())
                ->with('unreadMessageCount', ContactMessage::query()->where('is_read', false)->count());
        });
    }
}
