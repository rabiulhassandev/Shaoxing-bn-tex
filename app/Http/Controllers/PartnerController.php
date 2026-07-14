<?php

namespace App\Http\Controllers;

use App\Enums\PartnerType;
use App\Models\Partner;
use Illuminate\View\View;

class PartnerController extends Controller
{
    public function __invoke(): View
    {
        return view('buyers', [
            'buyers' => Partner::query()->active()->ofType(PartnerType::Buyer)->ordered()->get(),
            'vendors' => Partner::query()->active()->ofType(PartnerType::Vendor)->ordered()->get(),
        ]);
    }
}
