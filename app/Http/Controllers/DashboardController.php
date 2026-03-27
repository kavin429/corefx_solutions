<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Cookie\CookieJar;

class DashboardController extends Controller
{
    // ---------------------------
    // Hardcoded Infinity API Credentials
    // ---------------------------
    private $apiUsername = 'ADMIN'; // <-- put your API username here
    private $apiPassword = 'ADMIN'; // <-- put your API password here

    /** Display the main dashboard with live balances */
    public function index()
{
    $user = Auth::user();
    $profile = $user->profile;
    $accounts = $user->accounts;

    $totalBalance = 0;
    $liveBalances = [];
    $totalFixedPNL = 0;

    // ---------------------------
    // Infinity API LOGIN (once)
    // ---------------------------
    $cookieJar = new CookieJar();
    $loginResponse = Http::withOptions([
        'cookies' => $cookieJar,
        'verify'  => false,
    ])->get('https://api.infinitytradesolution.com/BOWCF/Backoffice.svc/BackofficeLogin', [
        'username' => $this->apiUsername,
        'password' => $this->apiPassword,
    ]);

    if (!$loginResponse->successful()) {
        abort(500, 'Infinity API login failed');
    }

    // ---------------------------
    // GET LIVE BALANCES & FLOATING PNL FOR ALL USER ACCOUNTS
    // ---------------------------
    foreach ($accounts as $account) {
        $liveBalance = 0;
        $floatingPNL = 0;

        if ($account->live_id) {
            $accountResponse = Http::withOptions([
                'cookies' => $cookieJar,
                'verify'  => false,
            ])->get('https://api.infinitytradesolution.com/BOWCF/Backoffice.svc/GetAccountByID', [
                'AccountID' => $account->live_id,
            ]);

            if ($accountResponse->successful()) {
                $accountData = json_decode($accountResponse->json('d'), true);
                $liveBalance = $accountData['Balance'] ?? 0;
                $floatingPNL = $accountData['FloatingProfitLoss'] ?? 0;
            }
        }

        $liveBalances[$account->id] = $liveBalance;

        // ---------------------------
        // CALCULATE FIXED PNL PER ACCOUNT
        // ---------------------------
        $totalDeposits = $account->transactions()
            ->where('type', 'deposit')
            ->where('status', 'completed')
            ->sum('amount');

        $totalWithdrawals = $account->transactions()
            ->where('type', 'withdraw')
            ->where('status', 'completed')
            ->sum('amount');

        $fixedPNL = $liveBalance - ($totalDeposits - $totalWithdrawals);

        // Add to total for dashboard
        $totalFixedPNL += $fixedPNL;

        // Optional: attach to account for easy access in view
        $account->fixedPNL = $fixedPNL;
        $account->floatingPNL = $floatingPNL;

        $totalBalance += $liveBalance;
    }

    // ---------------------------
    // DB-BASED DATA
    // ---------------------------
    $totalPNL = $accounts->sum('pnl');
    $totalIncome = $user->transactions()
        ->where('type', 'deposit')
        ->where('status', 'completed')
        ->sum('amount');

    $totalOutcome = $user->transactions()
        ->where('type', 'withdraw')
        ->where('status', 'completed')
        ->sum('amount');

    $transactions = $user->transactions()->latest()->get();
    $notifications = $user->notifications()->latest()->take(5)->get();

    return view('dashboard.index', compact(
        'user',
        'profile',
        'accounts',
        'totalBalance',
        'liveBalances',
        'totalPNL',
        'totalIncome',
        'totalOutcome',
        'transactions',
        'notifications',
        'totalFixedPNL' // <-- pass this to view
    ));
}


    /** Return JSON account details for a single account with live balance */
    public function getAccountDetails($accountId)
{
    $account = Account::with('transactions')->findOrFail($accountId);

    $liveBalance = 0;
    $floatingPNL = 0;
    $liveDeposit = 0;
    $totalDeposits = 0;
    $totalWithdrawals = 0;
    $fixedPNL = 0;

    if ($account->live_id) {
        $cookieJar = new CookieJar();

        // Login once
        $loginResponse = Http::withOptions([
            'cookies' => $cookieJar,
            'verify'  => false,
        ])->get('https://api.infinitytradesolution.com/BOWCF/Backoffice.svc/BackofficeLogin', [
            'username' => $this->apiUsername,
            'password' => $this->apiPassword,
        ]);

        if ($loginResponse->successful()) {
            $accountResponse = Http::withOptions([
                'cookies' => $cookieJar,
                'verify'  => false,
            ])->get('https://api.infinitytradesolution.com/BOWCF/Backoffice.svc/GetAccountByID', [
                'AccountID' => $account->live_id,
            ]);

            if ($accountResponse->successful()) {
                $accountData = json_decode($accountResponse->json('d'), true);

                $liveBalance = $accountData['Balance'] ?? 0;
                $floatingPNL = $accountData['FloatingProfitLoss'] ?? 0;
                $liveDeposit = $accountData['Deposit'] ?? 0;
            }
        }
    }

    // -----------------------------
    // Calculate fixed PNL using transactions
    // -----------------------------
    $totalDeposits = $account->transactions()
        ->where('type', 'deposit')
        ->where('status', 'completed')
        ->sum('amount');

    $totalWithdrawals = $account->transactions()
        ->where('type', 'withdraw')
        ->where('status', 'completed')
        ->sum('amount');

    $fixedPNL = $liveBalance - ($totalDeposits - $totalWithdrawals);

    return response()->json([
        'account_id'       => $account->id,
        'live_id'          => $account->live_id,
        'balance'          => $liveBalance,
        'floatingPNL'      => $floatingPNL,   // from API
        'fixedPNL'         => $fixedPNL,      // calculated
        'totalDeposit'     => $totalDeposits,
        'totalWithdraw'    => $totalWithdrawals,
    ]);
}

}