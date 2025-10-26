<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class AdminDepositController extends Controller
{

    // Show only pending deposit requests
    public function index()
    {
        $deposits = Transaction::where('type', 'deposit')
            ->where('status', 'pending') // ✅ show only pending deposits
            ->with(['user', 'account'])
            ->orderBy('created_at', 'desc')
            ->paginate(100);

        return view('admin.deposits', compact('deposits'));
    }

    // Approve deposit and adjust balance

    public function approve(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $deposit = Transaction::findOrFail($id);

        if ($deposit->status !== 'pending') {
            return back()->with('error', 'This deposit has already been processed.');
        }

        $amount = $request->amount;

        // Update account balance
        if ($deposit->account) {
            $deposit->account->increment('balance', $amount);
        }

        // Update deposit status
        $deposit->update([
            'amount' => $amount,
            'status' => 'completed',
        ]);

        // 🔔 Notify user
        Notification::create([
            'notifiable_id'   => $deposit->user_id,
            'notifiable_type' => 'App\Models\User',
            'sender_id'       => Auth::id(),
            'sender_type'     => 'admin',
            'title'           => 'Deposit Approved',
            'message'         => "Your deposit of \${$amount} has been approved and added to your account.",
        ]);

        return back()->with('success', "Deposit #{$deposit->id} approved and balance updated!");
    }

    // Reject deposit
    public function reject($id)
    {
        $deposit = Transaction::findOrFail($id);

        if ($deposit->status !== 'pending') {
            return back()->with('error', 'This deposit has already been processed.');
        }

        // Update deposit status
        $deposit->update([
            'status' => 'failed',
        ]);

        // 🔔 Notify user
        Notification::create([
            'notifiable_id'   => $deposit->user_id,
            'notifiable_type' => 'App\Models\User',
            'sender_id'       => Auth::id(),
            'sender_type'     => 'admin',
            'title'           => 'Deposit Rejected',
            'message'         => "Your deposit request of \${$deposit->amount} has been rejected. Please contact support if needed.",
        ]);

        return back()->with('success', "Deposit #{$deposit->id} has been rejected.");
    }
}
