<?php
// Start session and get user data
session_start();

// Get user data from session - using your actual authentication system
require_once '../../../api/auth/auth_helper.php';

// Check if user is logged in
requireLogin();

// Get current user data from session
$user = getCurrentUser();

// If no user data, redirect to login
if (!$user) {
    header('Location: /OBO-LGU/view/auth/Login.php');
    exit;
}

// For testing - you can change this to test different roles
// $user['role'] = 'mechanical'; // Change to 'electrical/electronics', 'civil/structural', etc.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="icon" type="image/png" href="../../../images/logo.png">
    <link rel="stylesheet" href="../../../css/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <div class="mech-wrapper">
        <?php include '../../layouts/inspectors_header.php'; ?>
        
        <main class="mech-content" id="content"></main>
        
        <?php include '../../layouts/inspectors_nav.php'; ?>
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
                            // Wait a bit for the component to fully load
                            setTimeout(() => {
                                const form = document.getElementById('startInspectionForm');
                                if (form) {
                                    form.addEventListener('submit', function(e) {
                                        e.preventDefault();
                                        
                                        // Collect all form data including fee calculation
                                        const payload = {
                                            owner: document.getElementById('owner')?.value || '',
                                            location: document.getElementById('location')?.value || '',
                                            businessName: document.getElementById('businessName')?.value || '',
                                            applicationType: document.getElementById('applicationType')?.value || '',
                                            lcNumber: document.getElementById('lcNumber')?.value || '',
                                            mbNumber: document.getElementById('mbNumber')?.value || '',
                                            applicationDate: document.getElementById('applicationDate')?.value || '',
                                            returnDate: document.getElementById('returnDate')?.value || '',
                                            timeIn: document.getElementById('timeIn')?.value || '',
                                            timeOut: document.getElementById('timeOut')?.value || '',
                                            assessment: document.getElementById('assessment')?.value || '',
                                            remarks: document.getElementById('remarks')?.value || '',
                                            notes: document.getElementById('notes')?.value || '',
                                            calculatedFee: document.getElementById('calculatedFee')?.value || '0.00',
                                            // Fee details
                                            refrigeration: {
                                                tons: document.getElementById('refrigerationTons')?.value || '',
                                                category: document.getElementById('refrigerationCategory')?.value || ''
                                            },
                                            airConditioning: {
                                                type: document.getElementById('acType')?.value || '',
                                                units: document.getElementById('acUnits')?.value || ''
                                            },
                                            ventilation: {
                                                kw: document.getElementById('ventilationKw')?.value || '',
                                                category: document.getElementById('ventilationCategory')?.value || ''
                                            },
                                            escalators: {
                                                type: document.getElementById('escalatorType')?.value || '',
                                                units: document.getElementById('escalatorUnits')?.value || '',
                                                meters: document.getElementById('escalatorMeters')?.value || ''
                                            },
                                            elevators: {
                                                type: document.getElementById('elevatorType')?.value || '',
                                                units: document.getElementById('elevatorUnits')?.value || '',
                                                landings: document.getElementById('elevatorLandings')?.value || ''
                                            }
                                        };
                                        
                                        const btn = form.querySelector('.btn-primary');
                                        const original = btn.innerHTML;
                                        btn.disabled = true;
                                        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
                                        
                                        console.log('Submitting form data:', payload);
                                        
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
                                                alert('Inspection created successfully!');
                                                navigateMech('dashboard');
                                            })
                                            .catch(err => {
                                                console.error(err);
                                                alert('Failed to create inspection');
                                            })
                                            .finally(() => {
                                                btn.disabled = false;
                                                btn.innerHTML = original;
                                            });
                                    });
                                }
                                
                                // Initialize fee calculation functions after component loads
                                setTimeout(() => {
                                    // Define calculateFees function
                                    window.calculateFees = function() {
                                        let totalFee = 0;
                                        
                                        try {
                                            // Refrigeration & Ice Plant calculation
                                            const refrigerationTons = parseFloat(document.getElementById('refrigerationTons')?.value) || 0;
                                            const refrigerationCategory = document.getElementById('refrigerationCategory')?.value;
                                            
                                            if (refrigerationTons > 0 && refrigerationCategory) {
                                                switch(refrigerationCategory) {
                                                    case 'up_to_100':
                                                        totalFee += refrigerationTons * 25.00; // Php 25.00 per ton
                                                        break;
                                                    case '100_to_150':
                                                        totalFee += refrigerationTons * 20.00; // Php 20.00 per ton
                                                        break;
                                                    case '150_to_300':
                                                        totalFee += refrigerationTons * 15.00; // Php 15.00 per ton
                                                        break;
                                                    case '300_to_500':
                                                        totalFee += refrigerationTons * 10.00; // Php 10.00 per ton
                                                        break;
                                                    case 'above_500':
                                                        totalFee += refrigerationTons * 5.00; // Php 5.00 per ton
                                                        break;
                                                }
                                            }
                                            
                                            // Air Conditioning calculation
                                            const acType = document.getElementById('acType')?.value;
                                            const acUnits = parseFloat(document.getElementById('acUnits')?.value) || 0;
                                            
                                            if (acUnits > 0 && acType) {
                                                if (acType === 'window') {
                                                    totalFee += acUnits * 40.00; // Php 40.00 per unit
                                                } else if (acType === 'packaged') {
                                                    // For packaged AC, we need to handle the tiered pricing
                                                    let acFee = 0;
                                                    if (acUnits <= 100) {
                                                        acFee = acUnits * 25.00; // First 100 tons at Php 25.00
                                                    } else if (acUnits <= 150) {
                                                        acFee = 100 * 25.00 + (acUnits - 100) * 20.00; // First 100 at 25, next 50 at 20
                                                    } else {
                                                        acFee = 100 * 25.00 + 50 * 20.00 + (acUnits - 150) * 8.00; // Above 150 at 8
                                                    }
                                                    totalFee += acFee;
                                                }
                                            }
                                            
                                            // Mechanical Ventilation calculation
                                            const ventilationKw = parseFloat(document.getElementById('ventilationKw')?.value) || 0;
                                            const ventilationCategory = document.getElementById('ventilationCategory')?.value;
                                            
                                            if (ventilationKw > 0 && ventilationCategory) {
                                                switch(ventilationCategory) {
                                                    case 'up_to_1':
                                                        totalFee += ventilationKw * 10.00; // Php 10.00 per kW
                                                        break;
                                                    case '1_to_7_5':
                                                        totalFee += ventilationKw * 50.00; // Php 50.00 per kW
                                                        break;
                                                    case 'above_7_5':
                                                        totalFee += ventilationKw * 20.00; // Php 20.00 per kW
                                                        break;
                                                }
                                            }
                                            
                                            // Escalators & Moving Walks calculation
                                            const escalatorType = document.getElementById('escalatorType')?.value;
                                            const escalatorUnits = parseFloat(document.getElementById('escalatorUnits')?.value) || 0;
                                            const escalatorMeters = parseFloat(document.getElementById('escalatorMeters')?.value) || 0;
                                            
                                            if (escalatorUnits > 0 && escalatorType) {
                                                switch(escalatorType) {
                                                    case 'escalator':
                                                        totalFee += escalatorUnits * 120.00; // Php 120.00 per unit
                                                        break;
                                                    case 'funicular':
                                                        totalFee += escalatorUnits * 50.00; // Php 50.00 per kW
                                                        break;
                                                    case 'cable_car':
                                                        totalFee += escalatorUnits * 25.00; // Php 25.00 per kW
                                                        break;
                                                }
                                                
                                                if (escalatorMeters > 0) {
                                                    if (escalatorType === 'funicular') {
                                                        totalFee += escalatorMeters * 10.00; // Php 10.00 per lineal meter
                                                    } else if (escalatorType === 'cable_car') {
                                                        totalFee += escalatorMeters * 2.00; // Php 2.00 per lineal meter
                                                    }
                                                }
                                            }
                                            
                                            // Elevators calculation
                                            const elevatorType = document.getElementById('elevatorType')?.value;
                                            const elevatorUnits = parseFloat(document.getElementById('elevatorUnits')?.value) || 0;
                                            const elevatorLandings = parseFloat(document.getElementById('elevatorLandings')?.value) || 0;
                                            
                                            if (elevatorUnits > 0 && elevatorType) {
                                                let baseFee = 0;
                                                switch(elevatorType) {
                                                    case 'passenger':
                                                        baseFee = 500.00; // Php 500.00 per unit
                                                        break;
                                                    case 'freight':
                                                        baseFee = 400.00; // Php 400.00 per unit
                                                        break;
                                                    case 'dumbwaiter':
                                                        baseFee = 50.00; // Php 50.00 per unit
                                                        break;
                                                    case 'construction':
                                                        baseFee = 400.00; // Php 400.00 per unit
                                                        break;
                                                    case 'car':
                                                        baseFee = 500.00; // Php 500.00 per unit
                                                        break;
                                                }
                                                
                                                totalFee += elevatorUnits * baseFee;
                                                
                                                if (elevatorLandings > 0) {
                                                    totalFee += elevatorLandings * 50.00; // Php 50.00 per landing above 5
                                                }
                                            }
                                            
                                            // Update calculated fee display
                                            const feeInput = document.getElementById('calculatedFee');
                                            if (feeInput) {
                                                feeInput.value = totalFee > 0 ? totalFee.toFixed(2) : '';
                                            }
                                            
                                        } catch (error) {
                                            console.error('Error in calculateFees:', error);
                                        }
                                    };
                                    
                                    
                                    // Define resetForm function
                                    window.resetForm = function() {
                                        if (confirm('Are you sure you want to reset the form? All data will be lost.')) {
                                            document.getElementById('startInspectionForm').reset();
                                            document.getElementById('calculatedFee').value = '';
                                        }
                                    };
                                    
                                    // Set up event listeners for fee inputs
                                    const feeInputs = [
                                        'refrigerationTons', 'refrigerationCategory',
                                        'acType', 'acUnits',
                                        'ventilationKw', 'ventilationCategory',
                                        'escalatorType', 'escalatorUnits', 'escalatorMeters',
                                        'elevatorType', 'elevatorUnits', 'elevatorLandings'
                                    ];
                                    
                                    feeInputs.forEach(inputId => {
                                        const element = document.getElementById(inputId);
                                        if (element) {
                                            element.addEventListener('input', window.calculateFees);
                                            element.addEventListener('change', window.calculateFees);
                                            element.addEventListener('keyup', window.calculateFees);
                                        }
                                    });
                                    
                                    // Initial calculation
                                    window.calculateFees();
                                }, 500);
                            }, 300);
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
</body>
</html>