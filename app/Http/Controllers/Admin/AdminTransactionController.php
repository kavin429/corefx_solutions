<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Account;
use Illuminate\Support\Facades\DB;

class AdminTransactionController extends Controller
{

    // Display all transactions with optional search

    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'account']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($q2) => $q2->where('name', 'like', "%$search%"))
                  ->orWhereHas('account', fn($q2) => $q2->where('account_name', 'like', "%$search%"))
                  ->orWhere('type', 'like', "%$search%")
                  ->orWhere('method', 'like', "%$search%")
                  ->orWhere('status', 'like', "%$search%")
                  ->orWhere('beneficiary_name', 'like', "%$search%");
            });
        }

        $transactions = $query->latest()->paginate(100);
        $users = User::all();
        $accounts = Account::all();

        return view('admin.transactions', compact('transactions', 'users', 'accounts'));
    }

    // Store a new transaction

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'account_id' => 'nullable|exists:accounts,id',
            'type' => 'required|in:deposit,withdraw',
            'amount' => 'required|numeric|min:0.01',
            'method' => 'nullable|in:bank,binance,xynder,crypto,card',
            'status' => 'nullable|in:pending,completed,failed',
            'beneficiary_name' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'ifsc' => 'nullable|string|max:50',
            'bank_address' => 'nullable|string|max:255',
            'xynder_id' => 'nullable|string|max:255',
            'binance_id' => 'nullable|string|max:255',
            'network_id' => 'nullable|string|max:255',
            'note' => 'nullable|string|max:500',
        ]);

        $account = Account::find($request->account_id);

        if ($request->type === 'withdraw' && $account && $request->amount > $account->balance) {
            return redirect()->back()->withErrors('Insufficient balance for withdrawal.');
        }

        // Default status: withdraw → pending, deposit → completed
        $status = $request->status ?? ($request->type === 'withdraw' ? 'pending' : 'completed');

        $transaction = Transaction::create(array_merge($request->all(), [
            'status' => $status,
        ]));

        // Adjust balance ONLY if completed
        if ($account && $transaction->status === 'completed') {
            if ($transaction->type === 'deposit') {
                $account->balance += $transaction->amount;
            } elseif ($transaction->type === 'withdraw') {
                $account->balance -= $transaction->amount;
            }
            $account->save();
        }

        return redirect()->back()->with('success', 'Transaction added successfully.');
    }

    // Update a transaction

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'account_id' => 'nullable|exists:accounts,id',
            'type' => 'required|in:deposit,withdraw',
            'amount' => 'required|numeric|min:0.01',
            'method' => 'nullable|in:bank,binance,xynder,crypto,card',
            'status' => 'nullable|in:pending,completed,failed',
            'beneficiary_name' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'ifsc' => 'nullable|string|max:50',
            'bank_address' => 'nullable|string|max:255',
            'xynder_id' => 'nullable|string|max:255',
            'binance_id' => 'nullable|string|max:255',
            'network_id' => 'nullable|string|max:255',
            'note' => 'nullable|string|max:500',
        ]);

        $transaction->update($request->all());

        // Recalculate account balance using only completed transactions
        if ($transaction->account_id) {
            $account = Account::find($transaction->account_id);
            if ($account) {
                $balance = $account->transactions()
                    ->where('status', 'completed')
                    ->sum(DB::raw("CASE WHEN type='deposit' THEN amount ELSE -amount END"));

                $account->balance = $balance;
                $account->save();
            }
        }

        return redirect()->back()->with('success', 'Transaction updated successfully.');
    }

    // Delete a transaction

    public function destroy(Transaction $transaction)
    {
        // If completed, reverse it before deleting
        if ($transaction->account_id && $transaction->status === 'completed') {
            $account = Account::find($transaction->account_id);
            if ($account) {
                if ($transaction->type === 'deposit') {
                    $account->balance -= $transaction->amount;
                } elseif ($transaction->type === 'withdraw') {
                    $account->balance += $transaction->amount;
                }
                $account->save();
            }
        }

        $transaction->delete();

        return redirect()->back()->with('success', 'Transaction deleted successfully.');
    }

    // Update only the status of a transaction

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,failed'
        ]);

        $transaction->status = $request->status;
        $transaction->save();

        // Recalculate balance after status change
        if ($transaction->account_id) {
            $account = Account::find($transaction->account_id);
            if ($account) {
                $balance = $account->transactions()
                    ->where('status', 'completed')
                    ->sum(DB::raw("CASE WHEN type='deposit' THEN amount ELSE -amount END"));

                $account->balance = $balance;
                $account->save();
            }
        }

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}
