@extends('layouts.admin')

@section('title', 'Pages')

@section('content')
    <p class="mb-6 text-sm text-stone-600">Content of the About, Sourcing &amp; Services and Sustainability pages.</p>

    <div class="overflow-x-auto rounded-lg border border-stone-200 bg-white">
        <table class="min-w-full divide-y divide-stone-200 text-sm">
            <thead class="bg-stone-50 text-left text-xs font-semibold uppercase tracking-wider text-stone-500">
                <tr>
                    <th class="px-4 py-3">Page</th>
                    <th class="px-4 py-3">URL</th>
                    <th class="px-4 py-3">Last updated</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @foreach ($pages as $page)
                    <tr class="hover:bg-stone-50">
                        <td class="px-4 py-3 font-medium text-stone-900">{{ $page->title }}</td>
                        <td class="px-4 py-3 text-stone-500">/{{ $page->slug }}</td>
                        <td class="px-4 py-3 text-stone-500">{{ $page->updated_at->format('d M Y, H:i') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-4">
                                <a href="{{ url($page->slug) }}" target="_blank" class="text-sm font-medium text-stone-500 hover:text-stone-700">View</a>
                                <a href="{{ route('admin.pages.edit', $page) }}" class="text-sm font-medium text-brand-700 hover:text-brand-800">Edit</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
