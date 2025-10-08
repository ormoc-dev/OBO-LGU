// Inspectors Management JavaScript
// This file contains all inspector-related functionality

// Inspector component initialization
function initializeInspectorsComponent() {
    // Load inspectors data
    loadInspectors();

    // Modal functionality
    const modal = document.getElementById('addInspectorModal');
    if (modal) {
        document.addEventListener('click', function(event) {
            if (event.target == modal) {
                closeAddInspectorModal();
            }
        });
    }

    // Search functionality
    const searchInput = document.getElementById('inspectorSearch');
    if (searchInput) {
        searchInput.addEventListener('input', filterInspectors);
    }
}

// Load inspectors from database
function loadInspectors() {
    fetch('../../api/inspectors/get_inspectors.php')
        .then(response => response.json())
        .then(data => {
            const loadingEl = document.getElementById('inspectorsLoading');
            const tableEl = document.getElementById('inspectorsTable');
            const tableBodyEl = document.getElementById('inspectorsTableBody');
            const emptyEl = document.getElementById('noInspectors');

            if (loadingEl) loadingEl.style.display = 'none';

            if (data.success && data.data.length > 0) {
                tableEl.style.display = 'table';
                emptyEl.style.display = 'none';

                tableBodyEl.innerHTML = data.data.map(inspector => `
                    <tr>
                        <td>${inspector.display_id || String(inspector.id).padStart(3,'0')}</td>
                        <td>${inspector.name}</td>
                        <td>${inspector.department}</td>
                        <td><span class="status-badge ${inspector.status}">${inspector.status}</span></td>
                        <td>${inspector.last_active}</td>
                        <td>
                            <button class="btn-action edit" title="Edit" onclick="handleInspectorAction('edit', ${inspector.id})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-action delete" title="Delete" onclick="handleInspectorAction('delete', ${inspector.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button class="btn-action view" title="View Details" onclick="handleInspectorAction('view', ${inspector.id})">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                `).join('');
            } else {
                tableEl.style.display = 'none';
                emptyEl.style.display = 'flex';
            }
        })
        .catch(error => {
            console.error('Error loading inspectors:', error);
            const loadingEl = document.getElementById('inspectorsLoading');
            if (loadingEl) {
                loadingEl.innerHTML = '<i class="fas fa-exclamation-triangle"></i><span>Error loading inspectors</span>';
            }
        });
}

// Filter inspectors
function filterInspectors() {
    const searchInput = document.getElementById('inspectorSearch');
    if (!searchInput) return;

    const searchValue = searchInput.value.toLowerCase();
    const tableRows = document.querySelectorAll('#inspectorsTableBody tr');

    tableRows.forEach(row => {
        const name = row.cells[1].textContent.toLowerCase();
        const department = row.cells[2].textContent.toLowerCase();

        if (name.includes(searchValue) || department.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Modal functions
function openAddInspectorModal() {
    const modal = document.getElementById('addInspectorModal');
    if (modal) {
        // Reset to Add mode
        const form = document.getElementById('addInspectorForm');
        if (form) {
            const idInput = document.getElementById('inspectorId');
            if (idInput) idInput.value = '';
        }
        const headerEl = modal.querySelector('.modal-header h3');
        if (headerEl) headerEl.textContent = 'Add New Inspector';
        const saveBtn = modal.querySelector('.btn-primary');
        if (saveBtn) saveBtn.textContent = 'Save Inspector';
        modal.style.display = 'block';
    }
}

function closeAddInspectorModal() {
    const modal = document.getElementById('addInspectorModal');
    if (modal) {
        modal.style.display = 'none';
        const form = document.getElementById('addInspectorForm');
        if (form) {
            form.reset();
        }
    }
}

// Save inspector function
function saveInspector() {
    const form = document.getElementById('addInspectorForm');
    if (!form) {
        console.error('Form not found!');
        return;
    }

    const formData = new FormData(form);
    const id = formData.get('id');
    const data = {
        name: formData.get('name'),
        department: formData.get('department'),
        password: formData.get('password')
    };

    // Debug: Check if form fields exist
    console.log('Form elements:');
    console.log('Name input:', document.getElementById('inspectorName'));
    console.log('Department select:', document.getElementById('inspectorDepartment'));
    console.log('Password input:', document.getElementById('inspectorPassword'));
    console.log('Form data entries:');
    for (let [key, value] of formData.entries()) {
        console.log(key, value);
    }

    // Validate form
    if (!data.name || !data.department || (!id && !data.password)) {
        showNotification('Please fill in all required fields', 'error');
        return;
    }

    if (data.password && data.password.length > 0 && data.password.length < 6) {
        showNotification('Password must be at least 6 characters long', 'error');
        return;
    }

    // Show loading state
    const saveBtn = document.querySelector('#addInspectorModal .btn-primary');
    const originalText = saveBtn.innerHTML;
    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
    saveBtn.disabled = true;

    // Debug: Log the data being sent
    console.log('Sending data:', data);

    // Decide endpoint (add vs update)
    const isUpdate = id && String(id).trim() !== '';
    const endpoint = isUpdate ? '../../api/inspectors/update_inspector.php' : '../../api/inspectors/add_inspector.php';
    const payload = isUpdate ? { id: Number(id), name: data.name, department: data.department, password: data.password || '' } : data;

    // Send request
    fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(payload)
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(result => {
            console.log('Response data:', result);
            if (result.success) {
                showNotification(isUpdate ? 'Inspector updated successfully!' : 'Inspector added successfully!', 'success');
                closeAddInspectorModal();
                loadInspectors(); // Reload the table
            } else {
                showNotification('Error: ' + result.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred while saving the inspector', 'error');
        })
        .finally(() => {
            // Reset button state
            saveBtn.innerHTML = originalText;
            saveBtn.disabled = false;
        });
}

// Unified inspector action handler
function handleInspectorAction(actionType, inspectorId) {
    switch (actionType) {
        case 'edit': {
            // Fetch inspector details then open modal prefilled
            fetch(`../../api/inspectors/get_inspector.php?id=${encodeURIComponent(inspectorId)}`)
                .then(r => r.json())
                .then(res => {
                    if (!res.success) throw new Error(res.message || 'Failed to load inspector');
                    const { id, name, department } = res.data;
                    const modal = document.getElementById('addInspectorModal');
                    const form = document.getElementById('addInspectorForm');
                    if (!modal || !form) return;
                    const idInput = document.getElementById('inspectorId');
                    const nameInput = document.getElementById('inspectorName');
                    const deptSelect = document.getElementById('inspectorDepartment');
                    const passInput = document.getElementById('inspectorPassword');
                    if (idInput) idInput.value = id;
                    if (nameInput) nameInput.value = name;
                    if (deptSelect) deptSelect.value = String(department).toLowerCase();
                    if (passInput) passInput.value = '';
                    const headerEl = modal.querySelector('.modal-header h3');
                    if (headerEl) headerEl.textContent = 'Edit Inspector';
                    const saveBtn = modal.querySelector('.btn-primary');
                    if (saveBtn) saveBtn.textContent = 'Update Inspector';
                    modal.style.display = 'block';
                })
                .catch(err => {
                    console.error(err);
                    showNotification('Failed to load inspector details', 'error');
                });
            break;
        }
        case 'delete': {
            if (!confirm('Are you sure you want to delete this inspector?')) return;
            fetch('../../api/inspectors/delete_inspector.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: Number(inspectorId) })
            })
                .then(r => r.json())
                .then(res => {
                    if (!res.success) throw new Error(res.message || 'Delete failed');
                    showNotification('Inspector deleted successfully!', 'success');
                    loadInspectors();
                })
                .catch(err => {
                    console.error(err);
                    showNotification('Failed to delete inspector', 'error');
                });
            break;
        }
        case 'view': {
            fetch(`../../api/inspectors/get_inspector.php?id=${encodeURIComponent(inspectorId)}`)
                .then(r => r.json())
                .then(res => {
                    if (!res.success) throw new Error(res.message || 'Failed to load inspector');
                    const { id, name, department, status } = res.data;
                    showNotification(`ID: ${String(id).padStart(3,'0')} • ${name} • ${department} • ${status}`, 'info');
                })
                .catch(err => {
                    console.error(err);
                    showNotification('Failed to load inspector details', 'error');
                });
            break;
        }
        default:
            console.warn('Unknown inspector action:', actionType, inspectorId);
            showNotification('Unknown action', 'warning');
    }
}

// Backward-compatible wrappers
function editInspector(id) {
    handleInspectorAction('edit', id);
}

function deleteInspector(id) {
    handleInspectorAction('delete', id);
}

function viewInspector(id) {
    handleInspectorAction('view', id);
}

// Make functions globally available
window.initializeInspectorsComponent = initializeInspectorsComponent;
window.loadInspectors = loadInspectors;
window.filterInspectors = filterInspectors;
window.openAddInspectorModal = openAddInspectorModal;
window.closeAddInspectorModal = closeAddInspectorModal;
window.saveInspector = saveInspector;
window.handleInspectorAction = handleInspectorAction;
window.editInspector = editInspector;
window.deleteInspector = deleteInspector;
window.viewInspector = viewInspector;
