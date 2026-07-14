<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Dashboard') · Admin — {{ $settings['company_name'] ?? config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-stone-100 font-sans text-stone-900 antialiased">
    <div x-data="{ sidebarOpen: false }">
        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-30 bg-stone-950/50 lg:hidden"
            @click="sidebarOpen = false" aria-hidden="true"></div>

        <aside class="fixed inset-y-0 left-0 z-40 flex w-64 -translate-x-full flex-col bg-brand-950 transition-transform duration-200 lg:translate-x-0"
            :class="{ 'translate-x-0': sidebarOpen }">
            <div class="flex h-16 items-center border-b border-white/10 px-5">
                <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold tracking-widest text-white">
                    {{ strtoupper($settings['company_name'] ?? 'ADMIN') }}
                </a>
            </div>

            <nav class="flex-1 space-y-6 overflow-y-auto px-3 py-5">
                <div class="space-y-1">
                    <x-admin.nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">Dashboard</x-admin.nav-link>
                </div>

                <div class="space-y-1">
                    <p class="px-3 pb-1 text-xs font-semibold uppercase tracking-wider text-stone-500">Inbox</p>
                    <x-admin.nav-link :href="route('admin.inquiries.index')" :active="request()->routeIs('admin.inquiries.*')"
                        :badge="$newInquiryCount ?: null">RFQ Inquiries</x-admin.nav-link>
                    <x-admin.nav-link :href="route('admin.messages.index')" :active="request()->routeIs('admin.messages.*')"
                        :badge="$unreadMessageCount ?: null">Contact Messages</x-admin.nav-link>
                </div>

                <div class="space-y-1">
                    <p class="px-3 pb-1 text-xs font-semibold uppercase tracking-wider text-stone-500">Catalogue</p>
                    <x-admin.nav-link :href="route('admin.fabrics.index')" :active="request()->routeIs('admin.fabrics.*')">Fabrics</x-admin.nav-link>
                    <x-admin.nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">Categories</x-admin.nav-link>
                </div>

                <div class="space-y-1">
                    <p class="px-3 pb-1 text-xs font-semibold uppercase tracking-wider text-stone-500">Content</p>
                    <x-admin.nav-link :href="route('admin.hero-slides.index')" :active="request()->routeIs('admin.hero-slides.*')">Hero Slides</x-admin.nav-link>
                    <x-admin.nav-link :href="route('admin.stats.index')" :active="request()->routeIs('admin.stats.*')">Statistics</x-admin.nav-link>
                    <x-admin.nav-link :href="route('admin.pages.index')" :active="request()->routeIs('admin.pages.*')">Pages</x-admin.nav-link>
                    <x-admin.nav-link :href="route('admin.posts.index')" :active="request()->routeIs('admin.posts.*')">News</x-admin.nav-link>
                    <x-admin.nav-link :href="route('admin.partners.index')" :active="request()->routeIs('admin.partners.*')">Buyers &amp; Vendors</x-admin.nav-link>
                </div>

                <div class="space-y-1">
                    <p class="px-3 pb-1 text-xs font-semibold uppercase tracking-wider text-stone-500">System</p>
                    <x-admin.nav-link :href="route('admin.settings.edit')" :active="request()->routeIs('admin.settings.*')">Settings</x-admin.nav-link>
                    <x-admin.nav-link :href="route('admin.profile.edit')" :active="request()->routeIs('admin.profile.*')">My Profile</x-admin.nav-link>
                </div>
            </nav>
        </aside>

        <div class="flex min-h-screen flex-col lg:pl-64">
            <header class="sticky top-0 z-20 flex h-16 items-center justify-between gap-4 border-b border-stone-200 bg-white px-4 sm:px-6">
                <div class="flex items-center gap-3">
                    <button type="button" class="rounded-md p-2 text-stone-600 hover:bg-stone-100 lg:hidden"
                        @click="sidebarOpen = true" aria-label="Open menu">
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                    <h1 class="text-base font-semibold text-stone-900">@yield('title', 'Dashboard')</h1>
                </div>

                <div class="flex items-center gap-2 sm:gap-4">
                    <a href="{{ route('home') }}" target="_blank"
                        class="hidden text-sm font-medium text-stone-600 transition hover:text-stone-900 sm:block">View site &nearr;</a>
                    <span class="hidden text-sm text-stone-400 sm:block" aria-hidden="true">|</span>
                    <span class="hidden text-sm text-stone-600 md:block">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="rounded-md px-3 py-1.5 text-sm font-medium text-stone-600 transition hover:bg-stone-100 hover:text-stone-900">
                            Log out
                        </button>
                    </form>
                </div>
            </header>

            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                <x-flash />
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
