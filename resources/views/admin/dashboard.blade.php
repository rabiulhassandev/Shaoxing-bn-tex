@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <a href="{{ route('admin.inquiries.index') }}" class="rounded-lg border border-stone-200 bg-white p-5 transition hover:border-brand-300">
            <p class="text-sm font-medium text-stone-500">New RFQ Inquiries</p>
            <p class="mt-2 text-3xl font-bold text-brand-800">{{ $newInquiries }}</p>
        </a>
        <a href="{{ route('admin.messages.index') }}" class="rounded-lg border border-stone-200 bg-white p-5 transition hover:border-brand-300">
            <p class="text-sm font-medium text-stone-500">Unread Messages</p>
            <p class="mt-2 text-3xl font-bold text-brand-800">{{ $unreadMessages }}</p>
        </a>
        <a href="{{ route('admin.fabrics.index') }}" class="rounded-lg border border-stone-200 bg-white p-5 transition hover:border-brand-300">
            <p class="text-sm font-medium text-stone-500">Active Fabrics</p>
            <p class="mt-2 text-3xl font-bold text-brand-800">{{ $activeFabrics }}</p>
        </a>
        <a href="{{ route('admin.posts.index') }}" class="rounded-lg border border-stone-200 bg-white p-5 transition hover:border-brand-300">
            <p class="text-sm font-medium text-stone-500">Published News</p>
            <p class="mt-2 text-3xl font-bold text-brand-800">{{ $publishedPosts }}</p>
        </a>
    </div>

    <div class="mt-8 grid grid-cols-1 gap-6 xl:grid-cols-2">
        <section class="rounded-lg border border-stone-200 bg-white">
            <div class="flex items-center justify-between border-b border-stone-200 px-5 py-4">
                <h2 class="text-sm font-semibold text-stone-900">Latest RFQ Inquiries</h2>
                <a href="{{ route('admin.inquiries.index') }}" class="text-sm font-medium text-brand-700 hover:text-brand-800">View all</a>
            </div>
            <div class="divide-y divide-stone-100">
                @forelse ($recentInquiries as $inquiry)
                    <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="flex items-center justify-between gap-4 px-5 py-3 transition hover:bg-stone-50">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-medium text-stone-900">{{ $inquiry->name }} — {{ $inquiry->company ?? 'No company' }}</p>
                            <p class="mt-0.5 text-xs text-stone-500">{{ $inquiry->items_count }} {{ Str::plural('fabric', $inquiry->items_count) }} · {{ $inquiry->created_at->diffForHumans() }}</p>
                        </div>
                        <x-status-badge :status="$inquiry->status" />
                    </a>
                @empty
                    <p class="px-5 py-8 text-center text-sm text-stone-500">No inquiries yet.</p>
                @endforelse
            </div>
        </section>

        <section class="rounded-lg border border-stone-200 bg-white">
            <div class="flex items-center justify-between border-b border-stone-200 px-5 py-4">
                <h2 class="text-sm font-semibold text-stone-900">Latest Contact Messages</h2>
                <a href="{{ route('admin.messages.index') }}" class="text-sm font-medium text-brand-700 hover:text-brand-800">View all</a>
            </div>
            <div class="divide-y divide-stone-100">
                @forelse ($recentMessages as $message)
                    <a href="{{ route('admin.messages.show', $message) }}" class="flex items-center justify-between gap-4 px-5 py-3 transition hover:bg-stone-50">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-medium text-stone-900">{{ $message->name }} — {{ $message->subject ?? 'No subject' }}</p>
                            <p class="mt-0.5 text-xs text-stone-500">{{ $message->created_at->diffForHumans() }}</p>
                        </div>
                        @unless ($message->is_read)
                            <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/20">Unread</span>
                        @endunless
                    </a>
                @empty
                    <p class="px-5 py-8 text-center text-sm text-stone-500">No messages yet.</p>
                @endforelse
            </div>
        </section>
    </div>
@endsection
