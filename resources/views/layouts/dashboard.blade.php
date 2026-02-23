<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Trinity Global Capital LTD')</title>
    <link rel="icon" type="image/png" href="{{ asset('pics/icon1.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/clientDashboard.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
            <img src="{{ auth()->user()->profile->avatar_path ? Storage::url(auth()->user()->profile->avatar_path) : asset('pics/adminPro.jpeg') }}" 
     alt="Avatar" class="profile-avatar">

<nav>
    <a href="{{ route('dashboard') }}" 
       class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
       <i class="bi bi-house-door"></i> Dashboard
    </a>

    @if(auth()->user()->isFullyVerified())
        <a href="{{ route('dashboard.profile') }}" 
           class="{{ request()->routeIs('dashboard.profile') ? 'active' : '' }}">
           <i class="bi bi-person-circle"></i> Profile
        </a>

        <a href="{{ route('accounts.index') }}" 
           class="{{ request()->routeIs('accounts.index') ? 'active' : '' }}">
           <i class="bi bi-credit-card-2-front"></i> Accounts
        </a>

        <a href="{{ route('dashboard.transactions.index') }}" 
           class="{{ request()->routeIs('dashboard.transactions.*') ? 'active' : '' }}">
           <i class="bi bi-receipt"></i> Transactions
        </a>

        <a href="{{ route('deposit.index') }}" 
           class="{{ request()->routeIs('deposit.*') ? 'active' : '' }}">
           <i class="bi bi-wallet2"></i> Deposit
        </a>

        <a href="{{ route('withdraw.form') }}" 
           class="{{ request()->routeIs('withdraw.*') ? 'active' : '' }}">
           <i class="bi bi-cash-stack"></i> Withdraw
        </a>

        <a href="{{ route('user.notifications') }}" 
           class="{{ request()->routeIs('user.notifications') ? 'active' : '' }}">
           <i class="bi bi-bell"></i> Notifications
        </a>
    @endif

    <!-- Always show Verification link -->
    <a href="{{ route('verification.index') }}" 
       class="{{ request()->routeIs('verification.index') ? 'active' : '' }}">
       <i class="bi bi-shield-check"></i> Verified Documents
    </a>
</nav>
    </div> 

    <!-- Main Content -->
    <div class="main">
        <!-- Topbar -->
        <div class="topbar d-flex justify-content-between align-items-center">
            <div class="welcome-box">
            <h2 class="welcome">Hi, {{ auth()->user()->name }}</h2>
            </div>
            <div class="top-icons d-flex align-items-center gap-2">
               <!-- <i class="bi bi-moon fs-4 theme-toggle" id="theme-toggle"></i> -->
            <!-- Notification Button -->
            <button type="button" class="btn1 position-relative" id="notificationToggle" data-bs-toggle="modal" data-bs-target="#notificationModal">
                <i class="bi bi-bell fs-4"></i>
                <!-- Red dot badge -->
                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle" 
                id="notificationBadge" style="display: none;"></span>
            </button>
                
                <!-- Logout Icon -->
                <form method="POST" action="{{ route('user.logout') }}" class="logout-icon-form">
                @csrf
                <button type="submit" class="logout-icon">
                 <i class="bi bi-box-arrow-right fs-4"></i>
                </button>
                </form>
                <i class="bi bi-list fs-4 sidebar-toggle" id="sidebar-toggle"></i>
            </div>
        </div>

        <!-- Yield Content -->
        <div class="content p-4">
            @yield('content')
        </div>
    </div>


<!-- Notification Modal -->
<div class="modal" id="notificationModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">Notifications</h6>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-2">
        <ul class="list-group" id="notificationList">
          <!-- Notifications appended here by JS -->
        </ul>
        <p class="text-center" id="noNotifications" style="display: none;">No notifications.</p>
      </div>
    </div>
  </div>
</div>



<script>
document.addEventListener('DOMContentLoaded', function () {
    const notificationList = document.getElementById('notificationList');
    const noNotifications = document.getElementById('noNotifications');
    const notificationBadge = document.getElementById('notificationBadge');
    const notificationModalEl = document.getElementById('notificationModal');
    const notificationToggle = document.getElementById('notificationToggle');

    // Fetch notifications from server
    async function fetchNotifications() {
        try {
            const res = await fetch("{{ route('user.notifications.fetch') }}");
            if (!res.ok) throw new Error('Failed to fetch notifications');
            const data = await res.json();

            notificationList.innerHTML = '';
            let hasUnread = false;

            if (data.notifications?.length > 0) {
                noNotifications.style.display = 'none';

                data.notifications.forEach(n => {
                    const li = document.createElement('li');
                    li.classList.add('list-group-item', 'd-flex', 'flex-column', 'justify-content-start');
                    li.innerHTML = `
                        <strong>${n.title}</strong>
                        <p class="mb-0">${n.message}</p>
                        <small class="text-muted">${n.created_at}</small>
                    `;
                    notificationList.appendChild(li);

                    if (!n.is_read) hasUnread = true;
                });

                // Show red dot if there are unread notifications
                notificationBadge.style.display = hasUnread ? 'inline-block' : 'none';
            } else {
                noNotifications.style.display = 'block';
                notificationBadge.style.display = 'none';
            }
        } catch(err) {
            console.error('Error fetching notifications:', err);
            noNotifications.style.display = 'block';
            notificationBadge.style.display = 'none';
        }
    }

    // Mark all notifications as read
    async function markAsRead() {
        try {
            await fetch("{{ route('user.notifications.markAsRead') }}", {
                method: 'PUT', // Must match Laravel route
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            });
            notificationBadge.style.display = 'none'; // hide red dot
            fetchNotifications(); // refresh list to update read status
        } catch(err) {
            console.error('Error marking notifications as read:', err);
        }
    }

    // Poll every 5 seconds
    setInterval(fetchNotifications, 5000);
    fetchNotifications(); // Initial fetch

    // Mark as read when modal opens or bell clicked
    notificationModalEl.addEventListener('show.bs.modal', markAsRead);
    notificationToggle.addEventListener('click', markAsRead);
});
</script>




    <script src="{{ asset('js/clientDashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
