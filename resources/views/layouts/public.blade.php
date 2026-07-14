<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@hasSection('title')@yield('title') — {{ $settings['company_name'] ?? config('app.name') }}@else{{ $settings['company_name'] ?? config('app.name') }} — {{ $settings['tagline'] ?? '' }}@endif</title>
    <meta name="description" content="@yield('meta_description', $settings['meta_description'] ?? '')">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ $settings['company_name'] ?? config('app.name') }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@hasSection('title')@yield('title')@else{{ $settings['company_name'] ?? config('app.name') }}@endif">
    <meta property="og:description" content="@yield('meta_description', $settings['meta_description'] ?? '')">
    <meta property="og:url" content="{{ url()->current() }}">
    @hasSection('og_image')
        <meta property="og:image" content="@yield('og_image')">
    @endif
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-white font-sans text-stone-900 antialiased">
    <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded focus:bg-white focus:px-4 focus:py-2 focus:text-sm">Skip to content</a>

    <header class="sticky top-0 z-40 border-b border-stone-200 bg-white/95 backdrop-blur" x-data="{ mobileOpen: false }">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-6 px-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="shrink-0">
                <span class="block text-base font-bold leading-tight tracking-widest text-brand-900">{{ strtoupper($settings['company_name'] ?? config('app.name')) }}</span>
                <span class="block text-[11px] font-medium uppercase tracking-[0.2em] text-stone-500">Fabric Sourcing · China</span>
            </a>

            <nav class="hidden items-center gap-6 lg:flex" aria-label="Main">
                <a href="{{ route('fabrics.index') }}" class="text-sm font-medium transition {{ request()->routeIs('fabrics.*') ? 'text-brand-800' : 'text-stone-600 hover:text-stone-900' }}">Fabric Catalogue</a>
                <a href="{{ route('sourcing') }}" class="text-sm font-medium transition {{ request()->routeIs('sourcing') ? 'text-brand-800' : 'text-stone-600 hover:text-stone-900' }}">Sourcing</a>
                <a href="{{ route('sustainability') }}" class="text-sm font-medium transition {{ request()->routeIs('sustainability') ? 'text-brand-800' : 'text-stone-600 hover:text-stone-900' }}">Sustainability</a>
                <a href="{{ route('buyers') }}" class="text-sm font-medium transition {{ request()->routeIs('buyers') ? 'text-brand-800' : 'text-stone-600 hover:text-stone-900' }}">Our Buyers</a>
                <a href="{{ route('news.index') }}" class="text-sm font-medium transition {{ request()->routeIs('news.*') ? 'text-brand-800' : 'text-stone-600 hover:text-stone-900' }}">News</a>
                <a href="{{ route('about') }}" class="text-sm font-medium transition {{ request()->routeIs('about') ? 'text-brand-800' : 'text-stone-600 hover:text-stone-900' }}">About</a>
                <a href="{{ route('contact') }}" class="text-sm font-medium transition {{ request()->routeIs('contact') ? 'text-brand-800' : 'text-stone-600 hover:text-stone-900' }}">Contact</a>
            </nav>

            <div class="flex items-center gap-2">
                <a href="{{ route('inquiry.index') }}"
                    class="relative inline-flex items-center gap-2 rounded-md border border-brand-200 bg-brand-50 px-3 py-2 text-sm font-semibold text-brand-800 transition hover:bg-brand-100">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6M9 8h6M6.75 3.75h10.5a1.5 1.5 0 0 1 1.5 1.5v15a1.5 1.5 0 0 1-1.5 1.5H6.75a1.5 1.5 0 0 1-1.5-1.5v-15a1.5 1.5 0 0 1 1.5-1.5Z" />
                    </svg>
                    <span class="hidden sm:inline">Inquiry</span>
                    @if ($basketCount > 0)
                        <span class="inline-flex min-w-5 items-center justify-center rounded-full bg-brand-800 px-1.5 py-0.5 text-xs font-bold text-white">{{ $basketCount }}</span>
                    @endif
                </a>

                <button type="button" class="rounded-md p-2 text-stone-600 hover:bg-stone-100 lg:hidden"
                    @click="mobileOpen = ! mobileOpen" :aria-expanded="mobileOpen" aria-label="Toggle menu">
                    <svg x-show="! mobileOpen" class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <svg x-show="mobileOpen" x-cloak class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <nav x-show="mobileOpen" x-cloak x-transition.opacity class="border-t border-stone-200 bg-white lg:hidden" aria-label="Mobile">
            <div class="space-y-1 px-4 py-4 sm:px-6">
                <a href="{{ route('fabrics.index') }}" class="block rounded-md px-3 py-2 text-sm font-medium text-stone-700 hover:bg-stone-50">Fabric Catalogue</a>
                <a href="{{ route('sourcing') }}" class="block rounded-md px-3 py-2 text-sm font-medium text-stone-700 hover:bg-stone-50">Sourcing</a>
                <a href="{{ route('sustainability') }}" class="block rounded-md px-3 py-2 text-sm font-medium text-stone-700 hover:bg-stone-50">Sustainability</a>
                <a href="{{ route('buyers') }}" class="block rounded-md px-3 py-2 text-sm font-medium text-stone-700 hover:bg-stone-50">Our Buyers</a>
                <a href="{{ route('news.index') }}" class="block rounded-md px-3 py-2 text-sm font-medium text-stone-700 hover:bg-stone-50">News</a>
                <a href="{{ route('about') }}" class="block rounded-md px-3 py-2 text-sm font-medium text-stone-700 hover:bg-stone-50">About</a>
                <a href="{{ route('contact') }}" class="block rounded-md px-3 py-2 text-sm font-medium text-stone-700 hover:bg-stone-50">Contact</a>
            </div>
        </nav>
    </header>

    <main id="main" class="flex-1">
        @if (session('status'))
            <div class="mx-auto max-w-7xl px-4 pt-6 sm:px-6 lg:px-8">
                <x-flash />
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="mt-16 bg-brand-950 text-stone-300">
        <div class="mx-auto grid max-w-7xl grid-cols-1 gap-10 px-4 py-14 sm:grid-cols-2 sm:px-6 lg:grid-cols-4 lg:px-8">
            <div class="lg:col-span-2">
                <p class="text-sm font-bold tracking-widest text-white">{{ strtoupper($settings['company_name'] ?? config('app.name')) }}</p>
                <p class="mt-3 max-w-md text-sm leading-relaxed text-stone-400">{{ $settings['footer_note'] ?? '' }}</p>
                <p class="mt-4 text-sm text-stone-400">{{ $settings['address'] ?? '' }}</p>
            </div>

            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Explore</p>
                <ul class="mt-4 space-y-2 text-sm">
                    <li><a href="{{ route('fabrics.index') }}" class="transition hover:text-white">Fabric Catalogue</a></li>
                    <li><a href="{{ route('sourcing') }}" class="transition hover:text-white">Sourcing &amp; Services</a></li>
                    <li><a href="{{ route('sustainability') }}" class="transition hover:text-white">Sustainability &amp; Quality</a></li>
                    <li><a href="{{ route('buyers') }}" class="transition hover:text-white">Our Buyers</a></li>
                    <li><a href="{{ route('news.index') }}" class="transition hover:text-white">News</a></li>
                    <li><a href="{{ route('about') }}" class="transition hover:text-white">About Us</a></li>
                </ul>
            </div>

            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Contact</p>
                <ul class="mt-4 space-y-2 text-sm">
                    @if (! empty($settings['contact_email']))
                        <li><a href="mailto:{{ $settings['contact_email'] }}" class="transition hover:text-white">{{ $settings['contact_email'] }}</a></li>
                    @endif
                    @if (! empty($settings['phone']))
                        <li>{{ $settings['phone'] }}</li>
                    @endif
                    @if ($whatsappUrl)
                        <li><a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="transition hover:text-white">WhatsApp: {{ $settings['whatsapp'] }}</a></li>
                    @endif
                    @if (! empty($settings['wechat_id']))
                        <li>WeChat: {{ $settings['wechat_id'] }}</li>
                    @endif
                    <li class="pt-2">
                        <a href="{{ route('inquiry.index') }}" class="font-semibold text-white underline decoration-brand-500 underline-offset-4 transition hover:decoration-white">Start an inquiry &rarr;</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10">
            <p class="mx-auto max-w-7xl px-4 py-5 text-xs text-stone-500 sm:px-6 lg:px-8">
                &copy; {{ now()->year }} {{ $settings['company_name'] ?? config('app.name') }}. All rights reserved.
            </p>
        </div>
    </footer>
</body>
</html>
