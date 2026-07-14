<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitInquiryRequest;
use App\Mail\InquiryReceivedMail;
use App\Models\Fabric;
use App\Models\Inquiry;
use App\Models\Setting;
use App\Services\InquiryBasket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class InquiryBasketController extends Controller
{
    public function __construct(private InquiryBasket $basket) {}

    public function index(): View
    {
        return view('inquiry.index', ['fabrics' => $this->basket->fabrics()]);
    }

    public function add(Fabric $fabric): RedirectResponse
    {
        abort_unless($fabric->is_active, 404);

        $this->basket->add($fabric);

        return back()->with('status', "\"{$fabric->name}\" added to your inquiry basket.");
    }

    public function remove(Fabric $fabric): RedirectResponse
    {
        $this->basket->remove($fabric);

        return back()->with('status', "\"{$fabric->name}\" removed from your inquiry basket.");
    }

    public function store(SubmitInquiryRequest $request): RedirectResponse
    {
        if ($request->filled('website')) {
            return redirect()->route('inquiry.index')->with('inquirySubmitted', true);
        }

        $data = $request->validated();

        $inquiry = DB::transaction(function () use ($data): Inquiry {
            $inquiry = Inquiry::query()->create(Arr::except($data, ['items']));

            $fabricNames = Fabric::query()
                ->whereIn('id', array_column($data['items'], 'fabric_id'))
                ->pluck('name', 'id');

            foreach ($data['items'] as $item) {
                $inquiry->items()->create([
                    ...$item,
                    'fabric_name' => $fabricNames[$item['fabric_id']] ?? 'Unknown fabric',
                ]);
            }

            return $inquiry;
        });

        $this->basket->clear();

        if ($notificationEmail = Setting::get('notification_email')) {
            Mail::to($notificationEmail)->send(new InquiryReceivedMail($inquiry));
        }

        return redirect()->route('inquiry.index')->with('inquirySubmitted', true);
    }
}
