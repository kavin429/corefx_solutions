@extends('admin.layouts.admin')

<!-- CSS -->
<link rel="stylesheet" href="{{ asset('css/pricing.css') }}">

@section('content')
<div class="container mt-4">
    <h2>Pricing Plans</h2>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPricingModal">
            <i class="bi bi-plus-circle"></i> Add New Plan
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Leverage</th>
                        <th>Min Lot</th>
                        <th>Pips</th>
                        <th>Swap</th>
                        <th>Commission</th>
                        <th>Spread</th>
                        <th width="160">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($plans as $plan)
                    <tr>
                        <td>{{ $plan->id }}</td>
                        <td>{{ $plan->name }}</td>
                        <td>${{ number_format($plan->price, 2) }}</td>
                        <td>{{ $plan->leverage }}</td>
                        <td>{{ $plan->min_lot_size }}</td>
                        <td>{{ $plan->starting_pips }}</td>
                        <td>{{ $plan->swap }}</td>
                        <td>{{ $plan->commission }}</td>
                        <td>{{ $plan->spread ?? '-' }}</td>
                        <td>
                            <!-- Edit Modal Button -->
                            <button type="button" class="btn1 btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editPricingModal{{ $plan->id }}">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>

                            <!-- Delete Form -->
                            <form action="{{ route('admin.pricing.destroy', $plan->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn1 btn-danger btn-sm" onclick="return confirm('Delete this plan?')">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editPricingModal{{ $plan->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('admin.pricing.update', $plan->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Pricing Plan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text" class="form-control mb-2" name="name" value="{{ $plan->name }}" required placeholder="Plan Name">
                                        <input type="number" class="form-control mb-2" name="price" value="{{ $plan->price }}" step="0.01" required placeholder="Price">
                                        <input type="text" class="form-control mb-2" name="leverage" value="{{ $plan->leverage }}" required placeholder="Leverage">
                                        <input type="number" class="form-control mb-2" name="min_lot_size" value="{{ $plan->min_lot_size }}" step="0.01" required placeholder="Min Lot Size">
                                        <input type="text" class="form-control mb-2" name="starting_pips" value="{{ $plan->starting_pips }}" required placeholder="Starting Pips">
                                        <input type="text" class="form-control mb-2" name="swap" value="{{ $plan->swap }}" required placeholder="Swap">
                                        <input type="number" class="form-control mb-2" name="commission" value="{{ $plan->commission }}" step="0.01" required placeholder="Commission">
                                        <input type="text" class="form-control mb-2" name="spread" value="{{ $plan->spread }}" placeholder="Spread (optional)">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Update Plan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted">No pricing plans found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addPricingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.pricing.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Plan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control mb-2" name="name" required placeholder="Plan Name">
                    <input type="number" class="form-control mb-2" name="price" step="0.01" required placeholder="Price">
                    <input type="text" class="form-control mb-2" name="leverage" required placeholder="Leverage">
                    <input type="number" class="form-control mb-2" name="min_lot_size" step="0.01" required placeholder="Min Lot Size">
                    <input type="text" class="form-control mb-2" name="starting_pips" required placeholder="Starting Pips">
                    <input type="text" class="form-control mb-2" name="swap" required placeholder="Swap">
                    <input type="number" class="form-control mb-2" name="commission" step="0.01" required placeholder="Commission">
                    <input type="text" class="form-control mb-2" name="spread" placeholder="Spread (optional)">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Plan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
