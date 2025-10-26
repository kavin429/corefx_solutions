<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class AdminWithdrawController extends Controller
{

     // Show only pending withdrawal requests

    public function index()
    {
        $withdrawals = Transaction::with(['user', 'account'])
            ->where('type', 'withdraw')
            ->where('status', 'pending') // ✅ Only show pending ones
            ->orderBy('created_at', 'desc')
            ->paginate(100);

        return view('admin.withdrawals', compact('withdrawals'));
    }


     // Update withdrawal request (approve/reject)

    public function update(Request $request, $id)
    {
        $withdraw = Transaction::findOrFail($id);

        if ($request->status === 'approved') {
            // Deduct from account balance if account exists
            if ($withdraw->account) {
                $withdraw->account->decrement('balance', $withdraw->amount);
            }

            // Mark as completed
            $withdraw->status = 'completed';
            $withdraw->save();

            // 🔔 Notify user
            Notification::create([
                'notifiable_id'   => $withdraw->user_id,
                'notifiable_type' => 'App\Models\User',
                'sender_id'       => Auth::id(),
                'sender_type'     => 'admin',
                'title'           => 'Withdrawal Approved',
                'message'         => "Your withdrawal request of \${$withdraw->amount} has been approved and processed.",
            ]);

        } elseif ($request->status === 'rejected') {
            // Mark as failed
            $withdraw->status = 'failed';
            $withdraw->save();

            // 🔔 Notify user
            Notification::create([
                'notifiable_id'   => $withdraw->user_id,
                'notifiable_type' => 'App\Models\User',
                'sender_id'       => Auth::id(),
                'sender_type'     => 'admin',
                'title'           => 'Withdrawal Rejected',
                'message'         => "Your withdrawal request of \${$withdraw->amount} has been rejected. Please contact support for assistance.",
            ]);
        }

        return redirect()->back()->with('success', 'Withdrawal request updated successfully!');
    }
}
