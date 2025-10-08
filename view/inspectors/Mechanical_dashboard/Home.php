<?php

?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mechanical Dashboard - LGU Annual Inspection System</title>
    <link rel="icon" type="image/png" href="../../../images/logo.png">
    <link rel="stylesheet" href="../../../css/main.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="mech-wrapper">
        <header class="mech-topbar">
            <div class="topbar-left">
                <img src="../../../images/logo.png" alt="LGU" class="logo">
                <h1>Mechanical</h1>
            </div>
            <div class="topbar-right">
                <span class="user"><?php echo htmlspecialchars($user['username'] ?? 'Inspector'); ?></span>
            </div>
        </header>

        <main class="mech-content" id="content"></main>

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
            <button class="nav-btn" data-action="scan">
                <i class="fas fa-qrcode"></i>
                <span>Scan</span>
            </button>
            <button class="nav-btn" data-action="reports">
                <i class="fas fa-file-alt"></i>
                <span>Reports</span>
            </button>
            <button class="nav-btn" data-action="profile">
                <i class="fas fa-user"></i>
                <span>Profile</span>
            </button>
        </nav>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Load metrics + lists from API
            function loadMechanicalStats() {
                fetch('../../../api/mechanical/metrics.php')
                    .then(r => r.json())
                    .then(res => {
                        if (!res.success) throw new Error(res.message || 'Failed');
                        document.getElementById('statToday').textContent = String(res.data.today || 0);
                        document.getElementById('statWeek').textContent = String(res.data.week || 0);
                        document.getElementById('statDone').textContent = String(res.data.completed || 0);
                    })
                    .catch(err => console.error('Metrics error', err));

                fetch('../../../api/mechanical/upcoming.php')
                    .then(r => r.json())
                    .then(res => {
                        if (!res.success) throw new Error(res.message || 'Failed');
                        renderList('upcomingList', (res.data || []).map(i => `
                            <div class="list-item">
                                <div class="li-main">${i.site}</div>
                                <div class="li-sub">${i.when} • ${i.ref}</div>
                            </div>`));
                    })
                    .catch(err => console.error('Upcoming error', err));

                fetch('../../../api/mechanical/recent.php')
                    .then(r => r.json())
                    .then(res => {
                        if (!res.success) throw new Error(res.message || 'Failed');
                        renderList('recentList', (res.data || []).map(i => `
                            <div class="list-item">
                                <div class="li-main">${i.status}</div>
                                <div class="li-sub">${i.site} • ${i.time}</div>
                            </div>`));
                    })
                    .catch(err => console.error('Recent error', err));
            }

            function renderList(targetId, items) {
                const el = document.getElementById(targetId);
                if (!el) return;
                if (!items.length) return;
                el.innerHTML = items.join('');
            }

            function handleBottomAction(action) {
                // Map actions to component targets
                const target = (
                    action === 'home' ? 'dashboard' :
                    action === 'start' ? 'start' :
                    action === 'scan' ? 'scan' :
                    action === 'reports' ? 'reports' :
                    action === 'profile' ? 'profile' : 'dashboard'
                );

                // Optional: set active state on nav buttons
                document.querySelectorAll('.mech-bottomnav .nav-btn').forEach(btn => {
                    btn.classList.toggle('primary', btn.getAttribute('data-action') === action);
                });

                navigateMech(target);
            }

            document.querySelectorAll('.mech-bottomnav .nav-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    handleBottomAction(this.getAttribute('data-action'));
                });
            });

            function navigateMech(target) {
                const content = document.getElementById('content');
                if (!content) return;
                const map = {
                    dashboard: 'components/dashboard.php',
                    scheduled: 'components/scheduled.php',
                    start: 'components/start.php',
                    scan: 'components/scan.php',
                    reports: 'components/report.php',
                    profile: 'components/profile.php'
                };
                const path = map[target] || map.dashboard;
                content.innerHTML = '<div class="loading-spinner"><i class="fas fa-spinner fa-spin"></i> Loading...</div>';
                fetch(path)
                    .then(r => r.text())
                    .then(html => {
                        content.innerHTML = html;
                        if (target === 'dashboard') {
                            loadMechanicalStats();
                        }
                        if (target === 'scheduled') {
                            fetch('../../../api/mechanical/scheduled.php')
                                .then(r => r.json())
                                .then(res => {
                                    if (!res.success) throw new Error(res.message || 'Failed');
                                    renderList('scheduledList', (res.data || []).map(i => `
                                        <div class=\"list-item\">
                                            <div class=\"li-main\">${i.site}</div>
                                            <div class=\"li-sub\">${i.when} • ${i.ref} ${i.type ? ('• ' + i.type) : ''}</div>
                                        </div>`));
                                })
                                .catch(err => console.error('Scheduled error', err));
                        }
                        if (target === 'start') {
                            const form = document.getElementById('startInspectionForm');
                            if (form) {
                                form.addEventListener('submit', function(e) {
                                    e.preventDefault();
                                    const payload = {
                                        site: document.getElementById('site').value,
                                        inspection_type: document.getElementById('inspectionType').value,
                                        schedule: document.getElementById('schedule').value,
                                        notes: document.getElementById('notes').value
                                    };
                                    const btn = form.querySelector('.btn-primary');
                                    const original = btn.innerHTML;
                                    btn.disabled = true;
                                    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
                                    fetch('../../../api/mechanical/create.php', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json'
                                            },
                                            body: JSON.stringify(payload)
                                        })
                                        .then(r => r.json())
                                        .then(res => {
                                            if (!res.success) throw new Error(res.message || 'Failed');
                                            alert('Inspection created');
                                            navigateMech('dashboard');
                                        })
                                        .catch(err => {
                                            console.error(err);
                                            alert('Failed to create');
                                        })
                                        .finally(() => {
                                            btn.disabled = false;
                                            btn.innerHTML = original;
                                        });
                                });
                            }
                        }
                    })
                    .catch(err => {
                        console.error('Load component error', err);
                        content.innerHTML = '<div class="error-message"><i class="fas fa-exclamation-triangle"></i> Error loading component</div>';
                    });
            }

            window.navigateMech = navigateMech;

            navigateMech('dashboard');
        });
    </script>

    <style>

    </style>
</body>

</html>