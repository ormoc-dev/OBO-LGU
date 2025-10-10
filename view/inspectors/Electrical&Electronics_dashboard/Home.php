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
                fetch('../../../api/inspections/get_inspections.php')
                    .then(r => r.json())
                    .then(res => {
                        if (!res.success) throw new Error(res.message || 'Failed');
                        const stats = res.data.statistics;
                        document.getElementById('statToday').textContent = String(stats.today || 0);
                        document.getElementById('statWeek').textContent = String(stats.this_week || 0);
                        document.getElementById('statDone').textContent = String(stats.completed || 0);
                    })
                    .catch(err => console.error('Metrics error', err));

                // Load recent inspections
                fetch('../../../api/inspections/get_inspections.php?limit=5')
                    .then(r => r.json())
                    .then(res => {
                        if (!res.success) throw new Error(res.message || 'Failed');
                        const inspections = res.data.inspections || [];
                        renderList('recentList', inspections.map(i => `
                            <div class="list-item">
                                <div class="li-main">${i.inspection_number}</div>
                                <div class="li-sub">${i.status} • ${new Date(i.created_at).toLocaleDateString()}</div>
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
                // Handle logout action
                if (action === 'logout') {
                    if (confirm('Are you sure you want to logout?')) {
                        // Call logout API
                        fetch('../../../api/auth/logout.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Redirect to login page
                                window.location.href = '/OBO-LGU/view/auth/Login.php';
                            } else {
                                alert('Logout failed. Please try again.');
                            }
                        })
                        .catch(error => {
                            console.error('Logout error:', error);
                            // Force redirect even if API fails
                            window.location.href = '/OBO-LGU/view/auth/Login.php';
                        });
                    }
                    return;
                }

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
                                        
                                        fetch('../../../api/inspections/create.php', {
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
                                
                                // Initialize tab functionality
                                const tabButtons = document.querySelectorAll('.tab-btn');
                                const tabContents = document.querySelectorAll('.tab-content');
                                
                                tabButtons.forEach(button => {
                                    button.addEventListener('click', () => {
                                        // Remove active class from all buttons and contents
                                        tabButtons.forEach(btn => btn.classList.remove('active'));
                                        tabContents.forEach(content => content.classList.remove('active'));
                                        
                                        // Add active class to clicked button
                                        button.classList.add('active');
                                        
                                        // Show corresponding content
                                        const targetTab = button.getAttribute('data-tab');
                                        const targetContent = document.getElementById(targetTab);
                                        if (targetContent) {
                                            targetContent.classList.add('active');
                                        }
                                    });
                                });

                                // Initialize fee calculation functions after component loads
                                setTimeout(() => {
                                    // Define calculateFees function for Electrical & Electronics
                                    window.calculateFees = function() {
                                        let totalFee = 0;
                                        
                                        try {
                                            // Total Connected Load calculation
                                            const connectedLoadKva = parseFloat(document.getElementById('connectedLoadKva')?.value) || 0;
                                            const connectedLoadCategory = document.getElementById('connectedLoadCategory')?.value;
                                            
                                            if (connectedLoadKva > 0 && connectedLoadCategory) {
                                                switch(connectedLoadCategory) {
                                                    case 'up_to_5':
                                                        totalFee += 200.00; // Php 200.00 for 5 kVA or less
                                                        break;
                                                    case '5_to_50':
                                                        totalFee += 200.00 + (connectedLoadKva * 20.00); // Php 200.00 + Php 20.00/kVA
                                                        break;
                                                    case '50_to_300':
                                                        totalFee += 1100.00 + (connectedLoadKva * 10.00); // Php 1,100.00 + Php 10.00/kVA
                                                        break;
                                                    case '300_to_1500':
                                                        totalFee += 3600.00 + (connectedLoadKva * 5.00); // Php 3,600.00 + Php 5.00/kVA
                                                        break;
                                                    case '1500_to_6000':
                                                        totalFee += 9600.00 + (connectedLoadKva * 2.50); // Php 9,600.00 + Php 2.50/kVA
                                                        break;
                                                    case 'above_6000':
                                                        totalFee += 20850.00 + (connectedLoadKva * 1.25); // Php 20,850.00 + Php 1.25/kVA
                                                        break;
                                                }
                                            }
                                            
                                            // Transformer/UPS/Generator calculation
                                            const transformerKva = parseFloat(document.getElementById('transformerKva')?.value) || 0;
                                            const transformerCategory = document.getElementById('transformerCategory')?.value;
                                            
                                            if (transformerKva > 0 && transformerCategory) {
                                                switch(transformerCategory) {
                                                    case 'up_to_5':
                                                        totalFee += 40.00; // Php 40.00 for 5 kVA or less
                                                        break;
                                                    case '5_to_50':
                                                        totalFee += 40.00 + (transformerKva * 4.00); // Php 40.00 + Php 4.00/kVA
                                                        break;
                                                    case '50_to_300':
                                                        totalFee += 220.00 + (transformerKva * 2.00); // Php 220.00 + Php 2.00/kVA
                                                        break;
                                                    case '300_to_1500':
                                                        totalFee += 720.00 + (transformerKva * 1.00); // Php 720.00 + Php 1.00/kVA
                                                        break;
                                                    case '1500_to_6000':
                                                        totalFee += 1920.00 + (transformerKva * 0.50); // Php 1,920.00 + Php 0.50/kVA
                                                        break;
                                                    case 'above_6000':
                                                        totalFee += 4170.00 + (transformerKva * 0.25); // Php 4,170.00 + Php 0.25/kVA
                                                        break;
                                                }
                                            }
                                            
                                            // Pole/Attachment Location Plan calculation
                                            const powerSupplyPoles = parseFloat(document.getElementById('powerSupplyPoles')?.value) || 0;
                                            const guyingAttachments = parseFloat(document.getElementById('guyingAttachments')?.value) || 0;
                                            
                                            totalFee += powerSupplyPoles * 30.00; // Php 30.00 per pole
                                            totalFee += guyingAttachments * 30.00; // Php 30.00 per attachment
                                            
                                            // Electric Meter calculation
                                            const meterType = document.getElementById('meterType')?.value;
                                            const meterCount = parseFloat(document.getElementById('meterCount')?.value) || 0;
                                            
                                            if (meterCount > 0 && meterType) {
                                                let meterFee = 0;
                                                let wiringFee = 0;
                                                
                                                switch(meterType) {
                                                    case 'residential':
                                                        meterFee = 15.00;
                                                        wiringFee = 15.00;
                                                        break;
                                                    case 'commercial':
                                                        meterFee = 60.00;
                                                        wiringFee = 36.00;
                                                        break;
                                                    case 'institutional':
                                                        meterFee = 30.00;
                                                        wiringFee = 12.00;
                                                        break;
                                                }
                                                
                                                totalFee += meterCount * (meterFee + wiringFee);
                                            }
                                            
                                            // Electronics Systems calculations
                                            const switchingPorts = parseFloat(document.getElementById('switchingPorts')?.value) || 0;
                                            const broadcastLocations = parseFloat(document.getElementById('broadcastLocations')?.value) || 0;
                                            const vendingMachines = parseFloat(document.getElementById('vendingMachines')?.value) || 0;
                                            const electronicsOutlets = parseFloat(document.getElementById('electronicsOutlets')?.value) || 0;
                                            const securityTerminations = parseFloat(document.getElementById('securityTerminations')?.value) || 0;
                                            const studioLocations = parseFloat(document.getElementById('studioLocations')?.value) || 0;
                                            const antennaStructures = parseFloat(document.getElementById('antennaStructures')?.value) || 0;
                                            const electronicSignages = parseFloat(document.getElementById('electronicSignages')?.value) || 0;
                                            const poleCount = parseFloat(document.getElementById('poleCount')?.value) || 0;
                                            const attachmentCount = parseFloat(document.getElementById('attachmentCount')?.value) || 0;
                                            const otherDevices = parseFloat(document.getElementById('otherDevices')?.value) || 0;
                                            
                                            // Electronics fees
                                            totalFee += switchingPorts * 2.40; // Php 2.40 per port
                                            totalFee += broadcastLocations * 1000.00; // Php 1,000.00 per location
                                            totalFee += vendingMachines * 10.00; // Php 10.00 per unit
                                            totalFee += electronicsOutlets * 2.40; // Php 2.40 per outlet
                                            totalFee += securityTerminations * 2.40; // Php 2.40 per termination
                                            totalFee += studioLocations * 1000.00; // Php 1,000.00 per location
                                            totalFee += antennaStructures * 1000.00; // Php 1,000.00 per structure
                                            totalFee += electronicSignages * 50.00; // Php 50.00 per unit
                                            totalFee += poleCount * 20.00; // Php 20.00 per pole
                                            totalFee += attachmentCount * 20.00; // Php 20.00 per attachment
                                            totalFee += otherDevices * 50.00; // Php 50.00 per unit
                                            
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
                                        'connectedLoadKva', 'connectedLoadCategory',
                                        'transformerKva', 'transformerCategory',
                                        'powerSupplyPoles', 'guyingAttachments',
                                        'meterType', 'meterCount',
                                        'switchingPorts', 'broadcastLocations', 'vendingMachines',
                                        'electronicsOutlets', 'securityTerminations',
                                        'studioLocations', 'antennaStructures', 'electronicSignages',
                                        'poleCount', 'attachmentCount', 'otherDevices'
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