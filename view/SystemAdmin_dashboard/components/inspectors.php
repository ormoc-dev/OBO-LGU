<?php
// Inspectors Management Component
?>

<div class="page-header">
    <h2>Inspectors Management</h2>
    <p>Manage system inspectors and their permissions</p>
</div>

<div class="inspectors-content">
    <div class="inspectors-actions">
        <button class="btn btn-primary" onclick="openAddInspectorModal()">
            <i class="fas fa-plus"></i> Add New Inspector
        </button>
        <div class="search-box">
            <input type="text" id="inspectorSearch" placeholder="Search inspectors..." class="search-input">
            <i class="fas fa-search search-icon"></i>
        </div>
    </div>

    <div class="inspectors-table-container">
        <div id="inspectorsLoading" class="loading-state">
            <i class="fas fa-spinner fa-spin"></i>
            <span>Loading inspectors...</span>
        </div>
        <table class="inspectors-table" id="inspectorsTable" style="display: none;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th>Last Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="inspectorsTableBody">
                <!-- Data will be loaded here -->
            </tbody>
        </table>
        <div id="noInspectors" class="empty-state" style="display: none;">
            <i class="fas fa-users"></i>
            <h3>No Inspectors Found</h3>
            <p>There are no inspectors in the system yet.</p>

        </div>
    </div>
</div>

<!-- Add Inspector Modal -->
<div id="addInspectorModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Add New Inspector</h3>
            <span class="close" onclick="closeAddInspectorModal()">&times;</span>
        </div>
        <div class="modal-body">
            <form id="addInspectorForm">
                <input type="hidden" id="inspectorId" name="id" value="">
                <div class="form-group">
                    <label for="inspectorName">Full Name</label>
                    <input type="text" id="inspectorName" name="name" required>
                </div>
                <div class="form-group">
                    <label for="inspectorDepartment">Department</label>
                    <select id="inspectorDepartment" name="department" required>
                        <option value="">Select Department</option>
                        <option value="electrical">Electrical</option>
                        <option value="mechanical">Mechanical</option>
                        <option value="electronics">Electronics</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="inspectorPassword">Password</label>
                    <input type="password" id="inspectorPassword" name="password" required minlength="6">
                    <small class="form-help">Password must be at least 6 characters long</small>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeAddInspectorModal()">Cancel</button>
            <button type="button" class="btn btn-primary" onclick="saveInspector()">Save Inspector</button>
        </div>
    </div>
</div>