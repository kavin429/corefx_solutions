<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Account;
use App\Models\Notification;
use App\Models\Admin;
use App\Models\DepositMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    // Show deposit page with methods
    public function index()
    {
        $depositMethods = DepositMethod::all(); // Fetch all methods dynamically
        $accounts = Account::where('user_id', Auth::id())->get(); // Fetch user accounts
        return view('dashboard.deposit', compact('depositMethods', 'accounts'));
    }

    // Store a new deposit request
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'amount'     => 'required|numeric|min:0.01',
            'method'     => 'required|string',
            'screenshot' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $account = Account::findOrFail($request->account_id);

        $screenshotPath = null;
        if ($request->hasFile('screenshot')) {
            $screenshotPath = $request->file('screenshot')->store('transactions', 'public');
        }

        $deposit = Transaction::create([
            'user_id'         => Auth::id(),
            'account_id'      => $account->id,
            'type'            => 'deposit',
            'amount'          => $request->amount,
            'method'          => $request->method,
            'status'          => 'pending',
            'screenshot_path' => $screenshotPath,
            'note'            => 'Deposit request submitted by user.',
        ]);

        // Notify all admins
        $admins = Admin::all();
        foreach ($admins as $admin) {
            Notification::create([
                'notifiable_id'   => $admin->id,
                'notifiable_type' => Admin::class,
                'sender_id'       => Auth::id(),
                'sender_type'     => 'user',
                'title'           => 'New Deposit Request',
                'message'         => Auth::user()->name . ' submitted a deposit of $' . $deposit->amount,
                'is_read'         => 0,
            ]);
        }

        return redirect()->back()->with('success', 'Deposit request submitted. Waiting for approval.');
    }

    // Request Live ID
    public function requestLiveId()
    {
        $admins = Admin::all();

        foreach ($admins as $admin) {
            Notification::create([
                'notifiable_id'   => $admin->id,
                'notifiable_type' => Admin::class,
                'sender_id'       => Auth::id(),
                'sender_type'     => 'user',
                'title'           => 'Live ID Request',
                'message'         => Auth::user()->email . ' has requested a Live ID.',
                'is_read'         => 0,
            ]);
        }

        return redirect()->back()->with('success', 'Live ID request sent to Support CoreFX Solutions!');
    }
}
