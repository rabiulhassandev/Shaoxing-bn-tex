<x-mail::message>
# New RFQ Inquiry

**{{ $inquiry->name }}**{{ $inquiry->company ? ' — '.$inquiry->company : '' }} has submitted an inquiry
for {{ $inquiry->items->count() }} {{ Str::plural('fabric', $inquiry->items->count()) }}.

- **Email:** {{ $inquiry->email }}
@if ($inquiry->country)
- **Country:** {{ $inquiry->country }}
@endif
@if ($inquiry->phone)
- **Phone / WhatsApp:** {{ $inquiry->phone }}
@endif

<x-mail::table>
| Fabric | Quantity | Target price |
|:-------|:---------|:-------------|
@foreach ($inquiry->items as $item)
| {{ $item->fabric_name }} | {{ $item->quantity ?? '—' }} | {{ $item->target_price ?? '—' }} |
@endforeach
</x-mail::table>

@if ($inquiry->message)
**Message:**

{{ $inquiry->message }}
@endif

<x-mail::button :url="route('admin.inquiries.show', $inquiry)">
View Inquiry
</x-mail::button>

{{ config('app.name') }}
</x-mail::message>
