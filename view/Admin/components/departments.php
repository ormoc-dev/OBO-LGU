<?php
// Departments Management Component
?>

<div class="page-header">
    <h2>Departments Management</h2>
    <p>Manage system departments and their configurations</p>
</div>

<div class="departments-content">
    <div class="departments-actions">
        <button class="btn btn-primary" onclick="openAddDepartmentModal()">
            <i class="fas fa-plus"></i> Add New Department
        </button>
        <div class="search-box">
            <input type="text" id="departmentSearch" placeholder="Search departments..." class="search-input">
            <i class="fas fa-search search-icon"></i>
        </div>
    </div>

    <div class="departments-grid">
        <div class="department-card">
            <div class="department-header">
                <div class="department-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <div class="department-info">
                    <h3>Electrical Department</h3>
                    <p>Handles electrical inspections and maintenance</p>
                </div>
            </div>
            <div class="department-stats">
                <div class="stat">
                    <span class="stat-number">15</span>
                    <span class="stat-label">Inspectors</span>
                </div>
                <div class="stat">
                    <span class="stat-number">45</span>
                    <span class="stat-label">Active Inspections</span>
                </div>
            </div>
            <div class="department-actions">
                <button class="btn-action edit" title="Edit Department">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn-action delete" title="Delete Department">
                    <i class="fas fa-trash"></i>
                </button>
                <button class="btn-action view" title="View Details">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>

        <div class="department-card">
            <div class="department-header">
                <div class="department-icon">
                    <i class="fas fa-cogs"></i>
                </div>
                <div class="department-info">
                    <h3>Mechanical Department</h3>
                    <p>Handles mechanical inspections and repairs</p>
                </div>
            </div>
            <div class="department-stats">
                <div class="stat">
                    <span class="stat-number">12</span>
                    <span class="stat-label">Inspectors</span>
                </div>
                <div class="stat">
                    <span class="stat-number">32</span>
                    <span class="stat-label">Active Inspections</span>
                </div>
            </div>
            <div class="department-actions">
                <button class="btn-action edit" title="Edit Department">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn-action delete" title="Delete Department">
                    <i class="fas fa-trash"></i>
                </button>
                <button class="btn-action view" title="View Details">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>

        <div class="department-card">
            <div class="department-header">
                <div class="department-icon">
                    <i class="fas fa-microchip"></i>
                </div>
                <div class="department-info">
                    <h3>Electronics Department</h3>
                    <p>Handles electronics and IT equipment inspections</p>
                </div>
            </div>
            <div class="department-stats">
                <div class="stat">
                    <span class="stat-number">8</span>
                    <span class="stat-label">Inspectors</span>
                </div>
                <div class="stat">
                    <span class="stat-number">18</span>
                    <span class="stat-label">Active Inspections</span>
                </div>
            </div>
            <div class="department-actions">
                <button class="btn-action edit" title="Edit Department">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn-action delete" title="Delete Department">
                    <i class="fas fa-trash"></i>
                </button>
                <button class="btn-action view" title="View Details">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add Department Modal -->
<div id="addDepartmentModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Add New Department</h3>
            <span class="close" onclick="closeAddDepartmentModal()">&times;</span>
        </div>
        <div class="modal-body">
            <form id="addDepartmentForm">
                <div class="form-group">
                    <label for="departmentName">Department Name</label>
                    <input type="text" id="departmentName" name="name" required>
                </div>
                <div class="form-group">
                    <label for="departmentDescription">Description</label>
                    <textarea id="departmentDescription" name="description" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="departmentHead">Department Head</label>
                    <input type="text" id="departmentHead" name="head" required>
                </div>
                <div class="form-group">
                    <label for="departmentEmail">Contact Email</label>
                    <input type="email" id="departmentEmail" name="email" required>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeAddDepartmentModal()">Cancel</button>
            <button type="button" class="btn btn-primary" onclick="saveDepartment()">Save Department</button>
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

    .departments-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        gap: 20px;
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

    .departments-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 24px;
    }

    .department-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .department-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .department-header {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 20px;
    }

    .department-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
    }

    .department-info h3 {
        font-size: 18px;
        font-weight: 600;
        color: #1e293b;
        margin: 0 0 8px 0;
    }

    .department-info p {
        color: #64748b;
        font-size: 14px;
        margin: 0;
        line-height: 1.5;
    }

    .department-stats {
        display: flex;
        gap: 24px;
        margin-bottom: 20px;
        padding: 16px;
        background-color: #f8fafc;
        border-radius: 8px;
    }

    .stat {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .stat-number {
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
    }

    .stat-label {
        font-size: 12px;
        color: #64748b;
        text-transform: uppercase;
        font-weight: 500;
    }

    .department-actions {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
    }

    .btn-action {
        background: none;
        border: none;
        padding: 8px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #6b7280;
    }

    .btn-action:hover {
        background-color: #f3f4f6;
    }

    .btn-action.edit:hover {
        color: #3b82f6;
    }

    .btn-action.delete:hover {
        color: #ef4444;
    }

    .btn-action.view:hover {
        color: #10b981;
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
        max-width: 500px;
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
    .form-group textarea:focus {
        outline: none;
        border-color: #667eea;
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
        .departments-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .search-box {
            max-width: none;
        }

        .departments-grid {
            grid-template-columns: 1fr;
        }

        .department-stats {
            justify-content: space-around;
        }
    }
</style>

<script>
    function openAddDepartmentModal() {
        document.getElementById('addDepartmentModal').style.display = 'block';
    }

    function closeAddDepartmentModal() {
        document.getElementById('addDepartmentModal').style.display = 'none';
        document.getElementById('addDepartmentForm').reset();
    }

    function saveDepartment() {
        // Add your save logic here
        alert('Department saved successfully!');
        closeAddDepartmentModal();
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('addDepartmentModal');
        if (event.target == modal) {
            closeAddDepartmentModal();
        }
    }
</script>