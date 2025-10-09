<?php
// Inspections Management Component
?>

<div class="page-header">
    <h2>Inspections Management</h2>
    <p>Manage and monitor all inspection activities</p>
</div>

<div class="inspections-content">
    <div class="inspections-actions">
        <button class="btn btn-primary" onclick="openAddInspectionModal()">
            <i class="fas fa-plus"></i> Schedule New Inspection
        </button>
        <div class="filter-group">
            <select class="filter-select" id="statusFilter">
                <option value="">All Status</option>
                <option value="scheduled">Scheduled</option>
                <option value="in-progress">In Progress</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
            <select class="filter-select" id="departmentFilter">
                <option value="">All Departments</option>
                <option value="electrical">Electrical</option>
                <option value="mechanical">Mechanical</option>
                <option value="electronics">Electronics</option>
            </select>
        </div>
        <div class="search-box">
            <input type="text" id="inspectionSearch" placeholder="Search inspections..." class="search-input">
            <i class="fas fa-search search-icon"></i>
        </div>
    </div>

    <div class="inspections-table-container">
        <table class="inspections-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Location</th>
                    <th>Department</th>
                    <th>Inspector</th>
                    <th>Status</th>
                    <th>Scheduled Date</th>
                    <th>Priority</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#INS-001</td>
                    <td>Building A - Floor 2</td>
                    <td>Electrical</td>
                    <td>John Smith</td>
                    <td><span class="status-badge in-progress">In Progress</span></td>
                    <td>2024-01-15</td>
                    <td><span class="priority-badge high">High</span></td>
                    <td>
                        <button class="btn-action view" title="View Details">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn-action edit" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-action complete" title="Mark Complete">
                            <i class="fas fa-check"></i>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>#INS-002</td>
                    <td>Building B - Floor 1</td>
                    <td>Mechanical</td>
                    <td>Sarah Johnson</td>
                    <td><span class="status-badge completed">Completed</span></td>
                    <td>2024-01-14</td>
                    <td><span class="priority-badge medium">Medium</span></td>
                    <td>
                        <button class="btn-action view" title="View Details">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn-action report" title="View Report">
                            <i class="fas fa-file-alt"></i>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>#INS-003</td>
                    <td>Building C - Floor 3</td>
                    <td>Electronics</td>
                    <td>Mike Wilson</td>
                    <td><span class="status-badge scheduled">Scheduled</span></td>
                    <td>2024-01-16</td>
                    <td><span class="priority-badge low">Low</span></td>
                    <td>
                        <button class="btn-action view" title="View Details">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn-action edit" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-action cancel" title="Cancel">
                            <i class="fas fa-times"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Inspection Modal -->
<div id="addInspectionModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Schedule New Inspection</h3>
            <span class="close" onclick="closeAddInspectionModal()">&times;</span>
        </div>
        <div class="modal-body">
            <form id="addInspectionForm">
                <div class="form-row">
                    <div class="form-group">
                        <label for="inspectionLocation">Location</label>
                        <input type="text" id="inspectionLocation" name="location" required>
                    </div>
                    <div class="form-group">
                        <label for="inspectionDepartment">Department</label>
                        <select id="inspectionDepartment" name="department" required>
                            <option value="">Select Department</option>
                            <option value="electrical">Electrical</option>
                            <option value="mechanical">Mechanical</option>
                            <option value="electronics">Electronics</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="inspectionInspector">Inspector</label>
                        <select id="inspectionInspector" name="inspector" required>
                            <option value="">Select Inspector</option>
                            <option value="john-smith">John Smith</option>
                            <option value="sarah-johnson">Sarah Johnson</option>
                            <option value="mike-wilson">Mike Wilson</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inspectionPriority">Priority</label>
                        <select id="inspectionPriority" name="priority" required>
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inspectionDate">Scheduled Date</label>
                    <input type="datetime-local" id="inspectionDate" name="date" required>
                </div>
                <div class="form-group">
                    <label for="inspectionNotes">Notes</label>
                    <textarea id="inspectionNotes" name="notes" rows="3"></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeAddInspectionModal()">Cancel</button>
            <button type="button" class="btn btn-primary" onclick="saveInspection()">Schedule Inspection</button>
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

    .inspections-actions {
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

    .search-box {
        position: relative;
        max-width: 300px;
        flex: 1;
    }

    .search-input {
        width: 100%;
        padding: 12px 16px 12px 40px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.3s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
    }

    .inspections-table-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .inspections-table {
        width: 100%;
        border-collapse: collapse;
    }

    .inspections-table th {
        background-color: #f8fafc;
        padding: 16px;
        text-align: left;
        font-weight: 600;
        color: #374151;
        border-bottom: 1px solid #e2e8f0;
    }

    .inspections-table td {
        padding: 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #4b5563;
    }

    .inspections-table tr:hover {
        background-color: #f8fafc;
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-badge.scheduled {
        background-color: #dbeafe;
        color: #1d4ed8;
    }

    .status-badge.in-progress {
        background-color: #fef3c7;
        color: #d97706;
    }

    .status-badge.completed {
        background-color: #d1fae5;
        color: #059669;
    }

    .status-badge.cancelled {
        background-color: #fee2e2;
        color: #dc2626;
    }

    .priority-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .priority-badge.low {
        background-color: #f3f4f6;
        color: #6b7280;
    }

    .priority-badge.medium {
        background-color: #fef3c7;
        color: #d97706;
    }

    .priority-badge.high {
        background-color: #fee2e2;
        color: #dc2626;
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

    .btn-action.view:hover {
        color: #3b82f6;
    }

    .btn-action.edit:hover {
        color: #f59e0b;
    }

    .btn-action.complete:hover {
        color: #10b981;
    }

    .btn-action.cancel:hover {
        color: #ef4444;
    }

    .btn-action.report:hover {
        color: #8b5cf6;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 2000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: white;
        margin: 5% auto;
        padding: 0;
        border-radius: 12px;
        width: 90%;
        max-width: 600px;
        box-shadow: 0 20px 25px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        padding: 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
        color: #1e293b;
    }

    .close {
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
        color: #9ca3af;
        transition: color 0.3s ease;
    }

    .close:hover {
        color: #374151;
    }

    .modal-body {
        padding: 24px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #374151;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.3s ease;
        font-family: inherit;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #0870de;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .modal-footer {
        padding: 24px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
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
        background-color: #0870de;
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
        .inspections-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-group {
            flex-direction: column;
        }

        .search-box {
            max-width: none;
        }

        .inspections-table-container {
            overflow-x: auto;
        }

        .inspections-table {
            min-width: 800px;
        }

        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Modal and filter functionality is handled by the main Home.php file -->