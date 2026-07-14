@props(['status'])

@php
    $classes = match ($status) {
        \App\Enums\InquiryStatus::New => 'bg-blue-50 text-blue-700 ring-blue-600/20',
        \App\Enums\InquiryStatus::InProgress => 'bg-amber-50 text-amber-700 ring-amber-600/20',
        \App\Enums\InquiryStatus::Closed => 'bg-stone-100 text-stone-600 ring-stone-500/20',
    };
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset '.$classes]) }}>
    {{ $status->label() }}
</span>
