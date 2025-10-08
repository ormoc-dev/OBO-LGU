<?php
// System Admin Dashboard
require_once '../../api/auth/auth_helper.php';

// Require system admin role
requireRole('systemadmin');

$user = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Admin Dashboard</title>
    <link rel="icon" type="image/png" href="../../images/logo.png">
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="../../css/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../../css/Systemadmin/business_record.css">
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo" id="sidebarToggle">
                <img src="../../images/logo.png" alt="LGU Logo" class="logo-img">
                <div class="logo-text-container">
                    <span class="logo-text">OBO </span>
                    <span class="logo-text-sub">System Admin Dashboard</span>
                </div>

            </div>

        </div>

        <nav class="sidebar-nav">
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="#" class="nav-link active" data-page="dashboard">
                        <i class="fas fa-home"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-page="business_record">
                        <i class="fas fa-building"></i>
                        <span class="nav-text">Businesses</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-page="inspectors">
                        <i class="fas fa-users"></i>
                        <span class="nav-text">Inspectors</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-page="departments">
                        <i class="fas fa-building"></i>
                        <span class="nav-text">Departments</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-page="inspections">
                        <i class="fas fa-clipboard-list"></i>
                        <span class="nav-text">Inspections</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-page="reports">
                        <i class="fas fa-chart-bar"></i>
                        <span class="nav-text">Reports</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-page="settings">
                        <i class="fas fa-cog"></i>
                        <span class="nav-text">Settings</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="user-details">
                    <span class="user-name"><?php echo htmlspecialchars($user['username'] ?? 'Admin'); ?></span>
                    <span class="user-role">System Admin</span>
                </div>
            </div>
            <a href="#" class="logout-btn" onclick="confirmLogout()">
                <i class="fas fa-sign-out-alt"></i>
                <span class="nav-text">Logout</span>
            </a>
        </div>


    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <div class="topbar">
            <button class="mobile-menu-toggle" id="mobileMenuToggle">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="page-title">System Admin Dashboard</h1>
            <div class="topbar-actions">
                <button class="notification-btn">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">3</span>
                </button>
            </div>
        </div>

        <div class="content" id="mainContentArea">
            <!-- Content will be loaded dynamically here -->
        </div>
    </div>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Inspector-specific JavaScript -->
    <script src="../../script/inspectors/script.js"></script>
    <!-- Dashboard metrics JavaScript -->
    <script src="../../script/dashboard/metrics.js"></script>

    <!-- JavaScript for sidebar functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const contentArea = document.getElementById('mainContentArea');

            // Toggle sidebar
            function toggleSidebar() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('sidebar-collapsed');
            }

            // Initialize component-specific functionality
            function initializeComponent(page) {
                // Execute any scripts in the loaded content
                const scripts = contentArea.querySelectorAll('script');
                scripts.forEach(script => {
                    const newScript = document.createElement('script');
                    newScript.textContent = script.textContent;
                    document.head.appendChild(newScript);
                    document.head.removeChild(newScript);
                });

                // Component-specific initialization
                switch (page) {
                    case 'dashboard':
                        if (typeof loadDashboardMetrics === 'function') {
                            loadDashboardMetrics();
                        }
                        break;
                    case 'businesses':
                        initializeBusinessesComponent();
                        break;
                    case 'inspections':
                        initializeInspectionsComponent();
                        break;
                    case 'inspectors':
                        initializeInspectorsComponent();
                        break;
                    case 'departments':
                        initializeDepartmentsComponent();
                        break;
                    case 'reports':
                        initializeReportsComponent();
                        break;
                    case 'settings':
                        initializeSettingsComponent();
                        break;
                }
            }

            // Component initialization functions
            function initializeInspectionsComponent() {
                // Modal functionality
                const modal = document.getElementById('addInspectionModal');
                if (modal) {
                    // Close modal when clicking outside
                    document.addEventListener('click', function(event) {
                        if (event.target == modal) {
                            closeAddInspectionModal();
                        }
                    });
                }

                // Filter functionality
                const statusFilter = document.getElementById('statusFilter');
                const departmentFilter = document.getElementById('departmentFilter');
                const searchInput = document.getElementById('inspectionSearch');

                if (statusFilter) {
                    statusFilter.addEventListener('change', filterInspections);
                }
                if (departmentFilter) {
                    departmentFilter.addEventListener('change', filterInspections);
                }
                if (searchInput) {
                    searchInput.addEventListener('input', filterInspections);
                }
            }

            // Inspector component initialization is now handled by script/inspectors/script.js

            function initializeDepartmentsComponent() {
                // Similar initialization for departments component
                const modal = document.getElementById('addDepartmentModal');
                if (modal) {
                    document.addEventListener('click', function(event) {
                        if (event.target == modal) {
                            closeAddDepartmentModal();
                        }
                    });
                }
            }

            function initializeReportsComponent() {
                // Reports component initialization
            }

            function initializeSettingsComponent() {
                // Settings component initialization
            }

            // Load page content dynamically
            function loadPage(page) {
                // Remove active class from all nav links
                document.querySelectorAll('.nav-link').forEach(link => {
                    link.classList.remove('active');
                });

                // Add active class to clicked link
                document.querySelector(`[data-page="${page}"]`).classList.add('active');

                // Show loading indicator
                contentArea.innerHTML = '<div class="loading-spinner"><i class="fas fa-spinner fa-spin"></i> Loading...</div>';

                // Load the component
                fetch(`components/${page}.php`)
                    .then(response => response.text())
                    .then(data => {
                        contentArea.innerHTML = data;
                        // Re-initialize any component-specific functionality
                        initializeComponent(page);
                    })
                    .catch(error => {
                        console.error('Error loading page:', error);
                        contentArea.innerHTML = '<div class="error-message"><i class="fas fa-exclamation-triangle"></i> Error loading page. Please try again.</div>';
                    });
            }

            // Navigation click handlers
            document.querySelectorAll('.nav-link[data-page]').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const page = this.getAttribute('data-page');
                    loadPage(page);
                });
            });

            // Event listeners
            sidebarToggle.addEventListener('click', toggleSidebar);
            mobileMenuToggle.addEventListener('click', toggleSidebar);

            // Close sidebar on mobile when clicking outside
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    if (!sidebar.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                        sidebar.classList.remove('collapsed');
                        mainContent.classList.remove('sidebar-collapsed');
                    }
                }
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('collapsed');
                    mainContent.classList.remove('sidebar-collapsed');
                }
            });

            // Global modal functions
            window.openAddInspectionModal = function() {
                const modal = document.getElementById('addInspectionModal');
                if (modal) {
                    modal.style.display = 'block';
                }
            }

            window.closeAddInspectionModal = function() {
                const modal = document.getElementById('addInspectionModal');
                if (modal) {
                    modal.style.display = 'none';
                    const form = document.getElementById('addInspectionForm');
                    if (form) {
                        form.reset();
                    }
                }
            }

            window.saveInspection = function() {
                // Add your save logic here
                showNotification('Inspection scheduled successfully!', 'success');
                closeAddInspectionModal();
            }

            // Inspector modal and save functions are now handled by script/inspectors/script.js

            window.openAddDepartmentModal = function() {
                const modal = document.getElementById('addDepartmentModal');
                if (modal) {
                    modal.style.display = 'block';
                }
            }

            window.closeAddDepartmentModal = function() {
                const modal = document.getElementById('addDepartmentModal');
                if (modal) {
                    modal.style.display = 'none';
                    const form = document.getElementById('addDepartmentForm');
                    if (form) {
                        form.reset();
                    }
                }
            }

            window.saveDepartment = function() {
                showNotification('Department saved successfully!', 'success');
                closeAddDepartmentModal();
            }

            // Inspector action functions are now handled by script/inspectors/script.js

            // Filter function for inspections
            window.filterInspections = function() {
                const statusFilter = document.getElementById('statusFilter');
                const departmentFilter = document.getElementById('departmentFilter');
                const searchInput = document.getElementById('inspectionSearch');

                if (!statusFilter || !departmentFilter || !searchInput) return;

                const statusValue = statusFilter.value;
                const departmentValue = departmentFilter.value;
                const searchValue = searchInput.value.toLowerCase();

                const tableRows = document.querySelectorAll('.inspections-table tbody tr');

                tableRows.forEach(row => {
                    const status = row.querySelector('.status-badge').textContent.toLowerCase();
                    const department = row.cells[2].textContent.toLowerCase();
                    const location = row.cells[1].textContent.toLowerCase();
                    const inspector = row.cells[3].textContent.toLowerCase();

                    const matchesStatus = !statusValue || status.includes(statusValue);
                    const matchesDepartment = !departmentValue || department.includes(departmentValue);
                    const matchesSearch = !searchValue ||
                        location.includes(searchValue) ||
                        department.includes(searchValue) ||
                        inspector.includes(searchValue);

                    if (matchesStatus && matchesDepartment && matchesSearch) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            // Notification system
            window.showNotification = function(message, type = 'info') {
                // Remove existing notifications
                const existingNotifications = document.querySelectorAll('.notification');
                existingNotifications.forEach(notification => notification.remove());

                // Create notification element
                const notification = document.createElement('div');
                notification.className = `notification notification-${type}`;
                notification.innerHTML = `
                    <div class="notification-content">
                        <i class="fas ${getNotificationIcon(type)}"></i>
                        <span>${message}</span>
                        <button class="notification-close" onclick="this.parentElement.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;

                // Add to page
                document.body.appendChild(notification);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (notification.parentElement) {
                        notification.remove();
                    }
                }, 5000);
            }

            function getNotificationIcon(type) {
                switch (type) {
                    case 'success':
                        return 'fa-check-circle';
                    case 'error':
                        return 'fa-exclamation-circle';
                    case 'warning':
                        return 'fa-exclamation-triangle';
                    case 'info':
                        return 'fa-info-circle';
                    default:
                        return 'fa-info-circle';
                }
            }

            // Logout confirmation function
            window.confirmLogout = function() {
                showLogoutModal();
            };

            // Show professional logout modal
            window.showLogoutModal = function() {
                // Remove existing modal if any
                const existingModal = document.getElementById('logoutModal');
                if (existingModal) {
                    existingModal.remove();
                }

                // Create modal HTML
                const modalHTML = `
                    <div id="logoutModal" class="logout-modal-overlay">
                        <div class="logout-modal">
                            <div class="logout-modal-header">
                                <div class="logout-icon">
                                    <i class="fas fa-sign-out-alt"></i>
                                </div>
                                <h3>Confirm Logout</h3>
                            </div>
                            <div class="logout-modal-body">
                                <p>Are you sure you want to sign out of your account?</p>
                                <p class="logout-warning">You will need to log in again to access the system.</p>
                            </div>
                            <div class="logout-modal-footer">
                                <button class="btn-logout btn-secondary-logout" onclick="closeLogoutModal()">
                                    <i class="fas fa-times"></i>
                                    Cancel
                                </button>
                                <button class="btn-logout btn-danger-logout" onclick="performLogout()">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Sign Out
                                </button>
                            </div>
                        </div>
                    </div>
                `;

                // Add modal to page
                document.body.insertAdjacentHTML('beforeend', modalHTML);

                // Add modal styles
                const modalStyles = `
                    <style>
                        .logout-modal-overlay {
                            position: fixed;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            background: rgba(0, 0, 0, 0.5);
                            backdrop-filter: blur(5px);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            z-index: 10000;
                            animation: fadeIn 0.3s ease-out;
                        }

                        .logout-modal {
                            background: white;
                            border-radius: 12px;
                            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
                            max-width: 400px;
                            width: 90%;
                            animation: slideInUp 0.3s ease-out;
                        }

                        .logout-modal-header {
                            text-align: center;
                            padding: 2rem 2rem 1rem;
                            border-bottom: 1px solid #f0f0f0;
                        }

                        .logout-icon {
                            width: 60px;
                            height: 60px;
                            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
                            border-radius: 50%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            margin: 0 auto 1rem;
                        }

                        .logout-icon i {
                            color: white;
                            font-size: 1.5rem;
                        }

                        .logout-modal-header h3 {
                            margin: 0;
                            color: #2c3e50;
                            font-size: 1.5rem;
                            font-weight: 600;
                        }

                        .logout-modal-body {
                            padding: 1.5rem 2rem;
                            text-align: center;
                        }

                        .logout-modal-body p {
                            margin: 0 0 0.5rem;
                            color: #555;
                            line-height: 1.5;
                        }

                        .logout-warning {
                            font-size: 0.9rem;
                            color: #888;
                            font-style: italic;
                        }

                        .logout-modal-footer {
                            padding: 1rem 2rem 2rem;
                            display: flex;
                            gap: 1.5rem;
                            justify-content: flex-end;
                        }

                        .btn-logout {
                            padding: 0.75rem 1.5rem;
                            border: none;
                            border-radius: 8px;
                            font-size: 0.9rem;
                            font-weight: 500;
                            cursor: pointer;
                            transition: all 0.1s ease;
                            display: flex;
                            align-items: center;
                            gap: 0.5rem;
                        }

                        .btn-secondary-logout {
                            background: #f8f9fa;
                            color: #6c757d;
                            border: 1px solid #dee2e6;
                        }

                        .btn-secondary-logout:hover {
                            background: #e9ecef;
                            color: #495057;
                        }

                        .btn-danger-logout {
                            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
                            color: white;
                        }

                        .btn-danger-logout:hover {
                            background: linear-gradient(135deg, #ff5252, #d32f2f);
                            transform: translateY(-1px);
                            box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
                        }

                        @keyframes fadeIn {
                            from { opacity: 0; }
                            to { opacity: 1; }
                        }

                        @keyframes slideInUp {
                            from { 
                                opacity: 0;
                                transform: translateY(30px);
                            }
                            to { 
                                opacity: 1;
                                transform: translateY(0);
                            }
                        }
                    </style>
                `;

                // Add styles if not already present
                if (!document.getElementById('logoutModalStyles')) {
                    const styleElement = document.createElement('div');
                    styleElement.id = 'logoutModalStyles';
                    styleElement.innerHTML = modalStyles;
                    document.head.appendChild(styleElement);
                }

                // Close modal when clicking outside
                document.getElementById('logoutModal').addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeLogoutModal();
                    }
                });
            };

            // Close logout modal
            window.closeLogoutModal = function() {
                const modal = document.getElementById('logoutModal');
                if (modal) {
                    modal.style.animation = 'fadeOut 0.3s ease-out';
                    setTimeout(() => {
                        modal.remove();
                    }, 300);
                }
            };

            // Perform actual logout
            window.performLogout = function() {
                // Add loading state to logout button
                const logoutBtn = document.querySelector('#logoutModal .btn-danger-logout');
                const originalText = logoutBtn.innerHTML;
                logoutBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Signing Out...';
                logoutBtn.disabled = true;

                // Redirect to logout
                setTimeout(() => {
                    window.location.href = '../../api/auth/logout.php';
                }, 500);
            };

            // Load default page (dashboard) on page load
            loadPage('dashboard');
        });
    </script>


</body>

</html>