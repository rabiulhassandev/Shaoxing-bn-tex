@extends('layouts.admin')

@section('title', 'Inquiry #'.$inquiry->id)

@section('content')
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="space-y-6 xl:col-span-2">
            <section class="rounded-lg border border-stone-200 bg-white">
                <div class="border-b border-stone-200 px-5 py-4">
                    <h2 class="text-sm font-semibold text-stone-900">Requested fabrics ({{ $inquiry->items->count() }})</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-stone-200 text-sm">
                        <thead class="bg-stone-50 text-left text-xs font-semibold uppercase tracking-wider text-stone-500">
                            <tr>
                                <th class="px-4 py-3">Fabric</th>
                                <th class="px-4 py-3">Quantity</th>
                                <th class="px-4 py-3">Target price</th>
                                <th class="px-4 py-3">Note</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @foreach ($inquiry->items as $item)
                                <tr>
                                    <td class="px-4 py-3">
                                        @if ($item->fabric)
                                            <a href="{{ route('admin.fabrics.edit', $item->fabric) }}" class="font-medium text-brand-700 hover:text-brand-800">{{ $item->fabric_name }}</a>
                                        @else
                                            <span class="font-medium text-stone-900">{{ $item->fabric_name }}</span>
                                            <span class="ml-1 text-xs text-stone-400">(removed)</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-stone-600">{{ $item->quantity ?? '—' }}</td>
                                    <td class="px-4 py-3 text-stone-600">{{ $item->target_price ?? '—' }}</td>
                                    <td class="px-4 py-3 text-stone-600">{{ $item->note ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            @if ($inquiry->message)
                <section class="rounded-lg border border-stone-200 bg-white p-5">
                    <h2 class="text-sm font-semibold text-stone-900">Message from buyer</h2>
                    <p class="mt-3 whitespace-pre-line text-sm leading-relaxed text-stone-600">{{ $inquiry->message }}</p>
                </section>
            @endif
        </div>

        <div class="space-y-6">
            <section class="rounded-lg border border-stone-200 bg-white p-5">
                <h2 class="text-sm font-semibold text-stone-900">Buyer details</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div>
                        <dt class="text-stone-500">Name</dt>
                        <dd class="font-medium text-stone-900">{{ $inquiry->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-stone-500">Email</dt>
                        <dd><a href="mailto:{{ $inquiry->email }}" class="font-medium text-brand-700 hover:text-brand-800">{{ $inquiry->email }}</a></dd>
                    </div>
                    <div>
                        <dt class="text-stone-500">Company</dt>
                        <dd class="font-medium text-stone-900">{{ $inquiry->company ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-stone-500">Country</dt>
                        <dd class="font-medium text-stone-900">{{ $inquiry->country ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-stone-500">Phone / WhatsApp</dt>
                        <dd class="font-medium text-stone-900">{{ $inquiry->phone ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-stone-500">Received</dt>
                        <dd class="font-medium text-stone-900">{{ $inquiry->created_at->format('d M Y, H:i') }}</dd>
                    </div>
                </dl>
            </section>

            <section class="rounded-lg border border-stone-200 bg-white p-5">
                <h2 class="text-sm font-semibold text-stone-900">Status</h2>
                <form method="POST" action="{{ route('admin.inquiries.update', $inquiry) }}" class="mt-4 space-y-3">
                    @csrf
                    @method('PUT')
                    <x-select-input name="status">
                        @foreach (\App\Enums\InquiryStatus::cases() as $case)
                            <option value="{{ $case->value }}" @selected($inquiry->status === $case)>{{ $case->label() }}</option>
                        @endforeach
                    </x-select-input>
                    <x-input-error :messages="$errors->get('status')" />
                    <x-primary-button class="w-full">Update status</x-primary-button>
                </form>
            </section>

            <div class="flex justify-end">
                <x-admin.delete-button :action="route('admin.inquiries.destroy', $inquiry)" confirm="Delete this inquiry?">Delete inquiry</x-admin.delete-button>
            </div>
        </div>
    </div>
@endsection
