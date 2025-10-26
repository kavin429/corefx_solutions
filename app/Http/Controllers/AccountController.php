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

        return view('dashboard.accounts', compact('accounts'));
    }

    // Create a new account and notify admins
    public function store(Request $request)
    {
        try {
            // Validate input
            $request->validate([
                'type' => 'required|in:live,demo',
                'currency' => 'required|string|size:3',
            ]);

            // 1️⃣ Create the account
            $account = Account::create([
                'user_id' => Auth::id(),
                'live_id' => null, // admin assigns later
                'account_name' => Auth::user()->name,
                'type' => $request->type,
                'currency' => strtoupper($request->currency),
                'balance' => 0,
            ]);

            // 2️⃣ Notify all admins
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

            // Success message
            return redirect()->route('accounts.index')
                             ->with('success', 'Account created successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation errors
            return redirect()->back()
                             ->withErrors($e->errors())
                             ->withInput();
        } catch (\Exception $e) {
            // Other errors
            return redirect()->back()
                             ->with('error', 'Something went wrong: ' . $e->getMessage())
                             ->withInput();
        }
    }
}
