@extends('admin.layouts.admin')

<link rel="stylesheet" href="{{ asset('css/deposit-methods.css') }}">

@section('content')
<div class="container mt-4">
    <h2>Deposit Methods</h2>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Add New Deposit Method Form -->
    <form action="{{ route('admin.deposit-methods.store') }}" method="POST" class="mb-4">
        @csrf
        <div class="row g-3">
            <div class="col-md-3 col-sm-6">
                <input type="text" name="name" class="form-control" placeholder="Name" required>
            </div>
            <div class="col-md-3 col-sm-6">
                <input type="text" name="network" class="form-control" placeholder="Network (optional)">
            </div>
            <div class="col-md-3 col-sm-6">
                <input type="text" name="address" class="form-control" placeholder="Address" required>
            </div>
            <div class="col-md-3 col-sm-6">
                <button type="submit" class="btn btn-success w-100">Add Method</button>
            </div>
        </div>
    </form>

    <!-- Deposit Methods Table -->
    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Network</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($depositMethods as $method)
                <tr>
                    <td>{{ $method->name }}</td>
                    <td>{{ $method->network }}</td>
                    <td>{{ $method->address }}</td>
                    <td>
                       <div class="d-flex flex-column gap-2">
    <!-- Edit Form -->
    <form action="{{ route('admin.deposit-methods.update', $method->id) }}" method="POST" class="d-flex flex-column gap-2">
        @csrf
        @method('PUT')
        <input type="text" name="name" value="{{ $method->name }}" class="form-control form-control-sm w-100" required>
        <input type="text" name="network" value="{{ $method->network ?? '' }}" class="form-control form-control-sm w-100" placeholder="Network (optional)">
        <input type="text" name="address" value="{{ $method->address }}" class="form-control form-control-sm w-100" required>
        <button type="submit" class="btn1 btn-primary btn-sm w-100">Update</button>
    </form>

    <!-- Delete Form -->
    <form action="{{ route('admin.deposit-methods.destroy', $method->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn1 btn-danger btn-sm w-100" onclick="return confirm('Are you sure?')">Delete</button>
    </form>
</div>

</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
