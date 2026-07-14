@extends('layouts.admin')

@section('title', 'Site Settings')

@section('content')
    <form method="POST" action="{{ route('admin.settings.update') }}" class="max-w-3xl space-y-6">
        @csrf
        @method('PUT')

        <section class="space-y-5 rounded-lg border border-stone-200 bg-white p-6">
            <h2 class="text-sm font-semibold uppercase tracking-wider text-stone-500">Company</h2>
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-input-label for="company_name" value="Company name" />
                    <x-text-input id="company_name" name="company_name" class="mt-1" :value="old('company_name', $values['company_name'] ?? '')" required />
                    <x-input-error :messages="$errors->get('company_name')" />
                </div>
                <div>
                    <x-input-label for="tagline" value="Tagline" />
                    <x-text-input id="tagline" name="tagline" class="mt-1" :value="old('tagline', $values['tagline'] ?? '')" />
                    <x-input-error :messages="$errors->get('tagline')" />
                </div>
            </div>
            <div>
                <x-input-label for="footer_note" value="Footer note" />
                <x-textarea-input id="footer_note" name="footer_note" rows="2" class="mt-1">{{ old('footer_note', $values['footer_note'] ?? '') }}</x-textarea-input>
                <x-input-error :messages="$errors->get('footer_note')" />
            </div>
        </section>

        <section class="space-y-5 rounded-lg border border-stone-200 bg-white p-6">
            <h2 class="text-sm font-semibold uppercase tracking-wider text-stone-500">Contact details</h2>
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-input-label for="contact_email" value="Public contact email" />
                    <x-text-input id="contact_email" name="contact_email" type="email" class="mt-1" :value="old('contact_email', $values['contact_email'] ?? '')" />
                    <x-input-error :messages="$errors->get('contact_email')" />
                </div>
                <div>
                    <x-input-label for="notification_email" value="Notification email (receives RFQs & messages)" />
                    <x-text-input id="notification_email" name="notification_email" type="email" class="mt-1" :value="old('notification_email', $values['notification_email'] ?? '')" />
                    <x-input-error :messages="$errors->get('notification_email')" />
                </div>
                <div>
                    <x-input-label for="phone" value="Phone" />
                    <x-text-input id="phone" name="phone" class="mt-1" :value="old('phone', $values['phone'] ?? '')" />
                    <x-input-error :messages="$errors->get('phone')" />
                </div>
                <div>
                    <x-input-label for="whatsapp" value="WhatsApp number" />
                    <x-text-input id="whatsapp" name="whatsapp" class="mt-1" :value="old('whatsapp', $values['whatsapp'] ?? '')" placeholder="+86 138 0000 0000" />
                    <x-input-error :messages="$errors->get('whatsapp')" />
                </div>
                <div>
                    <x-input-label for="wechat_id" value="WeChat ID" />
                    <x-text-input id="wechat_id" name="wechat_id" class="mt-1" :value="old('wechat_id', $values['wechat_id'] ?? '')" />
                    <x-input-error :messages="$errors->get('wechat_id')" />
                </div>
            </div>
            <div>
                <x-input-label for="address" value="Address" />
                <x-textarea-input id="address" name="address" rows="2" class="mt-1">{{ old('address', $values['address'] ?? '') }}</x-textarea-input>
                <x-input-error :messages="$errors->get('address')" />
            </div>
        </section>

        <section class="space-y-5 rounded-lg border border-stone-200 bg-white p-6">
            <h2 class="text-sm font-semibold uppercase tracking-wider text-stone-500">Homepage</h2>
            <div>
                <x-input-label for="home_intro_heading" value="Intro heading" />
                <x-text-input id="home_intro_heading" name="home_intro_heading" class="mt-1" :value="old('home_intro_heading', $values['home_intro_heading'] ?? '')" />
                <x-input-error :messages="$errors->get('home_intro_heading')" />
            </div>
            <div>
                <x-input-label for="home_intro_text" value="Intro text" />
                <x-textarea-input id="home_intro_text" name="home_intro_text" rows="4" class="mt-1">{{ old('home_intro_text', $values['home_intro_text'] ?? '') }}</x-textarea-input>
                <x-input-error :messages="$errors->get('home_intro_text')" />
            </div>
        </section>

        <section class="space-y-5 rounded-lg border border-stone-200 bg-white p-6">
            <h2 class="text-sm font-semibold uppercase tracking-wider text-stone-500">SEO</h2>
            <div>
                <x-input-label for="meta_description" value="Default meta description" />
                <x-textarea-input id="meta_description" name="meta_description" rows="2" class="mt-1">{{ old('meta_description', $values['meta_description'] ?? '') }}</x-textarea-input>
                <x-input-error :messages="$errors->get('meta_description')" />
            </div>
        </section>

        <x-primary-button>Save settings</x-primary-button>
    </form>
@endsection
