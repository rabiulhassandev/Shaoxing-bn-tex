<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin Login — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen items-center justify-center bg-brand-950 px-4 font-sans antialiased">
    <div class="w-full max-w-sm">
        <div class="mb-8 text-center">
            <p class="text-lg font-bold tracking-widest text-white">SHAOXING BN TEX</p>
            <p class="mt-1 text-sm text-stone-400">Administration Panel</p>
        </div>

        <div class="rounded-lg bg-white p-6 shadow-lg sm:p-8">
            <form method="POST" action="{{ route('admin.login.store') }}" class="space-y-5">
                @csrf

                <div>
                    <x-input-label for="email" value="Email address" />
                    <x-text-input id="email" name="email" type="email" class="mt-1" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" />
                </div>

                <div>
                    <x-input-label for="password" value="Password" />
                    <x-text-input id="password" name="password" type="password" class="mt-1" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" />
                </div>

                <label class="flex items-center gap-2" for="remember">
                    <x-checkbox-input id="remember" name="remember" />
                    <span class="text-sm text-stone-600">Remember me</span>
                </label>

                <x-primary-button class="w-full">Log in</x-primary-button>
            </form>
        </div>
    </div>
</body>
</html>
