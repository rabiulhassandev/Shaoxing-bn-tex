@extends('layouts.admin')

@section('title', 'Message from '.$message->name)

@section('content')
    <div class="max-w-2xl space-y-6">
        <section class="rounded-lg border border-stone-200 bg-white p-6">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <h2 class="text-base font-semibold text-stone-900">{{ $message->subject ?? 'No subject' }}</h2>
                    <p class="mt-1 text-sm text-stone-500">
                        From <span class="font-medium text-stone-700">{{ $message->name }}</span>
                        &lt;<a href="mailto:{{ $message->email }}" class="text-brand-700 hover:text-brand-800">{{ $message->email }}</a>&gt;
                    </p>
                </div>
                <p class="text-sm text-stone-500">{{ $message->created_at->format('d M Y, H:i') }}</p>
            </div>
            <p class="mt-5 whitespace-pre-line text-sm leading-relaxed text-stone-700">{{ $message->message }}</p>
        </section>

        <div class="flex items-center justify-between">
            <a href="mailto:{{ $message->email }}?subject=Re: {{ rawurlencode($message->subject ?? 'Your message to us') }}">
                <x-primary-button>Reply by email</x-primary-button>
            </a>
            <x-admin.delete-button :action="route('admin.messages.destroy', $message)" confirm="Delete this message?">Delete message</x-admin.delete-button>
        </div>
    </div>
@endsection
