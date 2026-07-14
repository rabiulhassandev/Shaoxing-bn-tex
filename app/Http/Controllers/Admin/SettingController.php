<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingsRequest;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.edit', ['values' => Setting::allCached()]);
    }

    public function update(SettingsRequest $request): RedirectResponse
    {
        Setting::setMany($request->validated());

        return back()->with('status', 'Settings saved.');
    }
}
