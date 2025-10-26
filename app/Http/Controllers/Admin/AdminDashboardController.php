<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\Notification;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalAccounts = Account::count();
        $totalTransactions = Transaction::count();
        $totalNotifications = Notification::count();
        // Add these lines after totalTransactions
        $totalDeposits = Transaction::where('type', 'deposit')->count();
        $totalWithdrawals = Transaction::where('type', 'withdraw')->count();



        // === Monthly Users Data for Bar Chart ===
        $monthlyLabels = [];
        $monthlyUsers = [];
        for ($i = 0; $i < 12; $i++) {
            $month = now()->subMonths(11 - $i);
            $monthlyLabels[] = $month->format('M');
            $monthlyUsers[] = User::whereYear('created_at', $month->year)
                                  ->whereMonth('created_at', $month->month)
                                  ->count();
        }

        // === Accounts Pie Chart: Live ID vs Non-Live ID ===
        $liveAccounts = Account::whereNotNull('live_id')->count();
        $nonLiveAccounts = Account::whereNull('live_id')->count();
        $accountTypes = ['Live ID Accounts', 'Non-Live ID Accounts'];
        $accountCounts = [$liveAccounts, $nonLiveAccounts];

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAccounts',
            'totalTransactions',
            'totalDeposits',     // <-- new
            'totalWithdrawals',  // <-- new
            'totalNotifications',
            'monthlyLabels',
            'monthlyUsers',
            'accountTypes',
            'accountCounts'
        ));
    }

    public function dashboard()
    {
        $totalUsers = User::count();
        $totalAccounts = Account::count();
        $totalTransactions = Transaction::count();

        $notifications = auth()->guard('admin')->user()->notifications()->latest()->take(10)->get();
        $unreadCount = auth()->guard('admin')->user()->unreadNotifications()->count();

        // === Monthly Users Data for Bar Chart ===
        $monthlyLabels = [];
        $monthlyUsers = [];
        for ($i = 0; $i < 12; $i++) {
            $month = now()->subMonths(11 - $i);
            $monthlyLabels[] = $month->format('M');
            $monthlyUsers[] = User::whereYear('created_at', $month->year)
                                  ->whereMonth('created_at', $month->month)
                                  ->count();
        }

        // === Accounts Pie Chart: Live ID vs Non-Live ID ===
        $liveAccounts = Account::whereNotNull('live_id')->count();
        $nonLiveAccounts = Account::whereNull('live_id')->count();
        $accountTypes = ['Live ID Accounts', 'Non-Live ID Accounts'];
        $accountCounts = [$liveAccounts, $nonLiveAccounts];

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAccounts',
            'totalTransactions',
            'notifications',
            'unreadCount',
            'monthlyLabels',
            'monthlyUsers',
            'accountTypes',
            'accountCounts'
        ));
    }
}
