<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PartnerType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PartnerRequest;
use App\Models\Partner;
use App\Services\ImageStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PartnerController extends Controller
{
    public function __construct(private ImageStorage $images) {}

    public function index(Request $request): View
    {
        $type = PartnerType::tryFrom($request->string('type')->toString()) ?? PartnerType::Buyer;

        return view('admin.partners.index', [
            'partners' => Partner::query()->ofType($type)->ordered()->paginate(30)->withQueryString(),
            'type' => $type,
        ]);
    }

    public function create(Request $request): View
    {
        $partner = new Partner;
        $partner->type = PartnerType::tryFrom($request->string('type')->toString()) ?? PartnerType::Buyer;

        return view('admin.partners.form', ['partner' => $partner]);
    }

    public function store(PartnerRequest $request): RedirectResponse
    {
        $partner = Partner::query()->create($this->preparedData($request));

        return redirect()
            ->route('admin.partners.index', ['type' => $partner->type->value])
            ->with('status', 'Partner created.');
    }

    public function edit(Partner $partner): View
    {
        return view('admin.partners.form', ['partner' => $partner]);
    }

    public function update(PartnerRequest $request, Partner $partner): RedirectResponse
    {
        $partner->update($this->preparedData($request, $partner));

        return redirect()
            ->route('admin.partners.index', ['type' => $partner->type->value])
            ->with('status', 'Partner updated.');
    }

    public function destroy(Partner $partner): RedirectResponse
    {
        $this->images->delete($partner->logo);
        $partner->delete();

        return back()->with('status', 'Partner deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function preparedData(PartnerRequest $request, ?Partner $partner = null): array
    {
        $data = $request->safe()->except(['logo']);

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->images->replace($partner?->logo, $request->file('logo'), 'partners');
        }

        return $data;
    }
}
