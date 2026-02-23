@extends('admin.layouts.admin')

<link rel="stylesheet" href="{{ asset('css/adminBlade.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


@section('content')

<div class="row g-3 mb-4 align-cards">
<div class="col-md-4">
    <div class="card p-3 text-center">
        <i class="bi bi-people card-icon fa-3x mb-4 mt-2"></i>
        <h6>Total Clients</h6>
        <h3>{{ $totalUsers }}</h3>
        
    </div>
</div>

<div class="col-md-4">
    <div class="card p-3 text-center">
        <i class="bi bi-wallet2 card-icon fa-3x mb-4 mt-2"></i>
        <h6>Total Accounts</h6>
        <h3>{{ $totalAccounts }}</h3>
        
    </div>
</div>



    <div class="col-md-4">
        <div class="card p-3">
            <h6>Total Transactions</h6>
            <h3>{{ $totalTransactions }}</h3>

            <!-- Nested row for deposits & withdrawals -->
            <div class="row mt-3 g-2">
                <div class="col-6">
                    <div class="card text-center p-2 bg-success text-white">
                        <h6>Deposits</h6>
                        <h5>{{ $totalDeposits }}</h5>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card text-center p-2 bg-danger text-white">
                        <h6>Withdrawals</h6>
                        <h5>{{ $totalWithdrawals }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row g-3">
    <div class="col-md-6">
        <div class="card chart-card">
            <h6 class="mb-3">Monthly Client Registrations</h6>
            <div class="chart-container">
                <canvas id="usersBarChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card chart-card">
            <h6 class="mb-3">Accounts by Type</h6>
            <div class="chart-container">
                <canvas id="accountsPieChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // -------- Bar Chart --------
    const usersCtx = document.getElementById('usersBarChart').getContext('2d');
    const gradientUsers = usersCtx.createLinearGradient(0, 0, 0, 400);
    gradientUsers.addColorStop(0, 'rgba(44, 207, 79, 0.8)');
    gradientUsers.addColorStop(1, 'rgba(89, 182, 118, 0.3)');

    new Chart(usersCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($monthlyLabels) !!},
            datasets: [{
                label: 'Users',
                data: {!! json_encode($monthlyUsers) !!},
                backgroundColor: gradientUsers,
                borderColor: 'rgb(89, 182, 136)',
                borderWidth: 1,
                borderRadius: 8,
                hoverBackgroundColor: 'rgb(89, 182, 131)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,   // ✅ Important
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, color: 'rgb(233, 252, 241)' },
                    grid: {
                        drawBorder: false,
                        color: 'rgba(255,255,255,0.1)',
                        borderDash: [3, 3]
                    }
                },
                x: {
                    ticks: { color: '#fff' },
                    grid: { display: false }
                }
            }
        }
    });

    // -------- Doughnut Chart --------
    const accountsCtx = document.getElementById('accountsPieChart').getContext('2d');

    new Chart(accountsCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($accountTypes) !!},
            datasets: [{
                data: {!! json_encode($accountCounts) !!},
                backgroundColor: [
                    'rgba(89, 182, 117, 0.8)',
                    'rgba(132, 255, 177, 0.8)'
                ],
                hoverBackgroundColor: [
                    'rgb(105, 182, 89)',
                    'rgb(132, 255, 204)'
                ],
                borderColor: '#a6e9cb',
                borderWidth: 2,
                hoverOffset: 10,
                cutout: '60%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,   // ✅ Important
            plugins: {
                legend: {
                    position: 'right',
                    labels: { 
                        color: '#fff', 
                        padding: 20, 
                        boxWidth: 20 
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(42, 87, 56, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    bodySpacing: 6,
                    padding: 10
                }
            }
        }
    });
</script>

@endsection
