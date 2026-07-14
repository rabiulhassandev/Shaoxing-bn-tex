@extends('layouts.admin')

@section('title', $stat->exists ? 'Edit Statistic' : 'Add Statistic')

@section('content')
    <form method="POST"
        action="{{ $stat->exists ? route('admin.stats.update', $stat) : route('admin.stats.store') }}"
        class="max-w-2xl space-y-5 rounded-lg border border-stone-200 bg-white p-6">
        @csrf
        @if ($stat->exists)
            @method('PUT')
        @endif

        <div>
            <x-input-label for="label" value="Label (e.g. Years of Experience)" />
            <x-text-input id="label" name="label" class="mt-1" :value="old('label', $stat->label)" required />
            <x-input-error :messages="$errors->get('label')" />
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div>
                <x-input-label for="value" value="Value (e.g. 12)" />
                <x-text-input id="value" name="value" class="mt-1" :value="old('value', $stat->value)" required />
                <x-input-error :messages="$errors->get('value')" />
            </div>
            <div>
                <x-input-label for="suffix" value="Suffix (e.g. + or M+)" />
                <x-text-input id="suffix" name="suffix" class="mt-1" :value="old('suffix', $stat->suffix)" />
                <x-input-error :messages="$errors->get('suffix')" />
            </div>
            <div>
                <x-input-label for="sort_order" value="Sort order" />
                <x-text-input id="sort_order" name="sort_order" type="number" min="0" class="mt-1" :value="old('sort_order', $stat->sort_order ?? 0)" />
                <x-input-error :messages="$errors->get('sort_order')" />
            </div>
        </div>

        <div class="flex items-center gap-3 border-t border-stone-100 pt-5">
            <x-primary-button>{{ $stat->exists ? 'Save changes' : 'Create statistic' }}</x-primary-button>
            <a href="{{ route('admin.stats.index') }}" class="text-sm font-medium text-stone-600 hover:text-stone-900">Cancel</a>
        </div>
    </form>
@endsection
