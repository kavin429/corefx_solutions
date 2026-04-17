<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Account;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminTransactionHistoryController extends Controller
{
    // Show all completed, failed, or pending transactions with filters
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'account'])
            ->whereIn('status', ['pending', 'completed', 'failed']);

        // Search by keyword
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($q2) => $q2->where('name', 'like', "%$search%"))
                    ->orWhereHas('account', fn($q2) => $q2->where('account_name', 'like', "%$search%")
                        ->orWhere('live_id', 'like', "%$search%")) // ✅ added live_id search
                    ->orWhere('type', 'like', "%$search%")
                    ->orWhere('method', 'like', "%$search%")
                    ->orWhere('beneficiary_name', 'like', "%$search%");
            });
        }

        // Filters
        if ($request->filled('type')) $query->where('type', $request->type);
        if ($request->filled('method')) $query->where('method', $request->method);
        if ($request->filled('from_date')) $query->whereDate('created_at', '>=', $request->from_date);
        if ($request->filled('to_date')) $query->whereDate('created_at', '<=', $request->to_date);

        $transactions = $query->latest()->paginate(100);

        $users = User::all();
        $accounts = Account::all();

        return view('admin.transactions1', compact('transactions', 'users', 'accounts'));
    }

    // Export filtered transactions as PDF
    public function exportPdf(Request $request)
    {
        $query = Transaction::with(['user', 'account'])->whereIn('status', ['completed', 'failed']);

        // Apply same filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($q2) => $q2->where('name', 'like', "%$search%"))
                    ->orWhereHas('account', fn($q2) => $q2->where('account_name', 'like', "%$search%"))
                    ->orWhere('type', 'like', "%$search%")
                    ->orWhere('method', 'like', "%$search%")
                    ->orWhere('beneficiary_name', 'like', "%$search%");
            });
        }

        if ($request->filled('type')) $query->where('type', $request->type);
        if ($request->filled('method')) $query->where('method', $request->method);
        if ($request->filled('from_date')) $query->whereDate('created_at', '>=', $request->from_date);
        if ($request->filled('to_date')) $query->whereDate('created_at', '<=', $request->to_date);

        $transactions = $query->latest()->get();

        $pdf = Pdf::loadView('admin.transactions_pdf', compact('transactions'));
        return $pdf->download('transaction-history.pdf');
    }

    // Update existing transaction
    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'beneficiary_name' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'ifsc' => 'nullable|string|max:50',
            'bank_address' => 'nullable|string|max:255',
            'xynder_id' => 'nullable|string|max:255',
            'binance_id' => 'nullable|string|max:255',
            'screenshot' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $transaction->update([
            'beneficiary_name' => $request->beneficiary_name,
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'ifsc' => $request->ifsc,
            'bank_address' => $request->bank_address,
            'xynder_id' => $request->xynder_id,
            'binance_id' => $request->binance_id,
        ]);

        if ($request->hasFile('screenshot')) {
            if ($transaction->screenshot_path && Storage::disk('public')->exists($transaction->screenshot_path)) {
                Storage::disk('public')->delete($transaction->screenshot_path);
            }
            $path = $request->file('screenshot')->store('screenshots', 'public');
            $transaction->update(['screenshot_path' => $path]);
        }

        return redirect()->back()->with('success', 'Transaction updated successfully.');
    }

    // Store new transaction
    public function store(Request $request)
    {
        // Debug form submission if needed
        // dd($request->all());

        // Validate request
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'account_id' => 'nullable|exists:accounts,id',
            'type' => 'required|in:deposit,withdraw,reverse',
            'amount' => 'required|numeric|min:0.01',
            'method' => 'required|string',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'ifsc' => 'nullable|string|max:50',
            'bank_address' => 'nullable|string|max:255',
            'xynder_id' => 'nullable|string|max:255',
            'binance_id' => 'nullable|string|max:255',
            'upi_id' => 'nullable|string|max:255',
            'status' => 'required|in:pending,completed,failed',
            'note' => 'nullable|string|max:255',
            'screenshot' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        // Create transaction
$transaction = new Transaction($request->only([
    'user_id','account_id','type','amount','method','bank_name','account_number','ifsc',
    'bank_address','xynder_id','binance_id','upi_id','status','note'
]));

// ✅ FIRST: handle reverse logic
if ($transaction->type === 'reverse' && $request->filled('original_transaction_id')) {
    $original = Transaction::find($request->original_transaction_id);

    if ($original) {
        $transaction->amount = $original->amount;
        $transaction->method = $original->method;
        $transaction->beneficiary_name = $original->beneficiary_name;
        $transaction->bank_name = $original->bank_name;
        $transaction->account_number = $original->account_number;
        $transaction->ifsc = $original->ifsc;
        $transaction->bank_address = $original->bank_address;
        $transaction->xynder_id = $original->xynder_id;
        $transaction->binance_id = $original->binance_id;
        $transaction->upi_id = $original->upi_id;
    }
}

// THEN save
$transaction->save();

// ✅ THEN update balance
if ($transaction->status === 'completed' && $transaction->account_id) {
    $account = $transaction->account;

    switch ($transaction->type) {

        case 'deposit':
            $account->balance += $transaction->amount;
            break;

        case 'withdraw':
            $account->balance -= $transaction->amount;
            break;

        case 'reverse':

            $original = Transaction::find($request->original_transaction_id);

            if ($original) {
                if ($original->type === 'deposit') {
                    // Reverse deposit → subtract
                    $account->balance -= $original->amount;
                } elseif ($original->type === 'withdraw') {
                    // Reverse withdraw → add back
                    $account->balance += $original->amount;
                }
            }

            break;
    }

    $account->save();
}
        // Send notification to the user
        $transactionType = ucfirst($transaction->type); // Deposit / Withdraw / Reverse
        $status = ucfirst($transaction->status);

        \App\Models\Notification::create([
            'notifiable_id' => $transaction->user_id,
            'notifiable_type' => 'App\Models\User',
            'sender_id' => auth()->guard('admin')->id(),
            'sender_type' => 'admin',
            'title' => "New $transactionType Transaction",
            'message' => "A $transactionType transaction of amount {$transaction->amount} has been $status by the Core FX Solutions LTD.",
            'is_read' => 0,
        ]);

        return redirect()->back()->with('success', 'Transaction added successfully and user notified.');
    }
    // Delete a single transaction
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);

        DB::transaction(function () use ($transaction) {

            // Adjust balance
            if ($transaction->account_id && $transaction->status === 'completed') {
                $account = $transaction->account;
                if ($transaction->type === 'deposit') {
                    $account->balance -= $transaction->amount;
                } else {
                    // withdraw + reverse revert = add back
                    $account->balance += $transaction->amount;
                }
                $account->save();
            }

            // Delete screenshot
            if ($transaction->screenshot_path && Storage::disk('public')->exists($transaction->screenshot_path)) {
                Storage::disk('public')->delete($transaction->screenshot_path);
            }

            $transaction->delete();
        });

        return redirect()->back()->with('success', 'Transaction deleted and balance recalculated successfully.');
    }

    // Bulk delete transactions
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'transaction_ids' => 'required|array',
        ]);

        $transactions = Transaction::whereIn('id', $request->transaction_ids)->get();

        DB::transaction(function () use ($transactions) {
            foreach ($transactions as $transaction) {
                // Adjust balance
                if ($transaction->account_id && $transaction->status === 'completed') {
                    $account = $transaction->account;
                    if ($transaction->type === 'deposit') {
                        $account->balance -= $transaction->amount;
                    } else {
                        // withdraw + reverse revert = add back
                        $account->balance += $transaction->amount;
                    }
                    $account->save();
                }

                // Delete screenshot
                if ($transaction->screenshot_path && Storage::disk('public')->exists($transaction->screenshot_path)) {
                    Storage::disk('public')->delete($transaction->screenshot_path);
                }

                $transaction->delete();
            }
        });

        return redirect()->back()->with('success', 'Selected transactions deleted and balances recalculated.');
    }

    public function getUserByLiveId($live_id)
    {
        $account = Account::where('live_id', $live_id)->first();

        if ($account) {
            return response()->json([
                'success' => true,
                'user' => [
                    'id' => $account->user->id,
                    'name' => $account->user->name,
                    'account_id' => $account->id // send account id
                ]
            ]);
        }

        return response()->json(['success' => false]);
    }

    // Fetch completed transactions for a user to reverse
    public function getCompletedTransactions($user_id)
    {
        $transactions = Transaction::where('user_id', $user_id)
            ->where('status', 'completed')
            ->whereIn('type', ['deposit', 'withdraw'])
            ->get(['id', 'type', 'amount', 'method', 'beneficiary_name', 'bank_name', 'account_number', 'ifsc', 'bank_address', 'xynder_id', 'binance_id', 'upi_id']);

        return response()->json($transactions);
    }
}