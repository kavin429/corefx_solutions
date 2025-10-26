<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WithdrawRequest;
use App\Models\Account;

class WithdrawRequestController extends Controller
{

    // Display all withdrawal requests

    public function index(Request $request)
    {
        $query = WithdrawRequest::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%$search%"))
                  ->orWhere('status', 'like', "%$search%")
                  ->orWhere('withdrawal_method', 'like', "%$search%");
        }

        $requests = $query->latest()->paginate(100);

        return view('admin.adminWithdraw', compact('requests'));
    }


    // Accept a withdrawal request

    public function accept(WithdrawRequest $withdrawRequest)
    {
        if ($withdrawRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'Request already processed.');
        }

        $account = Account::where('user_id', $withdrawRequest->user_id)->first();

        if ($account && $withdrawRequest->amount > $account->balance) {
            return redirect()->back()->with('error', 'Insufficient balance to approve this request.');
        }

        if ($account) {
            $account->balance -= $withdrawRequest->amount;
            $account->save();
        }

        $withdrawRequest->status = 'approved';
        $withdrawRequest->admin_id = auth()->id();
        $withdrawRequest->save();

        return redirect()->back()->with('success', 'Withdrawal request approved.');
    }


    // Reject a withdrawal request

    public function reject(WithdrawRequest $withdrawRequest)
    {
        if ($withdrawRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'Request already processed.');
        }

        $withdrawRequest->status = 'rejected';
        $withdrawRequest->admin_id = auth()->id();
        $withdrawRequest->save();

        return redirect()->back()->with('success', 'Withdrawal request rejected.');
    }
}
