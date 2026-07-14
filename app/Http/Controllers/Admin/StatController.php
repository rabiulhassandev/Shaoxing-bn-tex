<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StatRequest;
use App\Models\Stat;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StatController extends Controller
{
    public function index(): View
    {
        return view('admin.stats.index', [
            'stats' => Stat::query()->ordered()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.stats.form', ['stat' => new Stat]);
    }

    public function store(StatRequest $request): RedirectResponse
    {
        Stat::query()->create($request->validated());

        return redirect()->route('admin.stats.index')->with('status', 'Statistic created.');
    }

    public function edit(Stat $stat): View
    {
        return view('admin.stats.form', ['stat' => $stat]);
    }

    public function update(StatRequest $request, Stat $stat): RedirectResponse
    {
        $stat->update($request->validated());

        return redirect()->route('admin.stats.index')->with('status', 'Statistic updated.');
    }

    public function destroy(Stat $stat): RedirectResponse
    {
        $stat->delete();

        return redirect()->route('admin.stats.index')->with('status', 'Statistic deleted.');
    }
}
