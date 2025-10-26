<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DepositMethod;
use Illuminate\Http\Request;

class AdminDepositMethodController extends Controller
{
    // Show all deposit methods
    public function index()
    {
        $depositMethods = DepositMethod::latest()->get();
        return view('admin.deposit-methods', compact('depositMethods'));
    }

    // Store new deposit method
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            
            'address' => 'required|string|max:255',
        ]);

        DepositMethod::create($request->only('name', 'network', 'address'));

        return back()->with('success', 'Deposit method added successfully.');
    }

    // Update deposit method
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            
            'address' => 'required|string|max:255',
        ]);

        $method = DepositMethod::findOrFail($id);
        $method->update($request->only('name', 'network', 'address'));

        return back()->with('success', 'Deposit method updated successfully.');
    }

    // Delete deposit method
    public function destroy($id)
    {
        $method = DepositMethod::findOrFail($id);
        $method->delete();

        return back()->with('success', 'Deposit method deleted successfully.');
    }
}
