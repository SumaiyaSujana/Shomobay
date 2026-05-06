<?php

namespace App\Http\Controllers;

use App\Models\SeasonalityAlert;
use Illuminate\Http\Request;

class SeasonalityAlertController extends Controller
{
    public function index()
    {
        $alerts = SeasonalityAlert::latest()->get();

        return view('admin.seasonality-alerts', compact('alerts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'area_name' => 'nullable|string|max:255',
            'wholesale_price' => 'required|numeric|min:0',
            'message' => 'required|string|max:1000',
            'status' => 'required|in:draft,published',
        ]);

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        SeasonalityAlert::create($validated);

        return redirect()
            ->route('admin.seasonality-alerts.index')
            ->with('success', 'Seasonality alert created successfully.');
    }

    public function publish(SeasonalityAlert $seasonalityAlert)
    {
        $seasonalityAlert->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        return redirect()
            ->route('admin.seasonality-alerts.index')
            ->with('success', 'Seasonality alert published successfully.');
    }

    public function destroy(SeasonalityAlert $seasonalityAlert)
    {
        $seasonalityAlert->delete();

        return redirect()
            ->route('admin.seasonality-alerts.index')
            ->with('success', 'Seasonality alert deleted successfully.');
    }
}