<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Account;
use App\Models\Notification;

class UserController extends Controller
{
    // Display a listing of all users with their accounts, optionally filtered by search.
    public function index(Request $request)
    {
        $query = User::with(['accounts', 'profile']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;

            $query->where(function($q) use ($search) {
                // Search by ID if numeric
                if (is_numeric($search)) {
                    $q->where('id', $search);
                }

                // Search by name, email, or profile phone
                $q->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('profile', function($q2) use ($search) {
                      $q2->where('phone_number', 'like', "%{$search}%");
                  });
            });
        }

        // ✅ Order latest users first
        $query->latest();

        // Paginate results (100 per page)
        $users = $query->paginate(100)->withQueryString();

        return view('admin.manageUser', compact('users'));
    }

    // Delete a user along with their avatar if exists.
    public function destroy(User $user)
    {
        if ($user->profile && $user->profile->avatar_path && file_exists(storage_path('app/public/' . $user->profile->avatar_path))) {
            unlink(storage_path('app/public/' . $user->profile->avatar_path));
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    // Toggle user active/inactive status.
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active; // flip status
        $user->save();

        return back()->with('success', 'User status updated successfully.');
    }

    // Update user details and optionally update profile fields.
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'promo_code' => 'nullable|string|max:50',
        ]);

        $user->update($request->only('name', 'email', 'promo_code'));

        // Update profile fields if profile exists
        if ($user->profile) {
            $user->profile->update([
                'phone' => $request->input('phone', $user->profile->phone),
                'country' => $request->input('country', $user->profile->country),
                'birth_date' => $request->input('birth_date', $user->profile->birth_date),
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    } 

    // Assign or update a Live ID for a user's account that currently has null live_id.
    public function assignLiveId(Request $request, User $user)
{
    $request->validate([
        'account_id' => 'required|exists:accounts,id',
        'live_id' => 'required|string|unique:accounts,live_id',
    ]);

    $account = $user->accounts()
                    ->where('id', $request->account_id)
                    ->whereNull('live_id')
                    ->firstOrFail();

    // ✅ Update both live_id and assigned timestamp
    $account->update([
        'live_id' => $request->live_id,
        'live_id_assigned_at' => now(), // <-- add this line
    ]);

    Notification::create([
        'notifiable_id'   => $user->id,
        'notifiable_type' => User::class,
        'sender_id'       => auth()->guard('admin')->id(),
        'sender_type'     => 'admin',
        'title'           => 'Live ID Assigned',
        'message'         => "A new Live ID ({$request->live_id}) has been assigned to your trading account.",
        'is_read'         => 0,
    ]);

    return redirect()->back()->with('success', 'Live ID assigned successfully!');
}


    public function sendResetLink(Request $request, $id)
    {
        $user = User::findOrFail($id);

        Notification::create([
            'notifiable_id'   => $user->id,
            'notifiable_type' => User::class,
            'sender_id'       => auth()->guard('admin')->id(),
            'sender_type'     => 'admin',
            'title'           => 'Password Reset Link Sent',
            'message'         => "Infinity Trade Solutions LTD has sent you a password reset link to your registered email address.",
            'is_read'         => 0,
        ]);

        return back()->with('success', 'Reset link sent and user notified.');
    }

public function deleteAccount(User $user, Account $account)
{
    // Ensure the account belongs to the user
    if ($account->user_id !== $user->id) {
        abort(403, 'Unauthorized action.');
    }

    // Delete the account
    $account->delete();

    return response()->json(['success' => true]);
}


}
