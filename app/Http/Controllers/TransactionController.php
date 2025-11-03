<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Account;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // <-- Correct import

class TransactionController extends Controller
{
    // Display transactions with filters
    public function index(Request $request)
    {
        $query = Transaction::where('user_id', auth()->id())
                            ->with('account')
                            ->latest();

        // Filter by search keyword
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('type', 'like', "%{$search}%")
                  ->orWhere('note', 'like', "%{$search}%");
            });
        }

        // Filter by account
        if ($accountId = $request->input('account')) {
            $query->where('account_id', $accountId);
        }

        // Filter by date range
        if ($startDate = $request->input('start_date')) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate = $request->input('end_date')) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // Paginate results
        $transactions = $query->paginate(50);
        $transactions->appends($request->only('search', 'account', 'start_date', 'end_date'));

        // Get user accounts for filter dropdown
        $accounts = Account::where('user_id', auth()->id())->get();

        // Totals for filtered transactions (only completed)
        $totalDeposit = $transactions   ->where('type', 'deposit')
                                        ->where('status', 'completed')
                                        ->sum('amount');

        $totalWithdraw = $transactions  ->where('type', 'withdraw')
                                        ->where('status', 'completed')
                                        ->sum('amount');

        return view('dashboard.transaction', compact('transactions', 'accounts', 'totalDeposit', 'totalWithdraw'));
    }

    // Store new transaction
    public function store(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'type'       => 'required|in:deposit,withdraw',
            'amount'     => 'required|numeric|min:0.01',
            'method'     => 'required|string',
        ]);

        $account = Account::findOrFail($request->account_id);

        if ($request->type === 'withdraw' && $request->amount > $account->balance) {
            return back()->withErrors('Insufficient balance for this withdrawal.');
        }

        $status = $request->type === 'withdraw' ? 'pending' : 'completed';

        $transaction = Transaction::create([
            'user_id'     => auth()->id(),
            'account_id'  => $account->id,
            'type'        => $request->type,
            'amount'      => $request->amount,
            'method'      => $request->method,
            'status'      => $status,
        ]);

        if ($transaction->status === 'completed') {
            if ($transaction->type === 'deposit') {
                $account->balance += $transaction->amount;
            } elseif ($transaction->type === 'withdraw') {
                $account->balance -= $transaction->amount;
            }
            $account->save();
        }

        return redirect()->back()->with(
            'success',
            $transaction->type === 'withdraw'
                ? 'Withdrawal request submitted. Waiting for approval.'
                : 'Deposit completed successfully.'
        );
    }

    // Download transactions as PDF with filters
    public function downloadPdf(Request $request)
{
    $user = auth()->user();
    $userProfile = $user->profile;

    $query = $user->transactions()->with('account')->latest();

    if ($search = $request->input('search')) {
        $query->where(function($q) use ($search) {
            $q->where('type', 'like', "%{$search}%")
              ->orWhere('note', 'like', "%{$search}%");
        });
    }

    if ($accountId = $request->input('account')) {
        $query->where('account_id', $accountId);
    }

    if ($startDate = $request->input('start_date')) {
        $query->whereDate('created_at', '>=', $startDate);
    }

    if ($endDate = $request->input('end_date')) {
        $query->whereDate('created_at', '<=', $endDate);
    }

    $transactions = $query->get();

    $totalDeposit = $transactions->where('type', 'deposit')->where('status', 'completed')->sum('amount');
    $totalWithdraw = $transactions->where('type', 'withdraw')->where('status', 'completed')->sum('amount');

    $pdf = Pdf::loadView('dashboard.pdf', compact('transactions', 'user', 'userProfile', 'totalDeposit', 'totalWithdraw'));

    return $pdf->download('transactions.pdf');
}

}
