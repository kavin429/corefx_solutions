<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Trinity Global Capital LTD')</title>
    <link rel="icon" type="pics/icon.png" href="{{ asset('pics/Trinitylogo1.png') }}" />
    
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- Link your profile CSS -->
    <link rel="stylesheet" href="{{ asset('css/adminBlade.css') }}">
</head>
<body>

<!-- <a href="{{ route('admin.transactions.index') }}" 
        class="{{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}"> 
            <i class="bi bi-currency-exchange"></i> 
        Manage Transactions 
     </a> --> 

    <div class="sidebar" id="sidebar">

        <div class="text-center mb-4">
            <!-- Profile Picture -->
            @if(Auth::guard('admin')->user()->profile_picture)
                <img src="{{ asset('storage/' . Auth::guard('admin')->user()->profile_picture) }}" 
                    alt="Profile Picture" 
                    class="rounded-circle mb-2 profile-pic">
            @else
                <img src="{{ asset('pics/adminPro.jpeg') }}" 
                    alt="Default Profile" 
                    class="rounded-circle mb-2 profile-pic">
            @endif
        </div>

        @php
            // Determine active sections
            $dashboardActive = request()->routeIs('admin.dashboard');
            $usersActive = request()->routeIs('users.*') || request()->routeIs('admin.verifications') || request()->routeIs('pending.*');
            $accountsActive = request()->routeIs('admin.accounts.*') || request()->routeIs('admin.transactions.history') || request()->routeIs('admin.withdrawals.*') || request()->routeIs('admin.deposits.*');
            $notificationsActive = request()->routeIs('admin.notifications.*');
            $settingsActive = request()->routeIs('admin.profile') || request()->routeIs('admin.pricing.*') || request()->routeIs('admin.deposit-methods.*') || request()->routeIs('admin.promotions.index');
        @endphp

        <!-- Sidebar Accordion -->
        <div class="accordion" id="sidebarAccordion">

            <!-- Dashboard (Not collapsible) -->
            <div class="mb-2">
                <a href="{{ route('admin.dashboard') }}" 
                    class="d-flex align-items-center sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </div>

            <!-- User Management -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingUsers">
                    <button class="accordion-button {{ $usersActive ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUsers" aria-expanded="{{ $usersActive ? 'true' : 'false' }}">
                        <i class="bi bi-people me-2"></i> Clients 
                    </button>
                </h2>
                <div id="collapseUsers" class="accordion-collapse collapse {{ $usersActive ? 'show' : '' }}" data-bs-parent="#sidebarAccordion">
                    <div class="accordion-body p-1">
                        <a href="{{ route('users.index') }}" class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">Manage Clients</a>
                        <a href="{{ route('admin.verifications') }}" class="sidebar-link {{ request()->routeIs('admin.verifications') ? 'active' : '' }}">Client Verifications</a>
                        <!-- 🔹 New Pending Registrations link -->
            <a href="{{ route('pending.index') }}" 
               class="sidebar-link {{ request()->routeIs('pending.*') ? 'active' : '' }}">
               Pending Registrations
            </a>
                    </div>
                </div>
            </div>

            <!-- Account & Transactions -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingAccounts">
                    <button class="accordion-button {{ $accountsActive ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAccounts" aria-expanded="{{ $accountsActive ? 'true' : 'false' }}">
                        <i class="bi bi-wallet2 me-2"></i> Accounts
                    </button>
                </h2>
                <div id="collapseAccounts" class="accordion-collapse collapse {{ $accountsActive ? 'show' : '' }}" data-bs-parent="#sidebarAccordion">
                    <div class="accordion-body p-1">
                        <a href="{{ route('admin.accounts.index') }}" class="sidebar-link {{ request()->routeIs('admin.accounts.*') ? 'active' : '' }}">Manage Accounts</a>
                        <a href="{{ route('admin.withdrawals.index') }}" class="sidebar-link {{ request()->routeIs('admin.withdrawals.*') ? 'active' : '' }}">Withdraw Requests</a>
                        <a href="{{ route('admin.deposits.index') }}" class="sidebar-link {{ request()->routeIs('admin.deposits.*') ? 'active' : '' }}"> Deposit Requests</a>
                        <a href="{{ route('admin.transactions.history') }}" class="sidebar-link {{ request()->routeIs('admin.transactions.history') ? 'active' : '' }}">Manage Transactions</a>
                        
                    </div>
                </div>
            </div>

            <!-- Notifications -->
            <a href="{{ route('admin.notifications.create') }}" class="sidebar-link {{ $notificationsActive ? 'active' : '' }}">
                <i class="bi bi-bell me-2"></i> Notifications
            </a>

            <!-- Settings -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSettings">
                    <button class="accordion-button {{ $settingsActive ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSettings" aria-expanded="{{ $settingsActive ? 'true' : 'false' }}">
                        <i class="bi bi-gear me-2"></i> Settings
                    </button>
                </h2>
                <div id="collapseSettings" class="accordion-collapse collapse {{ $settingsActive ? 'show' : '' }}" data-bs-parent="#sidebarAccordion">
                    <div class="accordion-body p-1">
                        <a href="{{ route('admin.profile') }}" class="sidebar-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}">Admin Profile</a>
                        <a href="{{ route('admin.pricing.index') }}" class="sidebar-link {{ request()->routeIs('admin.pricing.*') ? 'active' : '' }}">Site Settings</a>
                        <a href="{{ route('admin.deposit-methods.index') }}" class="sidebar-link {{ request()->routeIs('admin.deposit-methods.*') ? 'active' : '' }}"> Deposit Methods </a>
                        <a href="{{ route('admin.promotions.index') }}" class="sidebar-link {{ request()->routeIs('admin.promotions.index') ? 'active' : '' }}">Manage Promotions</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Main Content -->
    <div class="main">
        <!-- Topbar -->
        <div class="topbar d-flex justify-content-between align-items-center px-3 py-2">
            <!-- Greeting (optional, small) -->
            <span class="topbar-greeting">Hi, {{ Auth::guard('admin')->user()->name ?? 'Admin' }}</span>

            <!-- Icons -->
            <div class="topbar-icons d-flex align-items-center gap-2">
                <!-- Dark Mode Toggle 
                <button class="topbar-btn" id="darkModeToggle" title="Toggle Dark Mode">
                    <i class="bi bi-moon"></i>
                </button> -->

                <!-- Notifications -->
                <button type="button" class="topbar-btn position-relative" id="notificationToggle" data-bs-toggle="modal" data-bs-target="#notificationModal" title="Notifications">
                    <i class="bi bi-bell"></i>
                    <span class="notification-badge" id="notificationBadge" style="display:none;"></span>
                </button>

                <!-- Logout -->
                <form method="POST" action="{{ route('admin.logout') }}" class="m-0 p-0">
                    @csrf
                    <button type="submit" class="topbar-btn" title="Logout">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>

                <!-- Sidebar Toggle (Mobile) -->
                <i class="bi bi-list d-md-none topbar-btn" id="sidebarToggle" title="Toggle Sidebar"></i>
            </div>
        </div>

       <!-- Notification Dropdown -->
<div class="modal" id="notificationModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Notifications</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group" id="notificationList"></ul>
                <p class="text-center" id="noNotifications" style="display:none;">No notifications.</p>
            </div>
        </div>
    </div>
</div>
        
        <!-- Page Content -->
        @yield('content')
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    if(sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
    }

    const darkBtn = document.getElementById('darkModeToggle');

    // ✅ Restore dark mode on page load
    if (localStorage.getItem('theme') === 'dark') {
        document.body.classList.add('dark');
    }

    if(darkBtn) {
        darkBtn.addEventListener('click', () => {
            document.body.classList.toggle('dark');

            // ✅ Save theme preference
            if (document.body.classList.contains('dark')) {
                localStorage.setItem('theme', 'dark');
            } else {
                localStorage.setItem('theme', 'light');
            }
        });
    }
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const notificationList = document.getElementById('notificationList');
    const noNotifications = document.getElementById('noNotifications');
    const notificationBadge = document.getElementById('notificationBadge');
    const notificationModal = document.getElementById('notificationModal');
    const notificationToggle = document.getElementById('notificationToggle');

    async function fetchNotifications() {
        try {
            const res = await fetch("{{ route('admin.notifications.fetch') }}");
            const data = await res.json();
            notificationList.innerHTML = '';

            let hasUnread = false;

            if (data.notifications.length > 0) {
                noNotifications.style.display = 'none';

                data.notifications.forEach(n => {
                    const li = document.createElement('li');
                    li.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-start');
                    li.innerHTML = `
                        <div>
                            <strong>${n.title}</strong>
                            <p class="mb-0">${n.message}</p>
                            <small class="text-muted">${n.created_at}</small>
                        </div>
                    `;
                    notificationList.appendChild(li);

                    if (!n.is_read) hasUnread = true;
                });

                notificationBadge.style.display = hasUnread ? 'inline-block' : 'none';
            } else {
                noNotifications.style.display = 'block';
                notificationBadge.style.display = 'none';
            }
        } catch (err) {
            console.error(err);
            noNotifications.style.display = 'block';
        }
    }

    // Poll every 5 seconds
    setInterval(fetchNotifications, 5000);
    fetchNotifications();

    async function markAsRead() {
        notificationBadge.style.display = 'none';
        try {
            await fetch("{{ route('admin.notifications.markAsRead') }}", {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
            });
        } catch (err) { console.error(err); }
    }

    notificationModal.addEventListener('show.bs.modal', markAsRead);
    notificationToggle.addEventListener('click', markAsRead);
});
</script>

</body>
</html>
