@extends('layouts.admin')

@section('title', 'Contact Messages')

@section('content')
    <div class="overflow-x-auto rounded-lg border border-stone-200 bg-white">
        <table class="min-w-full divide-y divide-stone-200 text-sm">
            <thead class="bg-stone-50 text-left text-xs font-semibold uppercase tracking-wider text-stone-500">
                <tr>
                    <th class="px-4 py-3">From</th>
                    <th class="px-4 py-3">Subject</th>
                    <th class="px-4 py-3">Received</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse ($messages as $message)
                    <tr class="hover:bg-stone-50 {{ $message->is_read ? '' : 'bg-blue-50/40' }}">
                        <td class="px-4 py-3">
                            <p class="font-medium text-stone-900">{{ $message->name }}</p>
                            <p class="mt-0.5 text-xs text-stone-500">{{ $message->email }}</p>
                        </td>
                        <td class="px-4 py-3 text-stone-600">{{ $message->subject ?? '—' }}</td>
                        <td class="px-4 py-3 text-stone-500">{{ $message->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-4 py-3">
                            @if ($message->is_read)
                                <span class="inline-flex rounded-full bg-stone-100 px-2.5 py-0.5 text-xs font-medium text-stone-600 ring-1 ring-inset ring-stone-500/20">Read</span>
                            @else
                                <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/20">Unread</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-4">
                                <a href="{{ route('admin.messages.show', $message) }}" class="text-sm font-medium text-brand-700 hover:text-brand-800">View</a>
                                <x-admin.delete-button :action="route('admin.messages.destroy', $message)" confirm="Delete this message?">Delete</x-admin.delete-button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-10 text-center text-stone-500">No messages yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $messages->links() }}</div>
@endsection
