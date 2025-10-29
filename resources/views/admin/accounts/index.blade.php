@extends('admin.layouts.admin')
<!-- your master admin layout -->

    <link rel="stylesheet" href="{{ asset('css/adminAccounts.css') }}">

    @section('title', 'Infinity Trade Solutions LTD')

    @section('content')
    <div class="container-fluid">
        <h2>Manage Accounts</h2>

        <!-- Success & Error Messages -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Search -->
        <form method="GET" action="{{ route('admin.accounts.index') }}" class="mb-3 d-flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" 
                placeholder="Search by Live ID or Name" class="form-control">
            <button type="submit" class="btn1 btn-primary">Search</button>
            <a href="{{ route('admin.accounts.index') }}" class="btn1 btn-secondary">Reset</a>
        </form>

        <!-- Accounts Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Live ID</th>                   
                        <th>User</th>
                        <!--<th>Type</th>-->
                        <th>Balance ($)</th>
                        <th>PNL ($)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($accounts as $account)
                        <tr>
                            <td>{{ ($accounts->currentPage() - 1) * $accounts->perPage() + $loop->iteration }}</td>
                            <td>{{ $account->live_id }}</td>
                            <td>{{ $account->user->name ?? 'N/A' }}</td>
                            <!--<td>{{ ucfirst($account->type) }}</td>-->
                            <td style="text-align:right;">{{ number_format($account->balance, 2) }}</td>
                            <td style="text-align:right;">{{ number_format($account->pnl, 2) }}</td>
                            <td class="d-flex gap-1">
                            <!-- Edit 
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editAccountModal{{ $account->id }}">
                                Edit
                            </button> -->

                            <!-- Upload PNL -->
                            <button class="btn1 btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#uploadPNLModal{{ $account->id }}">
                                Edit PNL
                            </button>

                            <!-- Toggle User Status -->
                            <form action="{{ route('admin.users.toggleStatus', $account->user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" 
                                class="btn1 btn-sm {{ $account->user->is_active ? 'btn-success' : 'btn-secondary' }}">
                                {{ $account->user->is_active ? 'Inactive' : 'Active' }}
                            </button>
                            </form>

                            <!-- Delete -->
                            <form action="{{ route('admin.accounts.destroy', $account->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                            <button type="submit" class="btn1 btn-danger btn-sm">Delete</button>
                            </form>
                            </td>
                        </tr>

                        <!-- ===== Edit Account Modal ===== 
                        <div class="modal fade" id="editAccountModal{{ $account->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                            <form method="POST" action="{{ route('admin.accounts.update', $account->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Account</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                                <div class="modal-body">
                                    <div class="mb-2">
                                        <label for="type_{{ $account->id }}" class="form-label">Account Type</label>
                                        <select name="type" id="type_{{ $account->id }}" class="form-control" required>
                                            <option value="live" {{ $account->type == 'live' ? 'selected' : '' }}>Live</option>
                                            <option value="demo" {{ $account->type == 'demo' ? 'selected' : '' }}>Demo</option>
                                        </select>
                                    </div>

                                    <div class="mb-2">
                                        <label for="currency_{{ $account->id }}" class="form-label">Currency</label>
                                        <input type="text" name="currency" id="currency_{{ $account->id }}" class="form-control" value="{{ $account->currency }}" required>
                                    </div>

                                    <div class="mb-2">
                                        <label for="balance_{{ $account->id }}" class="form-label">Balance</label>
                                        <input type="number" step="0.01" name="balance" id="balance_{{ $account->id }}" class="form-control" value="{{ $account->balance }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                            </div>
                            </div>
                        </div> -->

                        <!-- ===== Upload PNL Modal ===== -->
                        <div class="modal fade" id="uploadPNLModal{{ $account->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('admin.accounts.uploadPNL', $account->id) }}">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Upload PNL for Account {{ $account->live_id }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-2">
                                                <label for="pnl_{{ $account->id }}" class="form-label">PNL Amount (USD)</label>
                                                <input type="number" step="0.01" name="pnl" id="pnl_{{ $account->id }}" class="form-control" value="{{ $account->pnl ?? 0 }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn1 btn-primary btn-sm">Upload</button>
                                            <button type="button" class="btn1 btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>



                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No accounts found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination Links -->
        <div class="mt-3">
            {{ $accounts->links() }}
        </div>
    </div>
@endsection
