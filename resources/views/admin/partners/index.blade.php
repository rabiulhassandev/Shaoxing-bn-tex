@extends('layouts.admin')

@section('title', 'Buyers & Vendors')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div class="flex rounded-md border border-stone-200 bg-white p-1">
            @foreach (\App\Enums\PartnerType::cases() as $case)
                <a href="{{ route('admin.partners.index', ['type' => $case->value]) }}"
                    class="rounded px-4 py-1.5 text-sm font-medium transition {{ $type === $case ? 'bg-brand-800 text-white' : 'text-stone-600 hover:text-stone-900' }}">
                    {{ $case->label() }}s
                </a>
            @endforeach
        </div>
        <a href="{{ route('admin.partners.create', ['type' => $type->value]) }}">
            <x-primary-button>Add {{ strtolower($type->label()) }}</x-primary-button>
        </a>
    </div>

    <div class="overflow-x-auto rounded-lg border border-stone-200 bg-white">
        <table class="min-w-full divide-y divide-stone-200 text-sm">
            <thead class="bg-stone-50 text-left text-xs font-semibold uppercase tracking-wider text-stone-500">
                <tr>
                    <th class="px-4 py-3">Logo</th>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Website</th>
                    <th class="px-4 py-3">Sort</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse ($partners as $partner)
                    <tr class="hover:bg-stone-50">
                        <td class="px-4 py-3">
                            @if ($partner->logo_url)
                                <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" class="h-10 w-20 rounded border border-stone-100 object-contain">
                            @else
                                <div class="h-10 w-20 rounded bg-stone-100"></div>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-medium text-stone-900">{{ $partner->name }}</td>
                        <td class="px-4 py-3 text-stone-500">{{ $partner->website ?? '—' }}</td>
                        <td class="px-4 py-3 text-stone-500">{{ $partner->sort_order }}</td>
                        <td class="px-4 py-3">
                            @if ($partner->is_active)
                                <span class="inline-flex rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Active</span>
                            @else
                                <span class="inline-flex rounded-full bg-stone-100 px-2.5 py-0.5 text-xs font-medium text-stone-600 ring-1 ring-inset ring-stone-500/20">Hidden</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-4">
                                <a href="{{ route('admin.partners.edit', $partner) }}" class="text-sm font-medium text-brand-700 hover:text-brand-800">Edit</a>
                                <x-admin.delete-button :action="route('admin.partners.destroy', $partner)" confirm="Delete this partner?">Delete</x-admin.delete-button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-stone-500">No {{ strtolower($type->label()) }}s yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $partners->links() }}</div>
@endsection
