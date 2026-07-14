<?php

namespace App\Http\Controllers\Admin;

use App\Enums\InquiryStatus;
use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Fabric;
use App\Models\Inquiry;
use App\Models\Post;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'newInquiries' => Inquiry::query()->where('status', InquiryStatus::New)->count(),
            'unreadMessages' => ContactMessage::query()->where('is_read', false)->count(),
            'activeFabrics' => Fabric::query()->active()->count(),
            'publishedPosts' => Post::query()->where('is_published', true)->count(),
            'recentInquiries' => Inquiry::query()->withCount('items')->latest()->take(5)->get(),
            'recentMessages' => ContactMessage::query()->latest()->take(5)->get(),
        ]);
    }
}
