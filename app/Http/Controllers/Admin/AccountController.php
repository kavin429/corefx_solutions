<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Facades\Http; 
use GuzzleHttp\Cookie\CookieJar;

class AccountController extends Controller
{
    // Hardcoded Infinity API credentials
    private $apiUsername = 'ADMIN';
    private $apiPassword = 'ADMIN';

    // Display a listing of accounts for admin
    public function index(Request $request)
{
    $query = Account::with('user')->whereNotNull('live_id');

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
        ->orderByDesc('live_id_assigned_at')
        ->orderByDesc('id')
        ->paginate(100);

    // -------------------------
    // Fetch API values for each account
    // -------------------------
    $cookieJar = new CookieJar();

    // Login to API once
    $loginResponse = Http::withOptions([
        'cookies' => $cookieJar,
        'verify' => false,
    ])->get('https://api.infinitytradesolution.com/BOWCF/Backoffice.svc/BackofficeLogin', [
        'username' => $this->apiUsername,
        'password' => $this->apiPassword,
    ]);

    if ($loginResponse->successful()) {
        foreach ($accounts as $account) {
            if ($account->live_id) {
                $accountResponse = Http::withOptions([
                    'cookies' => $cookieJar,
                    'verify' => false,
                ])->get('https://api.infinitytradesolution.com/BOWCF/Backoffice.svc/GetAccountByID', [
                    'AccountID' => $account->live_id,
                ]);

                if ($accountResponse->successful()) {
                    $data = json_decode($accountResponse->json('d'), true);

                    // Override DB values with API values
                    $balance = $data['Balance'] ?? 0;
                $account->balance = $balance;
                    $account->pnl     = $data['FloatingProfitLoss'] ?? 0;
                    $account->deposit = $data['Deposit'] ?? 0; // optional, you can add this field
                $totalDeposits = $account->transactions()
    ->where('type', 'deposit')
    ->where('status', 'completed')
    ->sum('amount');

$totalWithdrawals = $account->transactions()
    ->where('type', 'withdraw')
    ->where('status', 'completed')
    ->sum('amount');

$account->fixed_pnl = $balance - ($totalDeposits - $totalWithdrawals);
                
                    }
            }
        }
    }

    $accounts->appends($request->only('search'));
    $users = User::all();

    return view('admin.accounts.index', compact('accounts', 'users'));
}


    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:live,demo',
            'currency' => 'required|string|size:3',
            'balance' => 'nullable|numeric|min:0',
        ]);

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
            'balance' => $request->balance ?? 0,
        ]);

        return redirect()->back()->with('success', 'Account created successfully!');
    }

    public function update(Request $request, Account $account)
    {
        $request->validate([
            'account_name' => 'required|string|max:255',
            'type' => 'required|in:live,demo',
            'currency' => 'required|string|size:3',
            'balance' => 'required|numeric|min:0',
        ]);

        $account->update([
            'account_name' => $request->account_name,
            'type' => $request->type,
            'currency' => strtoupper($request->currency),
            'balance' => $request->balance,
        ]);

        return redirect()->back()->with('success', 'Account updated successfully!');
    }

    public function destroy(Account $account)
    {
        $account->delete();
        return redirect()->back()->with('success', 'Account deleted successfully!');
    }

    /**
     * Sync account from Infinity API and update PNL, deposit, and balance
     */
    public function syncFromAPI(Account $account)
    {
        if (!$account->live_id) {
            return redirect()->back()->with('error', 'Account has no Live ID.');
        }

        $cookieJar = new CookieJar();

        // Login to API
        $loginResponse = Http::withOptions([
            'cookies' => $cookieJar,
            'verify'  => false,
        ])->get('https://api.infinitytradesolution.com/BOWCF/Backoffice.svc/BackofficeLogin', [
            'username' => $this->apiUsername,
            'password' => $this->apiPassword,
        ]);

        if (!$loginResponse->successful()) {
            return redirect()->back()->with('error', 'Infinity API login failed.');
        }

        // Fetch account data
        $accountResponse = Http::withOptions([
            'cookies' => $cookieJar,
            'verify'  => false,
        ])->get('https://api.infinitytradesolution.com/BOWCF/Backoffice.svc/GetAccountByID', [
            'AccountID' => $account->live_id,
        ]);

        if (!$accountResponse->successful()) {
            return redirect()->back()->with('error', 'Failed to fetch account data from API.');
        }

        $accountData = json_decode($accountResponse->json('d'), true);

        // Get API values
        $liveBalance = $accountData['Balance'] ?? 0;
        $livePNL     = $accountData['FloatingProfitLoss'] ?? 0;
        $liveDeposit = $accountData['Deposit'] ?? 0;

        // Update account in DB
        $account->pnl     = $livePNL;
        $account->balance = $liveDeposit + $livePNL; // Assuming withdrawal handled in separate transactions
        $account->save();

        return redirect()->back()->with('success', 'Account synced from API successfully!');
    }

    public function updateLiveId(Request $request, Account $account)
{
    $request->validate([
        'live_id' => 'required|string|max:255|unique:accounts,live_id,' . $account->id,
    ]);

    $account->update([
        'live_id' => $request->live_id,
    ]);

    return redirect()->back()->with('success', 'Live ID updated successfully!');
}
}