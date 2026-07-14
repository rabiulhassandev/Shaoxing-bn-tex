@extends('layouts.admin')

@section('title', 'My Profile')

@section('content')
    <form method="POST" action="{{ route('admin.profile.password') }}" class="max-w-lg space-y-5 rounded-lg border border-stone-200 bg-white p-6">
        @csrf
        @method('PUT')

        <div>
            <h2 class="text-sm font-semibold text-stone-900">Change password</h2>
            <p class="mt-1 text-sm text-stone-500">Signed in as {{ auth()->user()->email }}</p>
        </div>

        <div>
            <x-input-label for="current_password" value="Current password" />
            <x-text-input id="current_password" name="current_password" type="password" class="mt-1" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('current_password')" />
        </div>

        <div>
            <x-input-label for="password" value="New password" />
            <x-text-input id="password" name="password" type="password" class="mt-1" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Confirm new password" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <x-primary-button>Update password</x-primary-button>
    </form>
@endsection
