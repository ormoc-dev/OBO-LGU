<?php
// Inspectors Dashboard Navigation Component
?>
<style>
.logout-btn {
    background: linear-gradient(135deg, #dc3545, #c82333) !important;
    color: white !important;
    border-color: #dc3545 !important;
}

.logout-btn:hover {
    background: linear-gradient(135deg, #c82333, #a71e2a) !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
}

.logout-btn i {
    color: white !important;
}
</style>
<!-- Bottom Navbar with actions -->
<nav class="mech-bottomnav">
    <button class="nav-btn" data-action="home">
        <i class="fas fa-home"></i>
        <span>Home</span>
    </button>
    <button class="nav-btn primary" data-action="start">
        <i class="fas fa-play"></i>
        <span>Start</span>
    </button>

    <button class="nav-btn" data-action="reports">
        <i class="fas fa-file-alt"></i>
        <span>Reports</span>
    </button>
    <button class="nav-btn" data-action="profile">
        <i class="fas fa-user"></i>
        <span>Profile</span>
    </button>
    <button class="nav-btn logout-btn" data-action="logout">
        <i class="fas fa-sign-out-alt"></i>
        <span>Logout</span>
    </button>
</nav>
