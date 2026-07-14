@extends('layouts.admin')

@section('title', 'RFQ Inquiries')

@section('content')
    <div class="mb-6 flex rounded-md border border-stone-200 bg-white p-1 w-fit">
        <a href="{{ route('admin.inquiries.index') }}"
            class="rounded px-4 py-1.5 text-sm font-medium transition {{ $status === null ? 'bg-brand-800 text-white' : 'text-stone-600 hover:text-stone-900' }}">All</a>
        @foreach (\App\Enums\InquiryStatus::cases() as $case)
            <a href="{{ route('admin.inquiries.index', ['status' => $case->value]) }}"
                class="rounded px-4 py-1.5 text-sm font-medium transition {{ $status === $case ? 'bg-brand-800 text-white' : 'text-stone-600 hover:text-stone-900' }}">
                {{ $case->label() }}
            </a>
        @endforeach
    </div>

    <div class="overflow-x-auto rounded-lg border border-stone-200 bg-white">
        <table class="min-w-full divide-y divide-stone-200 text-sm">
            <thead class="bg-stone-50 text-left text-xs font-semibold uppercase tracking-wider text-stone-500">
                <tr>
                    <th class="px-4 py-3">Buyer</th>
                    <th class="px-4 py-3">Country</th>
                    <th class="px-4 py-3">Fabrics</th>
                    <th class="px-4 py-3">Received</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse ($inquiries as $inquiry)
                    <tr class="hover:bg-stone-50">
                        <td class="px-4 py-3">
                            <p class="font-medium text-stone-900">{{ $inquiry->name }}</p>
                            <p class="mt-0.5 text-xs text-stone-500">{{ $inquiry->company ?? $inquiry->email }}</p>
                        </td>
                        <td class="px-4 py-3 text-stone-500">{{ $inquiry->country ?? '—' }}</td>
                        <td class="px-4 py-3 text-stone-500">{{ $inquiry->items_count }}</td>
                        <td class="px-4 py-3 text-stone-500">{{ $inquiry->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-4 py-3"><x-status-badge :status="$inquiry->status" /></td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-4">
                                <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="text-sm font-medium text-brand-700 hover:text-brand-800">View</a>
                                <x-admin.delete-button :action="route('admin.inquiries.destroy', $inquiry)" confirm="Delete this inquiry?">Delete</x-admin.delete-button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-stone-500">No inquiries found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $inquiries->links() }}</div>
@endsection
