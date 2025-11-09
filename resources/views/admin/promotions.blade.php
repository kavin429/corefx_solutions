@extends('admin.layouts.admin')
<link rel="stylesheet" href="{{ asset('css/adminPromotions.css') }}">

@section('content')
<div class="container">
<h2>Promotions</h2>
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <button class="btn1 btn-success" data-bs-toggle="modal" data-bs-target="#addPromotionModal">
        <i class="bi bi-plus-circle"></i> Add New Promotion
    </button>
</div>

<!-- Table -->
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Created At</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Popup Image</th>
                    <th>Popup Enabled</th>
                    <th>Poster Small</th>
                    <th>Poster Medium</th>
                    <th>Poster X-Medium</th>
                    <th>Poster Large</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($promotions as $index => $promo)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
    <span class="promo-time" data-utc="{{ $promo->created_at->toIso8601String() }}">
        {{ $promo->created_at->format('Y-m-d') }}
    </span>
</td>
                    <td>{{ $promo->title }}</td>
                    <td>{{ $promo->description }}</td>
                    <td>
                        @if($promo->popup_image)
                            <img src="{{ asset('storage/' . $promo->popup_image) }}" width="80" class="rounded shadow-sm">
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.promotions.toggle', $promo->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn1 btn-sm {{ $promo->popup_enabled ? 'btn-success' : 'btn-secondary' }}">
                                {{ $promo->popup_enabled ? 'Enabled' : 'Disabled' }}
                            </button>
                        </form>
                    </td>
                    <td>
                        @if($promo->poster_small)
                            <img src="{{ asset('storage/' . $promo->poster_small) }}" width="80" class="rounded shadow-sm">
                        @endif
                    </td>
                    <td>
                        @if($promo->poster_medium)
                            <img src="{{ asset('storage/' . $promo->poster_medium) }}" width="120" class="rounded shadow-sm">
                        @endif
                    </td>
                    <td>
                        @if($promo->poster_xmedium)
                            <img src="{{ asset('storage/' . $promo->poster_xmedium) }}" width="140" class="rounded shadow-sm">
                        @endif
                    </td>
                    <td>
                        @if($promo->poster_large)
                            <img src="{{ asset('storage/' . $promo->poster_large) }}" width="160" class="rounded shadow-sm">
                        @endif
                    </td>
                    <td class="text-center">
                        <button class="btn1 btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editPromotionModal{{ $promo->id }}">
                            Edit
                        </button>
                        <form action="{{ route('admin.promotions.destroy', $promo->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this promotion?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn1 btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editPromotionModal{{ $promo->id }}" tabindex="-1" aria-labelledby="editPromotionModalLabel{{ $promo->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content border-0 shadow-lg">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title fw-bold" id="editPromotionModalLabel{{ $promo->id }}">Edit Promotion</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('admin.promotions.update', $promo->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Title</label>
                                            <input type="text" name="title" class="form-control" value="{{ $promo->title }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Description</label>
                                            <input type="text" name="description" class="form-control" value="{{ $promo->description }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Popup Image</label>
                                            <input type="file" name="popup_image" class="form-control" accept="image/*">
                                            @if($promo->popup_image)
                                                <img src="{{ asset('storage/' . $promo->popup_image) }}" width="80" class="rounded mt-2">
                                            @endif
                                        </div>
                                        <div class="col-md-6 mt-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="popup_enabled" id="popup_enabled{{ $promo->id }}" {{ $promo->popup_enabled ? 'checked' : '' }}>
                                                <label class="form-check-label fw-semibold" for="popup_enabled{{ $promo->id }}">Enable Popup on Home Page</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label fw-semibold">Small Poster</label>
                                            <input type="file" name="poster_small" class="form-control" accept="image/*">
                                            @if($promo->poster_small)
                                                <img src="{{ asset('storage/' . $promo->poster_small) }}" width="80" class="rounded mt-2">
                                            @endif
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label fw-semibold">Medium Poster</label>
                                            <input type="file" name="poster_medium" class="form-control" accept="image/*">
                                            @if($promo->poster_medium)
                                                <img src="{{ asset('storage/' . $promo->poster_medium) }}" width="120" class="rounded mt-2">
                                            @endif
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label fw-semibold">X-Medium Poster</label>
                                            <input type="file" name="poster_xmedium" class="form-control" accept="image/*">
                                            @if($promo->poster_xmedium)
                                                <img src="{{ asset('storage/' . $promo->poster_xmedium) }}" width="140" class="rounded mt-2">
                                            @endif
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label fw-semibold">Large Poster</label>
                                            <input type="file" name="poster_large" class="form-control" accept="image/*">
                                            @if($promo->poster_large)
                                                <img src="{{ asset('storage/' . $promo->poster_large) }}" width="160" class="rounded mt-2">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn1 btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn1 btn-primary">Update Promotion</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @empty
                <tr>
                    <td colspan="11" class="text-muted py-3">No promotions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</div>

<!-- Add Promotion Modal -->
<div class="modal fade" id="addPromotionModal" tabindex="-1" aria-labelledby="addPromotionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary">
                <h5 class="modal-title fw-bold" id="addPromotionModalLabel">Add New Promotion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.promotions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter promotion title">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Description</label>
                            <input type="text" name="description" class="form-control" placeholder="Short description">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Popup Image</label>
                            <input type="file" name="popup_image" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-6 mt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="popup_enabled" id="popup_enabled">
                                <label class="form-check-label fw-semibold" for="popup_enabled">Enable Popup on Home Page</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Small Poster (300x300)</label>
                            <input type="file" name="poster_small" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Medium Poster (600x600)</label>
                            <input type="file" name="poster_medium" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">X-Medium Poster (900x900)</label>
                            <input type="file" name="poster_xmedium" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Large Poster (1200x1200)</label>
                            <input type="file" name="poster_large" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn1 btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn1 btn-primary">Save Promotion</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('js/time.js') }}"></script>
@endsection
