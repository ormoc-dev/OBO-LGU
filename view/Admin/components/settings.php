<?php
// Settings Management Component
?>

<div class="page-header">
    <h2>System Settings</h2>
    <p>Configure system preferences and settings</p>
</div>

<div class="settings-content">
    <div class="settings-tabs">
        <button class="tab-btn active" onclick="showTab('general')">General</button>
        <button class="tab-btn" onclick="showTab('notifications')">Notifications</button>
        <button class="tab-btn" onclick="showTab('security')">Security</button>
        <button class="tab-btn" onclick="showTab('backup')">Backup</button>
    </div>

    <div class="settings-panels">
        <!-- General Settings -->
        <div id="general-tab" class="settings-panel active">
            <div class="settings-section">
                <h3>System Information</h3>
                <div class="settings-form">
                    <div class="form-group">
                        <label for="systemName">System Name</label>
                        <input type="text" id="systemName" value="LGU Annual Inspection System" class="form-input">
                    </div>
                    <div class="form-group">
                        <label for="systemVersion">System Version</label>
                        <input type="text" id="systemVersion" value="v1.0.0" class="form-input" readonly>
                    </div>
                    <div class="form-group">
                        <label for="adminEmail">Admin Email</label>
                        <input type="email" id="adminEmail" value="admin@lgu.gov" class="form-input">
                    </div>
                    <div class="form-group">
                        <label for="timezone">Timezone</label>
                        <select id="timezone" class="form-select">
                            <option value="UTC+8">UTC+8 (Philippines)</option>
                            <option value="UTC+0">UTC+0 (GMT)</option>
                            <option value="UTC-5">UTC-5 (EST)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="settings-section">
                <h3>Inspection Settings</h3>
                <div class="settings-form">
                    <div class="form-group">
                        <label for="inspectionTimeout">Inspection Timeout (hours)</label>
                        <input type="number" id="inspectionTimeout" value="24" class="form-input" min="1" max="168">
                    </div>
                    <div class="form-group">
                        <label for="autoReminder">Auto Reminder (days before due)</label>
                        <input type="number" id="autoReminder" value="3" class="form-input" min="1" max="30">
                    </div>
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="allowReschedule" checked>
                            <span class="checkmark"></span>
                            Allow inspection rescheduling
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="requireApproval" checked>
                            <span class="checkmark"></span>
                            Require approval for completed inspections
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications Settings -->
        <div id="notifications-tab" class="settings-panel">
            <div class="settings-section">
                <h3>Email Notifications</h3>
                <div class="settings-form">
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="emailInspections" checked>
                            <span class="checkmark"></span>
                            New inspection assignments
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="emailCompletions" checked>
                            <span class="checkmark"></span>
                            Inspection completions
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="emailReminders" checked>
                            <span class="checkmark"></span>
                            Due date reminders
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="emailReports">
                            <span class="checkmark"></span>
                            Weekly summary reports
                        </label>
                    </div>
                </div>
            </div>

            <div class="settings-section">
                <h3>System Alerts</h3>
                <div class="settings-form">
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="alertSystemDown" checked>
                            <span class="checkmark"></span>
                            System maintenance alerts
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="alertSecurity" checked>
                            <span class="checkmark"></span>
                            Security alerts
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="alertBackup" checked>
                            <span class="checkmark"></span>
                            Backup status alerts
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Settings -->
        <div id="security-tab" class="settings-panel">
            <div class="settings-section">
                <h3>Password Policy</h3>
                <div class="settings-form">
                    <div class="form-group">
                        <label for="minPasswordLength">Minimum Password Length</label>
                        <input type="number" id="minPasswordLength" value="8" class="form-input" min="6" max="20">
                    </div>
                    <div class="form-group">
                        <label for="passwordExpiry">Password Expiry (days)</label>
                        <input type="number" id="passwordExpiry" value="90" class="form-input" min="30" max="365">
                    </div>
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="requireSpecialChars" checked>
                            <span class="checkmark"></span>
                            Require special characters
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="requireNumbers" checked>
                            <span class="checkmark"></span>
                            Require numbers
                        </label>
                    </div>
                </div>
            </div>

            <div class="settings-section">
                <h3>Session Management</h3>
                <div class="settings-form">
                    <div class="form-group">
                        <label for="sessionTimeout">Session Timeout (minutes)</label>
                        <input type="number" id="sessionTimeout" value="30" class="form-input" min="5" max="480">
                    </div>
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="allowMultipleSessions" checked>
                            <span class="checkmark"></span>
                            Allow multiple concurrent sessions
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="requireReauth" checked>
                            <span class="checkmark"></span>
                            Require re-authentication for sensitive actions
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Backup Settings -->
        <div id="backup-tab" class="settings-panel">
            <div class="settings-section">
                <h3>Backup Configuration</h3>
                <div class="settings-form">
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="autoBackup" checked>
                            <span class="checkmark"></span>
                            Enable automatic backups
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="backupFrequency">Backup Frequency</label>
                        <select id="backupFrequency" class="form-select">
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="backupRetention">Retention Period (days)</label>
                        <input type="number" id="backupRetention" value="30" class="form-input" min="7" max="365">
                    </div>
                    <div class="form-group">
                        <label for="backupLocation">Backup Location</label>
                        <input type="text" id="backupLocation" value="/backups/" class="form-input">
                    </div>
                </div>
            </div>

            <div class="settings-section">
                <h3>Backup Actions</h3>
                <div class="backup-actions">
                    <button class="btn btn-primary" onclick="createBackup()">
                        <i class="fas fa-download"></i> Create Backup Now
                    </button>
                    <button class="btn btn-secondary" onclick="restoreBackup()">
                        <i class="fas fa-upload"></i> Restore from Backup
                    </button>
                </div>
                <div class="backup-status">
                    <h4>Last Backup</h4>
                    <p>Date: 2024-01-15 14:30:00</p>
                    <p>Size: 2.4 GB</p>
                    <p>Status: <span class="status-success">Completed</span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="settings-footer">
        <button class="btn btn-primary" onclick="saveSettings()">
            <i class="fas fa-save"></i> Save Settings
        </button>
        <button class="btn btn-secondary" onclick="resetSettings()">
            <i class="fas fa-undo"></i> Reset to Default
        </button>
    </div>
</div>

<style>
.page-header {
    margin-bottom: 30px;
}

.page-header h2 {
    font-size: 28px;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 8px;
}

.page-header p {
    color: #64748b;
    font-size: 16px;
}

.settings-tabs {
    display: flex;
    border-bottom: 1px solid #e2e8f0;
    margin-bottom: 30px;
}

.tab-btn {
    background: none;
    border: none;
    padding: 12px 24px;
    font-size: 14px;
    font-weight: 500;
    color: #64748b;
    cursor: pointer;
    border-bottom: 2px solid transparent;
    transition: all 0.3s ease;
}

.tab-btn.active {
    color: #667eea;
    border-bottom-color: #667eea;
}

.tab-btn:hover {
    color: #374151;
}

.settings-panels {
    position: relative;
}

.settings-panel {
    display: none;
}

.settings-panel.active {
    display: block;
}

.settings-section {
    background: white;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    border: 1px solid #e2e8f0;
}

.settings-section h3 {
    font-size: 18px;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 20px;
}

.settings-form {
    display: grid;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-weight: 500;
    color: #374151;
    margin-bottom: 8px;
}

.form-input,
.form-select {
    padding: 12px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.form-input:focus,
.form-select:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.checkbox-label {
    display: flex;
    align-items: center;
    cursor: pointer;
    font-weight: 500;
    color: #374151;
}

.checkbox-label input[type="checkbox"] {
    display: none;
}

.checkmark {
    width: 20px;
    height: 20px;
    border: 2px solid #d1d5db;
    border-radius: 4px;
    margin-right: 12px;
    position: relative;
    transition: all 0.3s ease;
}

.checkbox-label input[type="checkbox"]:checked + .checkmark {
    background-color: #667eea;
    border-color: #667eea;
}

.checkbox-label input[type="checkbox"]:checked + .checkmark::after {
    content: '';
    position: absolute;
    left: 6px;
    top: 2px;
    width: 6px;
    height: 10px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

.backup-actions {
    display: flex;
    gap: 12px;
    margin-bottom: 20px;
}

.backup-status {
    background-color: #f8fafc;
    padding: 16px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}

.backup-status h4 {
    font-size: 16px;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 8px;
}

.backup-status p {
    margin: 4px 0;
    color: #64748b;
    font-size: 14px;
}

.status-success {
    color: #059669;
    font-weight: 600;
}

.settings-footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding: 24px 0;
    border-top: 1px solid #e2e8f0;
}

.btn {
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-primary {
    background-color: #667eea;
    color: white;
}

.btn-primary:hover {
    background-color: #5a67d8;
}

.btn-secondary {
    background-color: #f1f5f9;
    color: #374151;
}

.btn-secondary:hover {
    background-color: #e2e8f0;
}

@media (max-width: 768px) {
    .settings-tabs {
        flex-wrap: wrap;
    }
    
    .tab-btn {
        flex: 1;
        min-width: 120px;
    }
    
    .backup-actions {
        flex-direction: column;
    }
    
    .settings-footer {
        flex-direction: column;
    }
}
</style>

<script>
function showTab(tabName) {
    // Hide all panels
    document.querySelectorAll('.settings-panel').forEach(panel => {
        panel.classList.remove('active');
    });
    
    // Remove active class from all tabs
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Show selected panel
    document.getElementById(tabName + '-tab').classList.add('active');
    
    // Add active class to clicked tab
    event.target.classList.add('active');
}

function saveSettings() {
    // Add your save logic here
    alert('Settings saved successfully!');
}

function resetSettings() {
    if (confirm('Are you sure you want to reset all settings to default? This action cannot be undone.')) {
        // Add your reset logic here
        alert('Settings reset to default!');
    }
}

function createBackup() {
    // Add your backup creation logic here
    alert('Backup creation started. You will be notified when complete.');
}

function restoreBackup() {
    // Add your restore logic here
    alert('Please select a backup file to restore from.');
}
</script>
