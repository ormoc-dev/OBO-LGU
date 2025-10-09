<?php
// Dashboard Component
?>

<div class="page-header">
    <h2>Dashboard Overview</h2>
    <p>Welcome to the System Admin Dashboard</p>
</div>

<div class="dashboard-grid">
    <div class="dashboard-card">
        <div class="card-header">
            <h3>Total Inspectors</h3>
            <i class="fas fa-users"></i>
        </div>
        <div class="card-content">
            <span class="card-number" id="metricTotalUsers">0</span>
            <span class="card-change positive">+12%</span>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-header">
            <h3>Active Inspections</h3>
            <i class="fas fa-clipboard-check"></i>
        </div>
        <div class="card-content">
            <span class="card-number" id="metricActiveInspections">0</span>
            <span class="card-change positive">+5%</span>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-header">
            <h3>Completed Reports</h3>
            <i class="fas fa-file-alt"></i>
        </div>
        <div class="card-content">
            <span class="card-number" id="metricCompletedReports">0</span>
            <span class="card-change positive">+8%</span>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-header">
            <h3>Pending Approvals</h3>
            <i class="fas fa-clock"></i>
        </div>
        <div class="card-content">
            <span class="card-number" id="metricPendingApprovals">0</span>
            <span class="card-change negative">-2%</span>
        </div>
    </div>
</div>

<div class="recent-activities">
    <div class="activity-card">
        <h3>Recent Activities</h3>
        <div class="activity-list">
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="activity-content">
                    <p>New inspector John Smith added</p>
                    <span class="activity-time">2 hours ago</span>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-file-check"></i>
                </div>
                <div class="activity-content">
                    <p>Inspection report #1234 completed</p>
                    <span class="activity-time">4 hours ago</span>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-bell"></i>
                </div>
                <div class="activity-content">
                    <p>System maintenance scheduled</p>
                    <span class="activity-time">1 day ago</span>
                </div>
            </div>
        </div>
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

    .recent-activities {
        margin-top: 30px;
    }

    .activity-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
    }

    .activity-card h3 {
        font-size: 20px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 20px;
    }

    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .activity-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 12px;
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }

    .activity-item:hover {
        background-color: #f8fafc;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        background-color:#0870de;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 16px;
    }

    .activity-content p {
        margin: 0;
        font-weight: 500;
        color: #374151;
    }

    .activity-time {
        font-size: 12px;
        color: #9ca3af;
    }
</style>