<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Admin;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class WithdrawController extends Controller
{
    // Show the withdraw request form
    public function create()
    {
        return view('dashboard.withdraw'); // Blade view
    }

    // Handle form submission
    public function store(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id', // Selected account
            'amount' => 'required|numeric|min:1',
            'beneficiary_name' => 'required|string|max:255',

            'method' => 'required|in:binance,upi,bank,xynder',
        ]);

        // Save withdraw transaction
        $transaction = new Transaction();
        $transaction->user_id = Auth::id();
        $transaction->account_id = $request->account_id;
        $transaction->type = 'withdraw';
        $transaction->amount = $request->amount;
        $transaction->beneficiary_name = $request->beneficiary_name;
        $transaction->account_number = $request->account_number;
        $transaction->method = $request->method;

        // Assign method-specific fields
        if ($request->method === 'binance') {
            $transaction->binance_id = $request->binance_id;
        } elseif ($request->method === 'upi') {
            $transaction->upi_id = $request->upi_id;
        } elseif ($request->method === 'bank') {
            $transaction->bank_name = $request->bank_name;
            $transaction->account_number = $request->bank_account_number;
            $transaction->ifsc = $request->ifsc;
        } elseif ($request->method === 'xynder') {
            $transaction->xynder_id = $request->xynder_id;
        }

        $transaction->status = 'pending'; // default
        $transaction->save();

        // Notify all admins about this withdraw request
        $admins = Admin::all();
        foreach ($admins as $admin) {
            Notification::create([
                'notifiable_id'   => $admin->id,
                'notifiable_type' => 'App\Models\Admin',
                'sender_id'       => Auth::id(),
                'sender_type'     => 'user',
                'title'           => 'New Withdraw Request',
                'message'         => Auth::user()->email . " requested a withdrawal of \${$transaction->amount}.",
                'is_read'         => 0,
            ]);
        }

        return redirect()->back()->with('success', 'Withdraw request submitted successfully!');
    }
}
