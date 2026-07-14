@extends('layouts.public')

@section('title', 'Contact Us')
@section('meta_description', 'Contact SHAOXING BN TEX for fabric sourcing from China — by email, WhatsApp, WeChat or the contact form. We respond within one working day.')

@section('content')
    <div class="border-b border-stone-200 bg-stone-50">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <x-section-heading eyebrow="Contact" title="Get in touch"
                subtitle="Questions about a fabric, shipping terms or sampling? Send a message — we reply within one working day." />
        </div>
    </div>

    <div class="mx-auto grid max-w-7xl grid-cols-1 gap-10 px-4 py-14 sm:px-6 lg:grid-cols-3 lg:px-8">
        <form method="POST" action="{{ route('contact.store') }}" class="space-y-5 lg:col-span-2">
            @csrf
            <div class="hidden" aria-hidden="true">
                <label for="website">Leave this field empty</label>
                <input id="website" name="website" type="text" tabindex="-1" autocomplete="off">
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-input-label for="name" value="Your name" />
                    <x-text-input id="name" name="name" class="mt-1" :value="old('name')" required />
                    <x-input-error :messages="$errors->get('name')" />
                </div>
                <div>
                    <x-input-label for="email" value="Email address" />
                    <x-text-input id="email" name="email" type="email" class="mt-1" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" />
                </div>
            </div>

            <div>
                <x-input-label for="subject" value="Subject (optional)" />
                <x-text-input id="subject" name="subject" class="mt-1" :value="old('subject')" />
                <x-input-error :messages="$errors->get('subject')" />
            </div>

            <div>
                <x-input-label for="message" value="Message" />
                <x-textarea-input id="message" name="message" rows="6" class="mt-1" required>{{ old('message') }}</x-textarea-input>
                <x-input-error :messages="$errors->get('message')" />
            </div>

            <x-primary-button>Send message</x-primary-button>
            <p class="text-xs text-stone-500">Looking for fabric pricing? Use the <a href="{{ route('fabrics.index') }}" class="font-medium text-brand-700 underline underline-offset-2">catalogue</a> and submit an <a href="{{ route('inquiry.index') }}" class="font-medium text-brand-700 underline underline-offset-2">inquiry basket</a> instead — you'll get a consolidated quotation faster.</p>
        </form>

        <aside class="space-y-6">
            <div class="rounded-lg border border-stone-200 bg-white p-6">
                <h2 class="text-sm font-semibold uppercase tracking-wider text-stone-500">Company details</h2>
                <ul class="mt-4 space-y-3 text-sm text-stone-700">
                    @if (! empty($settings['address']))
                        <li>{{ $settings['address'] }}</li>
                    @endif
                    @if (! empty($settings['contact_email']))
                        <li><a href="mailto:{{ $settings['contact_email'] }}" class="font-medium text-brand-700 transition hover:text-brand-800">{{ $settings['contact_email'] }}</a></li>
                    @endif
                    @if (! empty($settings['phone']))
                        <li>{{ $settings['phone'] }}</li>
                    @endif
                </ul>
            </div>

            <div class="rounded-lg border border-stone-200 bg-white p-6">
                <h2 class="text-sm font-semibold uppercase tracking-wider text-stone-500">Direct messaging</h2>
                <ul class="mt-4 space-y-3 text-sm">
                    @if ($whatsappUrl)
                        <li>
                            <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener"
                                class="inline-flex items-center gap-2 rounded-md bg-green-600 px-4 py-2.5 font-semibold text-white transition hover:bg-green-700">
                                WhatsApp: {{ $settings['whatsapp'] }}
                            </a>
                        </li>
                    @endif
                    @if (! empty($settings['wechat_id']))
                        <li class="text-stone-700">WeChat ID: <span class="font-semibold">{{ $settings['wechat_id'] }}</span></li>
                    @endif
                </ul>
                <p class="mt-4 text-xs leading-relaxed text-stone-500">We work across time zones — messages sent outside Chinese business hours are answered the next working morning.</p>
            </div>
        </aside>
    </div>
@endsection
