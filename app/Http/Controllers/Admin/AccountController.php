<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\User;

class AccountController extends Controller
{

    // Display a listing of accounts for admin.
    // Supports search and pagination.

    public function index(Request $request)
    {
        $query = Account::with('user')
            ->whereNotNull('live_id'); // ✅ only accounts with live_id

        // Search by account number, account name, or user info
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('live_id', 'like', "%{$search}%")
                  ->orWhere('account_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $accounts = $query
    ->orderByDesc('live_id_assigned_at') // ✅ newest assigned first
    ->orderByDesc('id') // fallback
    ->paginate(100);

        $accounts->appends($request->only('search'));

        $users = User::all(); // needed for account creation dropdown

        return view('admin.accounts.index', compact('accounts', 'users'));
    }

    //Store a newly created account.
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:live,demo',
            'currency' => 'required|string|size:3',
            'balance' => 'nullable|numeric|min:0', // optional initial balance
        ]);

        // Generate unique account number
        do {
            $accountNumber = 'AC' . rand(100000, 999999);
        } while (Account::where('live_id', $accountNumber)->exists());

        $user = User::findOrFail($request->user_id);

        Account::create([
            'user_id' => $user->id,
            'live_id' => $accountNumber,
            'account_name' => $user->name,
            'type' => $request->type,
            'currency' => strtoupper($request->currency),
            'balance' => $request->balance ?? 0, // use 0 if no initial balance provided
        ]);

        return redirect()->back()->with('success', 'Account created successfully!');
    }

    // Update account information.
    public function update(Request $request, Account $account)
    {
        // Validate the input including balance
        $request->validate([
            'account_name' => 'required|string|max:255',
            'type' => 'required|in:live,demo',
            'currency' => 'required|string|size:3',
            'balance' => 'required|numeric|min:0', // allow decimal, no negative balance
        ]);

        // Update account fields including balance
        $account->update([
            'account_name' => $request->account_name,
            'type' => $request->type,
            'currency' => strtoupper($request->currency),
            'balance' => $request->balance,
        ]);

        return redirect()->back()->with('success', 'Account updated successfully!');
    }

    // Remove the specified account.
    public function destroy(Account $account)
    {
        $account->delete();

        return redirect()->back()->with('success', 'Account deleted successfully!');
    }

    // Upload PNL and recalculate balance.

    public function uploadPNL(Request $request, Account $account)
{
    $request->validate([
        'pnl' => 'required|numeric',
    ]);

    // Set PNL directly (overwrite old value)
    $account->pnl = $request->pnl;

    // Recalculate balance
    $totalDeposit = $account->transactions()
                    ->where('type', 'deposit')
                    ->where('status', 'completed')
                    ->sum('amount');

    $totalWithdrawal = $account->transactions()
                    ->where('type', 'withdraw')
                    ->where('status', 'completed')
                    ->sum('amount');

    $account->balance = $totalDeposit + $account->pnl - $totalWithdrawal;

    $account->save();

    return redirect()->back()->with('success', 'PNL updated successfully!');
}


}
