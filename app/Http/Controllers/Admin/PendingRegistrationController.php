<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendingRegistration;
use Illuminate\Http\Request;

class PendingRegistrationController extends Controller
{
    // Show all pending registrations
    public function index()
    {
        $registrations = PendingRegistration::latest()->get();
        return view('admin.pending_registrations', compact('registrations'));
    }

    // Delete one record
    public function destroy($id)
    {
        $reg = PendingRegistration::findOrFail($id);
        $reg->delete();

        return redirect()->route('pending.index')->with('success', 'Pending registration deleted successfully.');
    }
}
