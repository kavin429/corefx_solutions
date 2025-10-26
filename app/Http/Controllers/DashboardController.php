<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;

class DashboardController extends Controller
{
    /** Display the main dashboard */
    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $accounts = $user->accounts;

        // Total PNL across all accounts
        $totalPNL = $accounts->sum('pnl');

        // Total balance across all accounts (assume balance already includes PNL)
        $totalBalance = $accounts->sum('balance');

        // Total deposits (completed)
        $totalIncome = $user->transactions()
                            ->where('type', 'deposit')
                            ->where('status', 'completed')
                            ->sum('amount');

        // Total withdrawals (completed)
        $totalOutcome = $user->transactions()
                            ->where('type', 'withdraw')
                            ->where('status', 'completed')
                            ->sum('amount');

        // Latest transactions and notifications
        $transactions = $user->transactions()->latest()->get();
        $notifications = $user->notifications()->latest()->take(5)->get();

        return view('dashboard.index', compact(
            'user', 'profile', 'accounts', 
            'totalBalance', 'totalPNL', 
            'totalIncome', 'totalOutcome', 
            'transactions', 'notifications'
        ));
    }

    /** Return JSON account details for selected account */
    public function getAccountDetails($id)
    {
        $account = Account::with('transactions')->findOrFail($id);

        // Sum deposits for this account
        $totalDeposit = $account->transactions()
                        ->where('type', 'deposit')
                        ->where('status', 'completed')
                        ->sum('amount');

        // Sum withdrawals for this account
        $totalWithdraw = $account->transactions()
                         ->where('type', 'withdraw')
                         ->where('status', 'completed')
                         ->sum('amount');

        // PNL for this account
        $totalPNL = $account->pnl ?? 0;

        // Determine total balance
        // ⚡ Prevent double-counting PNL: assume balance already includes PNL
        $totalBalance = $account->balance ?? 0;

        return response()->json([
            'totalBalance' => $totalBalance,
            'totalDeposit' => $totalDeposit,
            'totalWithdraw'=> $totalWithdraw,
            'totalPNL'     => $totalPNL,
        ]);
    }
}
