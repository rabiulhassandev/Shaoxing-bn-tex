@extends('layouts.public')

@section('title', 'Inquiry Basket')
@section('meta_description', 'Review the fabrics in your inquiry basket and submit one consolidated request for quotation.')

@section('content')
    <div class="border-b border-stone-200 bg-stone-50">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <x-section-heading eyebrow="RFQ" title="Your Inquiry Basket"
                subtitle="Review your selected fabrics, add quantities and target prices, then submit one consolidated request for quotation." />
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        @if (session('inquirySubmitted'))
            <div class="mx-auto max-w-xl rounded-lg border border-green-200 bg-green-50 px-8 py-14 text-center">
                <div class="mx-auto flex size-12 items-center justify-center rounded-full bg-green-100">
                    <svg class="size-6 text-green-700" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                </div>
                <h2 class="mt-5 text-xl font-bold text-stone-900">Inquiry sent — thank you!</h2>
                <p class="mt-3 text-sm leading-relaxed text-stone-600">Our sourcing team has received your request and will reply with a consolidated quotation, usually within one working day.</p>
                <a href="{{ route('fabrics.index') }}" class="mt-8 inline-block">
                    <x-primary-button>Continue browsing fabrics</x-primary-button>
                </a>
            </div>
        @elseif ($fabrics->isEmpty())
            <div class="rounded-lg border border-dashed border-stone-300 px-6 py-20 text-center">
                <p class="text-lg font-semibold text-stone-900">Your inquiry basket is empty</p>
                <p class="mt-2 text-sm text-stone-500">Browse the catalogue and click "Add to inquiry" on any fabric you would like a quotation for.</p>
                <a href="{{ route('fabrics.index') }}" class="mt-6 inline-block">
                    <x-primary-button>Browse the catalogue</x-primary-button>
                </a>
            </div>
        @else
            <form id="inquiry-form" method="POST" action="{{ route('inquiry.store') }}" class="grid grid-cols-1 gap-10 lg:grid-cols-3">
                @csrf
                <div class="hidden" aria-hidden="true">
                    <label for="website">Leave this field empty</label>
                    <input id="website" name="website" type="text" tabindex="-1" autocomplete="off">
                </div>

                <div class="space-y-4 lg:col-span-2">
                    <x-input-error :messages="$errors->get('items')" />
                    @foreach ($fabrics as $fabric)
                        <div class="rounded-lg border border-stone-200 bg-white p-4 sm:p-5">
                            <input type="hidden" name="items[{{ $loop->index }}][fabric_id]" value="{{ $fabric->id }}">
                            <div class="flex items-start gap-4">
                                <a href="{{ route('fabrics.show', $fabric) }}" class="block size-20 shrink-0 overflow-hidden rounded-md bg-stone-100">
                                    @if ($fabric->image_url)
                                        <img src="{{ $fabric->image_url }}" alt="" class="h-full w-full object-cover">
                                    @endif
                                </a>
                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-wrap items-start justify-between gap-2">
                                        <div>
                                            <p class="text-[11px] font-semibold uppercase tracking-wider text-brand-600">{{ $fabric->category->name }}</p>
                                            <h3 class="font-semibold text-stone-900">
                                                <a href="{{ route('fabrics.show', $fabric) }}" class="transition hover:text-brand-800">{{ $fabric->name }}</a>
                                            </h3>
                                            <p class="mt-0.5 text-xs text-stone-500">{{ collect([$fabric->construction, $fabric->width, $fabric->weight])->filter()->implode(' · ') }}</p>
                                        </div>
                                        <button type="submit" form="remove-fabric-{{ $fabric->id }}"
                                            class="text-sm font-medium text-red-600 transition hover:text-red-800">Remove</button>
                                    </div>
                                    <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-3">
                                        <div>
                                            <x-input-label :for="'quantity-'.$fabric->id" value="Quantity" class="text-xs" />
                                            <x-text-input :id="'quantity-'.$fabric->id" name="items[{{ $loop->index }}][quantity]" class="mt-1 text-sm"
                                                placeholder="e.g. 5,000 m" :value="old('items.'.$loop->index.'.quantity')" />
                                        </div>
                                        <div>
                                            <x-input-label :for="'target-price-'.$fabric->id" value="Target price (optional)" class="text-xs" />
                                            <x-text-input :id="'target-price-'.$fabric->id" name="items[{{ $loop->index }}][target_price]" class="mt-1 text-sm"
                                                placeholder="e.g. $2.10/m" :value="old('items.'.$loop->index.'.target_price')" />
                                        </div>
                                        <div>
                                            <x-input-label :for="'note-'.$fabric->id" value="Note (optional)" class="text-xs" />
                                            <x-text-input :id="'note-'.$fabric->id" name="items[{{ $loop->index }}][note]" class="mt-1 text-sm"
                                                placeholder="Colour, finish, certification…" :value="old('items.'.$loop->index.'.note')" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <a href="{{ route('fabrics.index') }}" class="inline-block text-sm font-semibold text-brand-700 transition hover:text-brand-800">&larr; Add more fabrics</a>
                </div>

                <aside>
                    <div class="space-y-5 rounded-lg border border-stone-200 bg-stone-50 p-6">
                        <h2 class="text-sm font-semibold text-stone-900">Your details</h2>
                        <div>
                            <x-input-label for="name" value="Full name" />
                            <x-text-input id="name" name="name" class="mt-1" :value="old('name')" required />
                            <x-input-error :messages="$errors->get('name')" />
                        </div>
                        <div>
                            <x-input-label for="email" value="Email address" />
                            <x-text-input id="email" name="email" type="email" class="mt-1" :value="old('email')" required />
                            <x-input-error :messages="$errors->get('email')" />
                        </div>
                        <div>
                            <x-input-label for="company" value="Company (optional)" />
                            <x-text-input id="company" name="company" class="mt-1" :value="old('company')" />
                            <x-input-error :messages="$errors->get('company')" />
                        </div>
                        <div>
                            <x-input-label for="country" value="Country (optional)" />
                            <x-text-input id="country" name="country" class="mt-1" :value="old('country')" />
                            <x-input-error :messages="$errors->get('country')" />
                        </div>
                        <div>
                            <x-input-label for="phone" value="Phone / WhatsApp (optional)" />
                            <x-text-input id="phone" name="phone" class="mt-1" :value="old('phone')" />
                            <x-input-error :messages="$errors->get('phone')" />
                        </div>
                        <div>
                            <x-input-label for="message" value="Message (optional)" />
                            <x-textarea-input id="message" name="message" rows="4" class="mt-1" placeholder="Destination port, certifications, packing requirements…">{{ old('message') }}</x-textarea-input>
                            <x-input-error :messages="$errors->get('message')" />
                        </div>
                        <x-primary-button class="w-full">Submit inquiry ({{ $fabrics->count() }} {{ Str::plural('fabric', $fabrics->count()) }})</x-primary-button>
                        <p class="text-xs leading-relaxed text-stone-500">No payment, no obligation — you'll receive one consolidated quotation by email.</p>
                    </div>
                </aside>
            </form>

            @foreach ($fabrics as $fabric)
                <form id="remove-fabric-{{ $fabric->id }}" method="POST" action="{{ route('inquiry.remove', $fabric) }}">
                    @csrf
                    @method('DELETE')
                </form>
            @endforeach
        @endif
    </div>
@endsection
