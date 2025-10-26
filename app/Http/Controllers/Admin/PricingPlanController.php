<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PricingPlan;
use Illuminate\Http\Request;

class PricingPlanController extends Controller
{
    // Display all plans
    public function index()
    {
        $plans = PricingPlan::all();
        return view('admin.pricing', compact('plans'));
    }

    // Store new plan
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'price'         => 'required|numeric',
            'leverage'      => 'required|string|max:255',
            'min_lot_size'  => 'required|numeric',
            'starting_pips' => 'required|string|max:255',
            'swap'          => 'required|string|max:255',
            'commission'    => 'required|numeric',
        ]);

        PricingPlan::create($request->all());

        return redirect()->route('admin.pricing.index')->with('success', 'Plan created successfully.');
    }

    // Update existing plan
    public function update(Request $request, PricingPlan $pricing)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'price'         => 'required|numeric',
            'leverage'      => 'required|string|max:255',
            'min_lot_size'  => 'required|numeric',
            'starting_pips' => 'required|string|max:255',
            'swap'          => 'required|string|max:255',
            'commission'    => 'required|numeric',
        ]);

        $pricing->update($request->all());

        return redirect()->route('admin.pricing.index')->with('success', 'Plan updated successfully.');
    }

    // Delete plan
    public function destroy(PricingPlan $pricing)
    {
        $pricing->delete();

        return redirect()->route('admin.pricing.index')->with('success', 'Plan deleted successfully.');
    }
}
