@extends('layouts.admin')

@section('title', 'News')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-stone-600">Company updates, trade-fair announcements and industry news.</p>
        <a href="{{ route('admin.posts.create') }}">
            <x-primary-button>Add post</x-primary-button>
        </a>
    </div>

    <div class="overflow-x-auto rounded-lg border border-stone-200 bg-white">
        <table class="min-w-full divide-y divide-stone-200 text-sm">
            <thead class="bg-stone-50 text-left text-xs font-semibold uppercase tracking-wider text-stone-500">
                <tr>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Published</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse ($posts as $post)
                    <tr class="hover:bg-stone-50">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                @if ($post->image_url)
                                    <img src="{{ $post->image_url }}" alt="" class="h-10 w-16 rounded object-cover">
                                @else
                                    <div class="h-10 w-16 rounded bg-stone-100"></div>
                                @endif
                                <p class="font-medium text-stone-900">{{ $post->title }}</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-stone-500">{{ $post->published_at?->format('d M Y') ?? '—' }}</td>
                        <td class="px-4 py-3">
                            @if ($post->is_published)
                                <span class="inline-flex rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Published</span>
                            @else
                                <span class="inline-flex rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">Draft</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-4">
                                <a href="{{ route('admin.posts.edit', $post) }}" class="text-sm font-medium text-brand-700 hover:text-brand-800">Edit</a>
                                <x-admin.delete-button :action="route('admin.posts.destroy', $post)" confirm="Delete this post?">Delete</x-admin.delete-button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-10 text-center text-stone-500">No posts yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $posts->links() }}</div>
@endsection
