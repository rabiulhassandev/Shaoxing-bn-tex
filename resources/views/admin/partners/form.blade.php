@extends('layouts.admin')

@section('title', $partner->exists ? 'Edit Partner' : 'Add Partner')

@section('content')
    <form method="POST" enctype="multipart/form-data"
        action="{{ $partner->exists ? route('admin.partners.update', $partner) : route('admin.partners.store') }}"
        class="max-w-2xl space-y-5 rounded-lg border border-stone-200 bg-white p-6">
        @csrf
        @if ($partner->exists)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <x-input-label for="name" value="Company name" />
                <x-text-input id="name" name="name" class="mt-1" :value="old('name', $partner->name)" required />
                <x-input-error :messages="$errors->get('name')" />
            </div>
            <div>
                <x-input-label for="type" value="Type" />
                <x-select-input id="type" name="type" class="mt-1" required>
                    @foreach (\App\Enums\PartnerType::cases() as $case)
                        <option value="{{ $case->value }}" @selected(old('type', $partner->type?->value) === $case->value)>{{ $case->label() }}</option>
                    @endforeach
                </x-select-input>
                <x-input-error :messages="$errors->get('type')" />
            </div>
        </div>

        <div>
            <x-input-label for="website" value="Website (optional)" />
            <x-text-input id="website" name="website" type="url" class="mt-1" :value="old('website', $partner->website)" placeholder="https://…" />
            <x-input-error :messages="$errors->get('website')" />
        </div>

        <div>
            <x-input-label for="logo" value="Logo" />
            @if ($partner->logo_url)
                <img src="{{ $partner->logo_url }}" alt="" class="mt-2 h-16 w-32 rounded border border-stone-100 object-contain">
            @endif
            <input id="logo" name="logo" type="file" accept="image/*"
                class="mt-2 block w-full text-sm text-stone-600 file:mr-3 file:rounded-md file:border-0 file:bg-brand-50 file:px-3 file:py-2 file:text-sm file:font-medium file:text-brand-700 hover:file:bg-brand-100">
            <x-input-error :messages="$errors->get('logo')" />
        </div>

        <div class="flex flex-wrap items-end gap-6">
            <div class="w-32">
                <x-input-label for="sort_order" value="Sort order" />
                <x-text-input id="sort_order" name="sort_order" type="number" min="0" class="mt-1" :value="old('sort_order', $partner->sort_order ?? 0)" />
                <x-input-error :messages="$errors->get('sort_order')" />
            </div>
            <label class="flex items-center gap-2 pb-2">
                <input type="hidden" name="is_active" value="0">
                <x-checkbox-input name="is_active" value="1" :checked="(bool) old('is_active', $partner->is_active ?? true)" />
                <span class="text-sm text-stone-700">Active (visible on the website)</span>
            </label>
        </div>

        <div class="flex items-center gap-3 border-t border-stone-100 pt-5">
            <x-primary-button>{{ $partner->exists ? 'Save changes' : 'Create partner' }}</x-primary-button>
            <a href="{{ route('admin.partners.index') }}" class="text-sm font-medium text-stone-600 hover:text-stone-900">Cancel</a>
        </div>
    </form>
@endsection
