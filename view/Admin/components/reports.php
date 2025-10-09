<?php
// Reports Management Component
?>

<div class="page-header">
    <h2>Reports & Analytics</h2>
    <p>Generate and view inspection reports and analytics</p>
</div>

<div class="reports-content">
    <div class="reports-actions">
        <button class="btn btn-primary" onclick="generateReport()">
            <i class="fas fa-download"></i> Generate Report
        </button>
        <div class="filter-group">
            <select class="filter-select" id="reportType">
                <option value="summary">Summary Report</option>
                <option value="department">Department Report</option>
                <option value="inspector">Inspector Report</option>
                <option value="monthly">Monthly Report</option>
            </select>
            <input type="date" class="filter-select" id="startDate" placeholder="Start Date">
            <input type="date" class="filter-select" id="endDate" placeholder="End Date">
        </div>
    </div>

    <div class="reports-grid">
        <div class="report-card">
            <div class="report-header">
                <h3>Inspection Summary</h3>
                <span class="report-period">Last 30 days</span>
            </div>
            <div class="report-stats">
                <div class="stat-item">
                    <span class="stat-number">156</span>
                    <span class="stat-label">Total Inspections</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">142</span>
                    <span class="stat-label">Completed</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">14</span>
                    <span class="stat-label">Pending</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">91%</span>
                    <span class="stat-label">Completion Rate</span>
                </div>
            </div>
            <div class="report-actions">
                <button class="btn-action download" title="Download PDF">
                    <i class="fas fa-file-pdf"></i>
                </button>
                <button class="btn-action view" title="View Details">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>

        <div class="report-card">
            <div class="report-header">
                <h3>Department Performance</h3>
                <span class="report-period">This Month</span>
            </div>
            <div class="department-performance">
                <div class="dept-item">
                    <div class="dept-name">Electrical</div>
                    <div class="dept-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 85%"></div>
                        </div>
                        <span class="progress-text">85%</span>
                    </div>
                </div>
                <div class="dept-item">
                    <div class="dept-name">Mechanical</div>
                    <div class="dept-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 72%"></div>
                        </div>
                        <span class="progress-text">72%</span>
                    </div>
                </div>
                <div class="dept-item">
                    <div class="dept-name">Electronics</div>
                    <div class="dept-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 68%"></div>
                        </div>
                        <span class="progress-text">68%</span>
                    </div>
                </div>
            </div>
            <div class="report-actions">
                <button class="btn-action download" title="Download PDF">
                    <i class="fas fa-file-pdf"></i>
                </button>
                <button class="btn-action view" title="View Details">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>

        <div class="report-card">
            <div class="report-header">
                <h3>Inspector Performance</h3>
                <span class="report-period">This Month</span>
            </div>
            <div class="inspector-performance">
                <div class="inspector-item">
                    <div class="inspector-info">
                        <div class="inspector-name">John Smith</div>
                        <div class="inspector-dept">Electrical</div>
                    </div>
                    <div class="inspector-stats">
                        <span class="inspector-count">24</span>
                        <span class="inspector-label">Inspections</span>
                    </div>
                </div>
                <div class="inspector-item">
                    <div class="inspector-info">
                        <div class="inspector-name">Sarah Johnson</div>
                        <div class="inspector-dept">Mechanical</div>
                    </div>
                    <div class="inspector-stats">
                        <span class="inspector-count">18</span>
                        <span class="inspector-label">Inspections</span>
                    </div>
                </div>
                <div class="inspector-item">
                    <div class="inspector-info">
                        <div class="inspector-name">Mike Wilson</div>
                        <div class="inspector-dept">Electronics</div>
                    </div>
                    <div class="inspector-stats">
                        <span class="inspector-count">15</span>
                        <span class="inspector-label">Inspections</span>
                    </div>
                </div>
            </div>
            <div class="report-actions">
                <button class="btn-action download" title="Download PDF">
                    <i class="fas fa-file-pdf"></i>
                </button>
                <button class="btn-action view" title="View Details">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="recent-reports">
        <h3>Recent Reports</h3>
        <div class="reports-table-container">
            <table class="reports-table">
                <thead>
                    <tr>
                        <th>Report Name</th>
                        <th>Type</th>
                        <th>Generated By</th>
                        <th>Date Generated</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Monthly Summary - January 2024</td>
                        <td>Summary Report</td>
                        <td>System Admin</td>
                        <td>2024-01-31</td>
                        <td><span class="status-badge completed">Ready</span></td>
                        <td>
                            <button class="btn-action download" title="Download">
                                <i class="fas fa-download"></i>
                            </button>
                            <button class="btn-action view" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>Department Performance - Q4 2023</td>
                        <td>Department Report</td>
                        <td>System Admin</td>
                        <td>2024-01-15</td>
                        <td><span class="status-badge completed">Ready</span></td>
                        <td>
                            <button class="btn-action download" title="Download">
                                <i class="fas fa-download"></i>
                            </button>
                            <button class="btn-action view" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>Inspector Analysis - December 2023</td>
                        <td>Inspector Report</td>
                        <td>System Admin</td>
                        <td>2024-01-01</td>
                        <td><span class="status-badge processing">Processing</span></td>
                        <td>
                            <button class="btn-action view" title="View Progress">
                                <i class="fas fa-clock"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
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

    .reports-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        gap: 20px;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        gap: 12px;
    }

    .filter-select {
        padding: 12px 16px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        background: white;
        min-width: 150px;
    }

    .filter-select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .reports-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }

    .report-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .report-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .report-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .report-header h3 {
        font-size: 18px;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
    }

    .report-period {
        font-size: 12px;
        color: #9ca3af;
        background-color: #f1f5f9;
        padding: 4px 8px;
        border-radius: 12px;
    }

    .report-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 20px;
    }

    .stat-item {
        text-align: center;
        padding: 16px;
        background-color: #f8fafc;
        border-radius: 8px;
    }

    .stat-number {
        display: block;
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 12px;
        color: #64748b;
        text-transform: uppercase;
        font-weight: 500;
    }

    .department-performance,
    .inspector-performance {
        margin-bottom: 20px;
    }

    .dept-item,
    .inspector-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .dept-item:last-child,
    .inspector-item:last-child {
        border-bottom: none;
    }

    .dept-name,
    .inspector-name {
        font-weight: 500;
        color: #374151;
    }

    .inspector-dept {
        font-size: 12px;
        color: #9ca3af;
    }

    .dept-progress {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 120px;
    }

    .progress-bar {
        flex: 1;
        height: 8px;
        background-color: #e2e8f0;
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 4px;
        transition: width 0.3s ease;
    }

    .progress-text {
        font-size: 12px;
        font-weight: 600;
        color: #374151;
        min-width: 30px;
    }

    .inspector-stats {
        text-align: right;
    }

    .inspector-count {
        display: block;
        font-size: 18px;
        font-weight: 600;
        color: #1e293b;
    }

    .inspector-label {
        font-size: 11px;
        color: #9ca3af;
        text-transform: uppercase;
    }

    .report-actions {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
    }

    .recent-reports h3 {
        font-size: 20px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 20px;
    }

    .reports-table-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .reports-table {
        width: 100%;
        border-collapse: collapse;
    }

    .reports-table th {
        background-color: #f8fafc;
        padding: 16px;
        text-align: left;
        font-weight: 600;
        color: #374151;
        border-bottom: 1px solid #e2e8f0;
    }

    .reports-table td {
        padding: 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #4b5563;
    }

    .reports-table tr:hover {
        background-color: #f8fafc;
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-badge.completed {
        background-color: #d1fae5;
        color: #059669;
    }

    .status-badge.processing {
        background-color: #fef3c7;
        color: #d97706;
    }

    .btn-action {
        background: none;
        border: none;
        padding: 8px;
        margin: 0 2px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #6b7280;
    }

    .btn-action:hover {
        background-color: #f3f4f6;
    }

    .btn-action.download:hover {
        color: #3b82f6;
    }

    .btn-action.view:hover {
        color: #10b981;
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

    @media (max-width: 768px) {
        .reports-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-group {
            flex-direction: column;
        }

        .reports-grid {
            grid-template-columns: 1fr;
        }

        .report-stats {
            grid-template-columns: 1fr;
        }

        .reports-table-container {
            overflow-x: auto;
        }

        .reports-table {
            min-width: 600px;
        }
    }
</style>

<script>
    function generateReport() {
        const reportType = document.getElementById('reportType').value;
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;

        // Add your report generation logic here
        alert(`Generating ${reportType} report from ${startDate} to ${endDate}`);
    }
</script>