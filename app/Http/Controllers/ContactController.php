<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactMessageRequest;
use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(): View
    {
        return view('contact');
    }

    public function store(ContactMessageRequest $request): RedirectResponse
    {
        if ($request->filled('website')) {
            return redirect()->route('contact')->with('status', 'Thank you for your message. We will get back to you within one working day.');
        }

        $message = ContactMessage::query()->create($request->validated());

        if ($notificationEmail = Setting::get('notification_email')) {
            Mail::to($notificationEmail)->send(new ContactMessageMail($message));
        }

        return redirect()->route('contact')->with('status', 'Thank you for your message. We will get back to you within one working day.');
    }
}
