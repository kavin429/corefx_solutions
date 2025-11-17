<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Admin;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    // Show list of accounts for the user
    public function index(Request $request)
    {
        $query = Account::where('user_id', Auth::id());

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('live_id', 'like', "%{$search}%")
                  ->orWhere('account_name', 'like', "%{$search}%");
            });
        }

        $accounts = $query->orderBy('id', 'desc')->paginate(20);
        $accounts->appends($request->only('search'));

        // Check last account creation for cooldown
        $lastAccount = Account::where('user_id', Auth::id())
                              ->orderBy('created_at', 'desc')
                              ->first();

        $canCreate = true;
        $minutesLeft = 0;

        if ($lastAccount) {
            $diffMinutes = $lastAccount->created_at->diffInMinutes(now());
            if ($diffMinutes < 60) {
                $canCreate = false;
                $minutesLeft = 60 - $diffMinutes; // clean integer
            }
        }

        return view('dashboard.accounts', compact('accounts', 'canCreate', 'minutesLeft'));
    }

    // Create a new account and notify admins
public function store(Request $request)
{
    try {
        // Check if user created an account in the last 1 hour
        $lastAccount = Account::where('user_id', Auth::id())
                              ->orderBy('created_at', 'desc')
                              ->first();

        if ($lastAccount) {
            $diffMinutes = $lastAccount->created_at->diffInMinutes(now());
            if ($diffMinutes < 60) {
                $minutesLeft = 60 - $diffMinutes;
                return redirect()->back()
                                 ->with('error', "You can create a new account after {$minutesLeft} minutes.");
            }
        }

        // Validate input
        $request->validate([
            'type' => 'required|in:live,demo',
            'currency' => 'required|string|size:3',
        ]);

        // Create the account
        $account = Account::create([
            'user_id' => Auth::id(),
            'live_id' => null, // admin assigns later
            'account_name' => Auth::user()->name,
            'type' => $request->type,
            'currency' => strtoupper($request->currency),
            'balance' => 0,
        ]);

        // Notify all admins
        $message = "User ID " . Auth::id() . " (" . Auth::user()->email . ") has created a new account.";

        $admins = Admin::all();
        foreach ($admins as $admin) {
            Notification::create([
                'notifiable_id'   => $admin->id,
                'notifiable_type' => 'App\Models\Admin',
                'sender_id'       => Auth::id(),
                'sender_type'     => 'user',
                'title'           => 'New Account Created',
                'message'         => $message,
                'is_read'         => 0,
            ]);
        }

        return redirect()->route('accounts.index')
                         ->with('success', 'Account created successfully.');

    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()
                         ->withErrors($e->errors())
                         ->withInput();
    } catch (\Exception $e) {
        return redirect()->back()
                         ->with('error', 'Something went wrong: ' . $e->getMessage())
                         ->withInput();
    }
}
}
