<?php
// Business Records Component
?>

<div class="business-records-container">
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-content">
            <h2 class="page-title">
                <i class="fas fa-building"></i>
                Business Records
            </h2>
            <p class="page-subtitle">Manage and track business inspection records</p>
        </div>
        <div class="header-actions">
            <button class="btn btn-secondary" onclick="openImportModal()">
                <i class="fas fa-upload"></i>
                Import Excel
            </button>
            <button class="btn btn-primary" onclick="openAddBusinessModal()">
                <i class="fas fa-plus"></i>
                Add Business
            </button>
        </div>
    </div>


    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number" id="totalBusinesses">0</h3>
                <p class="stat-label">Total Businesses</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number" id="activeBusinesses">0</h3>
                <p class="stat-label">Active</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number" id="pendingBusinesses">0</h3>
                <p class="stat-label">Pending</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number" id="expiredBusinesses">0</h3>
                <p class="stat-label">Expired</p>
            </div>
        </div>
    </div>




    <!-- Business Records Table -->
    <div class="table-container">
        <div class="table-header">
            <h3>Business Records</h3>
            <div class="table-actions">
            <div class="search-input" style="border: none !important;">
                    <i class="fas fa-search"></i>
                    <input type="text" id="businessSearch" placeholder="Search by Business ID, Name, Address, City, or any data..." autocomplete="off" oninput="filterBusinesses();">
                    <button type="button" class="search-clear" id="searchClear" onclick="clearSearch()" style="display: none;">
                        <i class="fas fa-times"></i>
                    </button>
                    <div id="searchSuggestions" class="search-suggestions" style="display: none;"></div>
                </div>
                <button class="btn btn-secondary" onclick="exportBusinesses()">
                    <i class="fas fa-download"></i>
                    Export
                </button>
                <button class="btn btn-secondary" onclick="refreshBusinesses()">
                    <i class="fas fa-sync"></i>
                    Refresh
                </button>
                
            </div>
        </div>

        <div class="table-wrapper">
            <table class="business-table" id="businessTable">
                <thead>
                    <tr>
                        <!-- Headers will be dynamically generated from Excel data -->
                    </tr>
                </thead>
                <tbody>
                    <!-- Business records will be loaded here -->
                    <tr class="loading-row">
                        <td colspan="6">
                            <div class="loading-spinner">
                                <i class="fas fa-spinner fa-spin"></i>
                                Loading business records...
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination Container -->
        <div class="pagination-container" id="paginationContainer" style="display: none;">
            <div class="pagination-info">
                <span id="paginationInfo">Showing 0 to 0 of 0 entries</span>
            </div>
            <div class="pagination-controls">
                <button class="pagination-btn" id="firstPage" onclick="goToPage(1)">
                    <i class="fas fa-angle-double-left"></i>
                </button>
                <button class="pagination-btn" id="prevPage" onclick="goToPage(currentPage - 1)">
                    <i class="fas fa-angle-left"></i>
                </button>
                <div id="pageNumbers"></div>
                <button class="pagination-btn" id="nextPage" onclick="goToPage(currentPage + 1)">
                    <i class="fas fa-angle-right"></i>
                </button>
                <button class="pagination-btn" id="lastPage" onclick="goToPage(totalPages)">
                    <i class="fas fa-angle-double-right"></i>
                </button>
            </div>
            <div class="page-size-selector" style="display: none;">
                <label for="pageSize">Show:</label>
                <select id="pageSize" onchange="changePageSize()">
                    <option value="10">10</option>
                    <option value="25" selected>25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span>entries</span>
            </div>
        </div>
    </div>

</div>


<!-- Excel Import Modal -->
<div id="importModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Import Excel File</h3>
            <button class="modal-close" onclick="closeImportModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div id="importStep1" class="import-step">
                <div class="upload-area" id="uploadArea">
                    <div class="upload-content">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <h4>Drop your Excel file here</h4>
                        <p>or click to browse</p>
                        <input type="file" id="excelFileInput" accept=".xls,.xlsx,.csv" style="display: none;">
                        <button class="btn btn-primary" onclick="document.getElementById('excelFileInput').click(); return false;">
                            Choose File
                        </button>
                    </div>
                </div>
                <div class="file-info" id="fileInfo" style="display: none;">
                    <div class="file-details">
                        <i class="fas fa-file-excel"></i>
                        <div class="file-text">
                            <span class="file-name" id="fileName"></span>
                            <span class="file-size" id="fileSize"></span>
                        </div>
                        <button class="btn btn-danger btn-sm" onclick="removeFile()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div id="importStep2" class="import-step" style="display: none;">
                <div class="import-progress">
                    <div class="progress-bar">
                        <div class="progress-fill" id="progressFill"></div>
                    </div>
                    <div class="progress-text" id="progressText">Processing...</div>
                </div>
            </div>

            <div id="importStep3" class="import-step" style="display: none;">
                <div class="import-success">
                    <i class="fas fa-check-circle"></i>
                    <h4>Import Completed Successfully!</h4>
                    <div class="import-summary" id="importSummary"></div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeImportModal()">Cancel</button>
            <button type="button" class="btn btn-primary" id="importBtn" onclick="startImport()" style="display: none;">
                <i class="fas fa-upload"></i>
                Import File
            </button>
        </div>
    </div>
</div>

<!-- Dynamic Data Modal -->
<div id="dynamicDataModal" class="modal">
    <div class="modal-content large-modal">
        <div class="modal-header">
            <h3 id="dynamicModalTitle">Imported Data</h3>
            <button class="modal-close" onclick="closeDynamicDataModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="data-controls">
                <div class="search-controls">
                    <input type="text" id="dataSearch" placeholder="Search data..." class="search-input">
                    <button class="btn btn-secondary" onclick="refreshData()">
                        <i class="fas fa-sync"></i>
                        Refresh
                    </button>
                </div>
                <div class="pagination-controls">
                    <button class="btn btn-sm" id="prevPage" onclick="changePage(-1)">Previous</button>
                    <span id="pageInfo">Page 1 of 1</span>
                    <button class="btn btn-sm" id="nextPage" onclick="changePage(1)">Next</button>
                </div>
            </div>
            <div class="dynamic-table-container">
                <table class="dynamic-table" id="dynamicTable">
                    <thead id="dynamicTableHead"></thead>
                    <tbody id="dynamicTableBody"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Business Modal -->
<div id="addBusinessModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Add New Business</h3>
            <button class="modal-close" onclick="closeAddBusinessModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="addBusinessForm">
                <div class="form-row">
                    <div class="form-group">
                        <label for="lastName">Last Name *</label>
                        <input type="text" id="lastName" name="lastName" required>
                    </div>
                    <div class="form-group">
                        <label for="firstMiddleName">First/Middle Name *</label>
                        <input type="text" id="firstMiddleName" name="firstMiddleName" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="businessName">Business Name *</label>
                    <input type="text" id="businessName" name="businessName" required>
                </div>
                <div class="form-group">
                    <label for="address">Address *</label>
                    <textarea id="address" name="address" rows="3" required placeholder="Enter complete address including building number, street, barangay, city, etc."></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeAddBusinessModal()">Cancel</button>
            <button type="button" class="btn btn-primary" onclick="saveBusiness()">Save Business</button>
        </div>
    </div>
</div>


<script>
    // Business Records JavaScript
    let currentImportId = null;
    let currentPage = 1;
    let totalPages = 1;
    let pageSize = 25;
    let totalRecords = 0;
    let allData = []; // Store all data for client-side pagination
    let searchTimeout = null; // For debouncing search
    let suggestionsTimeout = null; // For debouncing suggestions
    let searchSuggestions = []; // Store search suggestions
    let selectedSuggestionIndex = -1; // Track selected suggestion
    
    // Virtual scrolling variables
    let visibleRows = 50; // Number of rows to render at once
    let scrollTop = 0;
    let rowHeight = 40; // Approximate row height in pixels
    let startIndex = 0;
    let endIndex = visibleRows;
    let isScrolling = false;

    document.addEventListener('DOMContentLoaded', function() {
        loadBusinessStats();
        loadBusinessRecords();

        // Setup search input visual feedback
        function setupSearchVisualFeedback() {
            const searchInput = document.getElementById('businessSearch');
            const clearButton = document.getElementById('searchClear');
            
            if (searchInput && clearButton) {
                // Add visual feedback for search state
                searchInput.addEventListener('input', function() {
                    const value = this.value.trim();
                    if (value) {
                        this.classList.add('searching');
                        clearButton.style.display = 'flex';
                    } else {
                        this.classList.remove('searching');
                        clearButton.style.display = 'none';
                    }
                });
                
                // Add suggestions functionality
                searchInput.addEventListener('input', debouncedShowSuggestions);
                searchInput.addEventListener('focus', showSuggestions);
                searchInput.addEventListener('blur', hideSuggestions);
                searchInput.addEventListener('keydown', handleSearchKeydown);
                
                console.log('Search visual feedback setup complete');
            }
        }

        // Setup search functionality
        setupSearchVisualFeedback();


        // Excel import event listeners
        setupExcelImport();

        // Load latest import directly into the main table (no dropdown needed)
        loadLatestImportAndRender();

        // Try to restore any previously loaded import ID
        const savedImportId = localStorage.getItem('currentImportId');
        if (savedImportId) {
            currentImportId = savedImportId;
        }

        // Test search functionality after a short delay
        setTimeout(() => {
            console.log('Testing search functionality...');
            const searchInput = document.getElementById('businessSearch');
            if (searchInput) {
                console.log('Search input is available, testing...');
                // Trigger a test search
                searchInput.value = 'test';
                debouncedFilterBusinesses();
            }
        }, 2000);


    });

    function loadBusinessStats() {
        // Calculate stats from actual table data
        calculateDynamicStats();
    }

    function calculateDynamicStats() {
        // Use the stored allData array instead of DOM elements for more accurate stats
        if (!allData || allData.length === 0) {
            // Fallback to DOM calculation if allData is not available
            const tableRows = document.querySelectorAll('#businessTable tbody tr');
            const totalRows = Array.from(tableRows).filter(row =>
                !row.classList.contains('loading-row') &&
                !row.classList.contains('no-results-row') &&
                row.cells.length > 1 &&
                row.cells[0].textContent.trim() !== ''
            );

            const totalBusinesses = totalRows.length;
            animateStatUpdate('totalBusinesses', totalBusinesses);
            animateStatUpdate('activeBusinesses', Math.floor(totalBusinesses * 0.7)); // Estimate
            animateStatUpdate('pendingBusinesses', Math.floor(totalBusinesses * 0.2)); // Estimate
            animateStatUpdate('expiredBusinesses', Math.floor(totalBusinesses * 0.1)); // Estimate
            return;
        }

        const totalBusinesses = allData.length;

        // Calculate stats based on data patterns
        let activeCount = 0;
        let pendingCount = 0;
        let expiredCount = 0;

        allData.forEach(row => {
            const rowData = Object.values(row).map(value => 
                (value || '').toString().toLowerCase().trim()
            );

            // Check for status indicators in the data
            const hasActiveIndicators = rowData.some(cell =>
                cell.includes('active') ||
                cell.includes('approved') ||
                cell.includes('valid') ||
                cell.includes('current') ||
                cell.includes('operational')
            );

            const hasPendingIndicators = rowData.some(cell =>
                cell.includes('pending') ||
                cell.includes('processing') ||
                cell.includes('review') ||
                cell.includes('waiting') ||
                cell.includes('under review')
            );

            const hasExpiredIndicators = rowData.some(cell =>
                cell.includes('expired') ||
                cell.includes('inactive') ||
                cell.includes('suspended') ||
                cell.includes('cancelled') ||
                cell.includes('closed')
            );

            if (hasActiveIndicators) {
                activeCount++;
            } else if (hasPendingIndicators) {
                pendingCount++;
            } else if (hasExpiredIndicators) {
                expiredCount++;
            } else {
                // Default to active if no clear status
                activeCount++;
            }
        });

        // Update stats with animation
        animateStatUpdate('totalBusinesses', totalBusinesses);
        animateStatUpdate('activeBusinesses', activeCount);
        animateStatUpdate('pendingBusinesses', pendingCount);
        animateStatUpdate('expiredBusinesses', expiredCount);
    }

    function animateStatUpdate(elementId, targetValue) {
        const element = document.getElementById(elementId);
        if (!element) return;

        // Add visual feedback to the stat card
        const statCard = element.closest('.stat-card');
        if (statCard) {
            statCard.classList.add('updating');
            setTimeout(() => {
                statCard.classList.remove('updating');
            }, 600);
        }

        const currentValue = parseInt(element.textContent.replace(/,/g, '')) || 0;
        const increment = targetValue > currentValue ? 1 : -1;
        const duration = 1000; // 1 second
        const steps = Math.abs(targetValue - currentValue);
        const stepDuration = steps > 0 ? duration / steps : 0;

        let current = currentValue;

        if (steps === 0) {
            element.textContent = formatNumber(targetValue);
            return;
        }

        const timer = setInterval(() => {
            current += increment;
            element.textContent = formatNumber(current);

            if (current === targetValue) {
                clearInterval(timer);
                element.textContent = formatNumber(targetValue);
            }
        }, stepDuration);
    }

    function formatNumber(num) {
        return num.toLocaleString();
    }

    function loadBusinessRecords() {
        const tbody = document.querySelector('#businessTable tbody');
        if (!tbody) return;

        // Show loading state
        tbody.innerHTML = `
            <tr>
                <td colspan="6">
                    <div class="loading-spinner">
                        <i class="fas fa-spinner fa-spin"></i>
                        Loading business records...
                    </div>
                </td>
            </tr>
        `;

        // Try to load the latest import data
        loadLatestImportAndRender();
    }



    function debouncedFilterBusinesses() {
        console.log('debouncedFilterBusinesses called');
        // Clear existing timeout
        if (searchTimeout) {
            clearTimeout(searchTimeout);
            console.log('Cleared existing timeout');
        }

        // Set new timeout for 300ms delay (reduced from 500ms for better reactivity)
        searchTimeout = setTimeout(() => {
            console.log('Debounced search triggered after 300ms');
            console.log('Search input value:', document.getElementById('businessSearch').value);
            filterBusinesses();
        }, 300);
        console.log('Set new timeout for 300ms');
    }

    function filterBusinesses() {
        const searchInput = document.getElementById('businessSearch');
        const searchTerm = searchInput ? searchInput.value.trim() : '';
        const tbody = document.querySelector('#businessTable tbody');

        console.log('Searching for:', searchTerm);

        // If no search term, restore original data
        if (!searchTerm) {
            console.log('No search term, restoring all data');
            
            // If we have stored data, re-render it with virtual scrolling
            if (allData && allData.length > 0) {
                const thead = document.querySelector('#businessTable thead tr');
                const columns = Array.from(thead.querySelectorAll('th')).slice(0, -1).map(th => ({
                    column_name: th.textContent
                }));
                renderMainTableWithPagination(columns, allData, thead, tbody);
                updatePaginationControls();
                
                // Recalculate stats
                setTimeout(() => {
                    calculateDynamicStats();
                }, 100);
            }
            return;
        }

        // Filter data client-side for virtual scrolling
        const filteredData = filterDataClientSide(allData, searchTerm);
        
        if (filteredData.length === 0) {
            tbody.innerHTML = `<tr><td colspan="6" style="text-align: center; padding: 40px; color: #64748b; font-style: italic;">
                <i class="fas fa-search" style="margin-right: 8px;"></i>
                No matching records found for "${searchTerm}"
            </td></tr>`;
            return;
        }

        // Re-render with filtered data using virtual scrolling
        const thead = document.querySelector('#businessTable thead tr');
        const columns = Array.from(thead.querySelectorAll('th')).slice(0, -1).map(th => ({
            column_name: th.textContent
        }));
        
        // Update global data for virtual scrolling
        allData = filteredData;
        totalRecords = filteredData.length;
        startIndex = 0;
        endIndex = Math.min(visibleRows, totalRecords);
        
        renderVirtualRows(columns, tbody);
        updatePaginationControls();
        
        console.log('Search complete. Showing', filteredData.length, 'matching rows');
    }

    function filterDataClientSide(data, searchTerm) {
        const searchLower = searchTerm.toLowerCase();
        return data.filter(row => {
            return Object.values(row).some(value => {
                if (value && typeof value === 'string') {
                    return value.toLowerCase().includes(searchLower);
                }
                return false;
            });
        });
    }

    function renderFilteredResults(filteredData, searchTerm) {
        console.log('Rendering filtered results:', filteredData.length, 'matches');

        const tbody = document.querySelector('#businessTable tbody');
        const thead = document.querySelector('#businessTable thead tr');

        if (!tbody) {
            console.error('Table body not found!');
            return;
        }

        // Get columns from current table header
        const columns = Array.from(thead.querySelectorAll('th')).slice(0, -1).map(th => ({
            column_name: th.textContent
        }));

        if (filteredData.length === 0) {
            tbody.innerHTML = `<tr><td colspan="${columns.length + 1}">No matching records found for "${searchTerm}"</td></tr>`;
            return;
        }

        // Build table body with filtered results
        let html = '';
        filteredData.forEach(row => {
            html += '<tr>';
            columns.forEach(column => {
                const value = row[column.column_name] || '';
                const highlightedValue = highlightSearchTerm(value, searchTerm);
                html += `<td title="${value}">${highlightedValue}</td>`;
            });
            html += `
                <td style="text-align: center; white-space: nowrap; width: 80px; min-width: 80px; max-width: 80px; position: sticky; right: 0; background: white; z-index: 4; box-shadow: -2px 0 4px rgba(0, 0, 0, 0.1);">
                    <div class="action-buttons">
                        <button class="btn-action view" title="View Business" onclick="viewBusiness('${row[columns[0]?.column_name] || ''}')">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn-action edit" title="Edit Business" onclick="editBusiness('${row[columns[0]?.column_name] || ''}')">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-action delete" title="Delete Business" onclick="deleteBusiness('${row[columns[0]?.column_name] || ''}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            html += '</tr>';
        });

        tbody.innerHTML = html;

        // Add search results info
        addSearchResultsInfo(searchTerm, filteredData.length, filteredData.length);
    }


    function openAddBusinessModal() {
        document.getElementById('addBusinessModal').style.display = 'block';
    }

    function closeAddBusinessModal() {
        document.getElementById('addBusinessModal').style.display = 'none';
        document.getElementById('addBusinessForm').reset();
    }

    function saveBusiness() {
        const form = document.getElementById('addBusinessForm');
        const formData = new FormData(form);

        // Validate form
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        // Simulate API call
        showNotification('Business added successfully!', 'success');
        closeAddBusinessModal();
        loadBusinessRecords();
        loadBusinessStats();
    }

    function viewBusiness(businessId) {
        showNotification(`Viewing business ${businessId}`, 'info');
    }

    function editBusiness(businessId) {
        showNotification(`Editing business ${businessId}`, 'info');
    }

    function deleteBusiness(businessId) {
        if (confirm(`Are you sure you want to delete business ${businessId}?`)) {
            showNotification(`Business ${businessId} deleted successfully!`, 'success');
            loadBusinessRecords();
            loadBusinessStats();
        }
    }

    function exportBusinesses() {
        showNotification('Exporting business records...', 'info');
    }

    function refreshBusinesses() {
        // Reload the latest import data instead of clearing it
        loadLatestImportAndRender();
        // Stats will be calculated automatically after data loads
        showNotification('Business records refreshed!', 'success');
    }

    function clearSearch() {
        const searchInput = document.getElementById('businessSearch');
        const clearButton = document.getElementById('searchClear');
        
        if (searchInput) {
            searchInput.value = '';
            searchInput.classList.remove('searching');
            searchInput.focus();
        }
        
        if (clearButton) {
            clearButton.style.display = 'none';
        }
        
        // Hide suggestions
        hideSuggestions();
        
        // Restore all data immediately
        filterBusinesses();
        
        console.log('Search cleared and data restored');
    }

    // ------- Dynamic Excel Imports Preview -------
    async function loadLatestImportAndRender() {
        try {
            const res = await fetch('/obo/api/excel/get_latest.php?limit=99999&page=1');
            const json = await res.json();
            if (!json.success || !json.data || !json.data.import) {
                const tbody = document.querySelector('#businessTable tbody');
                if (tbody) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="6">
                                <div>
                                    <i class="fas fa-database"></i>
                                    No Excel data imported yet. Click "Import Excel" to upload your data.
                                </div>
                            </td>
                        </tr>
                    `;
                }
                return;
            }
            const latest = json.data;
            currentImportId = latest.import.id;
            // Save to localStorage for persistence
            localStorage.setItem('currentImportId', currentImportId);
            console.log('Loading latest import data:', latest);
            // Directly render using the already-returned data to avoid a second fetch
            renderBusinessTableFromJson(latest);
        } catch (e) {
            console.error('Failed to load latest import', e);
            const tbody = document.querySelector('#businessTable tbody');
            if (tbody) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6">
                            <div class="loading-spinner">
                                <i class="fas fa-exclamation-triangle"></i>
                                Failed to load data. Please try refreshing the page.
                            </div>
                        </td>
                    </tr>
                `;
            }
        }
    }

    function viewSelectedImport() {
        if (!currentImportId) {
            showNotification('No import loaded yet', 'warning');
            return;
        }
        openDynamicDataModal(currentImportId);
    }

    // ------- Render selected import into main table -------
    function normalizeColumnName(name) {
        return (name || '').toString().trim().toLowerCase();
    }

    function findFirstMatchingColumn(columns, candidates) {
        const colNames = columns.map(c => normalizeColumnName(c.column_name));
        for (const cand of candidates) {
            const idx = colNames.indexOf(normalizeColumnName(cand));
            if (idx !== -1) return columns[idx].column_name; // return actual name
        }
        return null;
    }

    async function loadSelectedImportToMainTable() {
        const sel = document.getElementById('importSelect');
        if (!sel || !sel.value) return;
        renderBusinessTableFromImport(sel.value);
    }

    async function renderBusinessTableFromImport(importId) {
        const tbody = document.querySelector('#businessTable tbody');
        const thead = document.querySelector('#businessTable thead tr');
        if (!tbody) return;

        tbody.innerHTML = `
            <tr class="loading-row"><td colspan="6">
                <div class="loading-spinner">
                    <i class="fas fa-spinner fa-spin"></i>
                    Loading import data...
                </div>
            </td></tr>
        `;

        try {
            const url = `/obo/api/excel/get_data.php?import_id=${encodeURIComponent(importId)}&page=1&limit=99999`;
            const res = await fetch(url);
            const json = await res.json();
            if (!json.success) {
                tbody.innerHTML = `<tr><td colspan="6">${json.message || 'Failed to load data'}</td></tr>`;
                return;
            }

            const data = json.data;
            const columns = data.columns || [];
            const rows = data.rows || [];

            console.log('Loading import data with columns:', columns.map(c => c.column_name));
            console.log('Loading import data with rows:', rows.length);

            // Store all data for pagination
            allData = rows;
            totalRecords = rows.length;
            totalPages = Math.ceil(totalRecords / pageSize);

            console.log('Total records loaded:', totalRecords);
            console.log('Total pages calculated:', totalPages);

            // Analyze columns for data content
            const columnAnalysis = analyzeColumns(columns, rows);
            const {
                populatedColumns,
                emptyColumns
            } = columnAnalysis;

            console.log('Populated columns:', populatedColumns.map(c => c.column_name));
            console.log('Empty columns:', emptyColumns.map(c => c.column_name));

            // Render main table with populated columns and pagination
            renderMainTableWithPagination(populatedColumns, rows, thead, tbody);

            // Render empty columns table if there are empty columns
            if (emptyColumns.length > 0) {
                renderEmptyColumnsTable(emptyColumns, rows);
            }

            // Update pagination controls
            updatePaginationControls();

            // Show notification with loaded records count
            if (totalRecords > 0) {
                const performanceMode = totalRecords > 1000 ? ' (Virtual Scrolling Enabled)' : '';
                showNotification(`Loaded all ${totalRecords} records successfully!${performanceMode} Use search to find specific records.`, 'success');
            }

            // No dynamic filters needed - just single search input

            // Recalculate stats after rendering
            setTimeout(() => {
                calculateDynamicStats();
            }, 100);
        } catch (err) {
            console.error(err);
            tbody.innerHTML = '<tr><td colspan="6">Failed to load data</td></tr>';
        }
    }

    // Accepts a JSON payload in the same shape as /api/excel/get_latest.php
    function renderBusinessTableFromJson(payload) {
        const tbody = document.querySelector('#businessTable tbody');
        const thead = document.querySelector('#businessTable thead tr');
        if (!tbody) return;

        const columns = payload.columns || [];
        const rows = payload.rows || [];

        console.log('Rendering table with columns:', columns.map(c => c.column_name));
        console.log('Rendering table with rows:', rows.length);

        // Store all data for pagination and search
        allData = rows;
        totalRecords = rows.length;
        totalPages = Math.ceil(totalRecords / pageSize);

        console.log('Stored data for search:', allData.length, 'records');

        console.log('Total records loaded:', totalRecords);
        console.log('Total pages calculated:', totalPages);

        if (columns.length > 0) {
            // Analyze columns for data content
            const columnAnalysis = analyzeColumns(columns, rows);
            const {
                populatedColumns,
                emptyColumns
            } = columnAnalysis;

            console.log('Populated columns:', populatedColumns.map(c => c.column_name));
            console.log('Empty columns:', emptyColumns.map(c => c.column_name));

            // Render main table with populated columns and pagination
            renderMainTableWithPagination(populatedColumns, rows, thead, tbody);

            // Render empty columns table if there are empty columns
            if (emptyColumns.length > 0) {
                renderEmptyColumnsTable(emptyColumns, rows);
            }
        } else {
            tbody.innerHTML = '<tr><td colspan="6">No data available</td></tr>';
        }

        // Update pagination controls
        updatePaginationControls();

        // Show notification with loaded records count
        if (totalRecords > 0) {
            const performanceMode = totalRecords > 1000 ? ' (Virtual Scrolling Enabled)' : '';
            showNotification(`Loaded all ${totalRecords} records successfully!${performanceMode} Type in the search box to find specific records.`, 'success');
        }

        // No dynamic filters needed - just single search input

        // Recalculate stats after rendering
        setTimeout(() => {
            calculateDynamicStats();
        }, 100);
    }

    function analyzeColumns(columns, rows) {
        const populatedColumns = [];
        const emptyColumns = [];

        columns.forEach(column => {
            const columnName = column.column_name;
            let hasData = false;
            let dataCount = 0;

            // Check if column has meaningful data
            rows.forEach(row => {
                const value = row[columnName];
                if (value && value.toString().trim() !== '' && value.toString().trim() !== 'null' && value.toString().trim() !== 'undefined') {
                    hasData = true;
                    dataCount++;
                }
            });

            // Consider column populated if it has data in at least 20% of rows
            const dataPercentage = (dataCount / rows.length) * 100;
            if (dataPercentage >= 20) {
                populatedColumns.push(column);
            } else {
                emptyColumns.push(column);
            }
        });

        return {
            populatedColumns,
            emptyColumns
        };
    }

    function renderMainTable(columns, rows, thead, tbody) {
        // Update table header with populated columns
        let headerHTML = '';
        columns.forEach(column => {
            headerHTML += `<th>${column.column_name}</th>`;
        });
        headerHTML += '<th style="width: 80px; min-width: 80px; max-width: 80px; position: sticky; right: 0; background: #f8fafc; z-index: 5; box-shadow: -2px 0 4px rgba(0, 0, 0, 0.1);">Actions</th>';

        if (thead) {
            thead.innerHTML = headerHTML;
        }

        // Build table body with populated columns
        let html = '';
        rows.forEach(row => {
            html += '<tr>';
            columns.forEach(column => {
                const value = row[column.column_name] || '';
                html += `<td title="${value}">${value}</td>`;
            });
            html += `
                <td style="text-align: center; white-space: nowrap; width: 80px; min-width: 80px; max-width: 80px; position: sticky; right: 0; background: white; z-index: 4; box-shadow: -2px 0 4px rgba(0, 0, 0, 0.1);">
                    <div class="action-buttons">
                        <button class="btn-action view" title="View Business" onclick="viewBusiness('${row[columns[0]?.column_name] || ''}')">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn-action edit" title="Edit Business" onclick="editBusiness('${row[columns[0]?.column_name] || ''}')">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-action delete" title="Delete Business" onclick="deleteBusiness('${row[columns[0]?.column_name] || ''}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            html += '</tr>';
        });

        tbody.innerHTML = html || `<tr><td colspan="${columns.length + 1}">No rows found</td></tr>`;
    }

    function renderMainTableWithPagination(columns, allRows, thead, tbody) {
        // Update table header with populated columns
        let headerHTML = '';
        columns.forEach(column => {
            headerHTML += `<th>${column.column_name}</th>`;
        });
        headerHTML += '<th style="width: 80px; min-width: 80px; max-width: 80px; position: sticky; right: 0; background: #f8fafc; z-index: 5; box-shadow: -2px 0 4px rgba(0, 0, 0, 0.1);">Actions</th>';

        if (thead) {
            thead.innerHTML = headerHTML;
            console.log('Table header updated with columns:', columns.length + 1, 'total columns (including Actions)');
        }

        // Store data globally for virtual scrolling
        allData = allRows;
        totalRecords = allRows.length;
        
        // Initialize virtual scrolling
        startIndex = 0;
        endIndex = Math.min(visibleRows, totalRecords);
        
        // Render initial visible rows
        renderVirtualRows(columns, tbody);
        
        // Add scroll event listener for virtual scrolling
        setupVirtualScrolling(columns, tbody);
        
        console.log('Virtual scrolling initialized for', totalRecords, 'total rows');
    }
    
    function renderVirtualRows(columns, tbody) {
        if (!allData || allData.length === 0) {
            tbody.innerHTML = `<tr><td colspan="${columns.length + 1}">No rows found</td></tr>`;
            return;
        }
        
        const visibleData = allData.slice(startIndex, endIndex);
        let html = '';
        
        // Add spacer for rows before visible area
        if (startIndex > 0) {
            html += `<tr style="height: ${startIndex * rowHeight}px;"><td colspan="${columns.length + 1}" style="padding: 0; border: none;"></td></tr>`;
        }
        
        // Render visible rows
        visibleData.forEach((row, index) => {
            const actualIndex = startIndex + index;
            html += '<tr>';
            columns.forEach(column => {
                const value = row[column.column_name] || '';
                html += `<td title="${value}">${value}</td>`;
            });
            html += `
                <td style="text-align: center; white-space: nowrap; width: 80px; min-width: 80px; max-width: 80px; position: sticky; right: 0; background: white; z-index: 4; box-shadow: -2px 0 4px rgba(0, 0, 0, 0.1);">
                    <div class="action-buttons">
                        <button class="btn-action view" title="View Business" onclick="viewBusiness('${row[columns[0]?.column_name] || ''}')">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn-action edit" title="Edit Business" onclick="editBusiness('${row[columns[0]?.column_name] || ''}')">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-action delete" title="Delete Business" onclick="deleteBusiness('${row[columns[0]?.column_name] || ''}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            html += '</tr>';
        });
        
        // Add spacer for rows after visible area
        const remainingRows = totalRecords - endIndex;
        if (remainingRows > 0) {
            html += `<tr style="height: ${remainingRows * rowHeight}px;"><td colspan="${columns.length + 1}" style="padding: 0; border: none;"></td></tr>`;
        }
        
        tbody.innerHTML = html;
    }
    
    function setupVirtualScrolling(columns, tbody) {
        const tableWrapper = document.querySelector('.table-wrapper');
        if (!tableWrapper) return;
        
        // Remove existing scroll listener
        tableWrapper.removeEventListener('scroll', handleVirtualScroll);
        
        // Add new scroll listener
        tableWrapper.addEventListener('scroll', handleVirtualScroll);
        
        function handleVirtualScroll() {
            if (isScrolling) return;
            
            isScrolling = true;
            requestAnimationFrame(() => {
                scrollTop = tableWrapper.scrollTop;
                const newStartIndex = Math.floor(scrollTop / rowHeight);
                const newEndIndex = Math.min(newStartIndex + visibleRows, totalRecords);
                
                // Only re-render if the visible range has changed significantly
                if (Math.abs(newStartIndex - startIndex) > 5) {
                    startIndex = newStartIndex;
                    endIndex = newEndIndex;
                    renderVirtualRows(columns, tbody);
                }
                
                isScrolling = false;
            });
        }
    }


    function highlightSearchTerm(text, searchTerm) {
        if (!searchTerm || !text) return text;

        const regex = new RegExp(`(${searchTerm.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
        return text.replace(regex, '<span class="search-highlight">$1</span>');
    }

    function addSearchResultsInfo(searchTerm, totalResults, displayedResults) {
        // Remove existing search info if any
        const existingInfo = document.querySelector('.search-results-info');
        if (existingInfo) {
            existingInfo.remove();
        }

        if (!searchTerm || totalResults === 0) return;

        const searchInfo = document.createElement('div');
        searchInfo.className = 'search-results-info';

        let infoText = '';
        if (totalResults === displayedResults) {
            infoText = `<i class="fas fa-search"></i> Found ${totalResults} results for "${searchTerm}"`;
        } else {
            infoText = `<i class="fas fa-search"></i> Showing ${displayedResults} of ${totalResults} results for "${searchTerm}"`;
        }

        searchInfo.innerHTML = infoText;

        // Insert before the table
        const tableContainer = document.querySelector('.table-container');
        if (tableContainer) {
            tableContainer.insertBefore(searchInfo, tableContainer.firstChild);
        }
    }

    // Search Suggestions Functions
    function debouncedShowSuggestions() {
        if (suggestionsTimeout) {
            clearTimeout(suggestionsTimeout);
        }

        suggestionsTimeout = setTimeout(() => {
            const searchTerm = document.getElementById('businessSearch').value.trim();
            if (searchTerm.length >= 2) {
                loadSearchSuggestions(searchTerm);
            } else {
                hideSuggestions();
            }
        }, 200);
    }

    function loadSearchSuggestions(searchTerm) {
        if (!searchTerm || searchTerm.length < 2) {
            hideSuggestions();
            return;
        }

        // Get suggestions from current data
        const suggestions = generateSuggestionsFromData(searchTerm);
        displaySuggestions(suggestions);
    }

    function generateSuggestionsFromData(searchTerm) {
        if (!allData || allData.length === 0) return [];

        const suggestions = new Map();
        const searchLower = searchTerm.toLowerCase();

        allData.forEach(row => {
            Object.values(row).forEach(value => {
                if (value && typeof value === 'string') {
                    const valueLower = value.toLowerCase();
                    if (valueLower.includes(searchLower)) {
                        // Create suggestion text
                        const suggestionText = value.length > 50 ? value.substring(0, 50) + '...' : value;

                        if (!suggestions.has(suggestionText)) {
                            suggestions.set(suggestionText, {
                                text: suggestionText,
                                fullText: value,
                                count: 1
                            });
                        } else {
                            suggestions.get(suggestionText).count++;
                        }
                    }
                }
            });
        });

        // Convert to array and sort by relevance
        return Array.from(suggestions.values())
            .sort((a, b) => {
                // Prioritize exact matches
                const aExact = a.fullText.toLowerCase().startsWith(searchLower);
                const bExact = b.fullText.toLowerCase().startsWith(searchLower);
                if (aExact && !bExact) return -1;
                if (!aExact && bExact) return 1;

                // Then by count (frequency)
                return b.count - a.count;
            })
            .slice(0, 8); // Limit to 8 suggestions
    }

    function displaySuggestions(suggestions) {
        const suggestionsContainer = document.getElementById('searchSuggestions');
        if (!suggestionsContainer) return;

        if (suggestions.length === 0) {
            hideSuggestions();
            return;
        }

        let html = '';
        suggestions.forEach((suggestion, index) => {
            html += `
                <div class="search-suggestion-item" data-index="${index}" onclick="selectSuggestion('${suggestion.fullText.replace(/'/g, "\\'")}')">
                    <div class="suggestion-text">${highlightSearchTerm(suggestion.text, document.getElementById('businessSearch').value)}</div>
                    <div class="suggestion-context">Found in ${suggestion.count} record${suggestion.count > 1 ? 's' : ''}</div>
                        </div>
            `;
        });

        suggestionsContainer.innerHTML = html;
        suggestionsContainer.style.display = 'block';
        searchSuggestions = suggestions;
        selectedSuggestionIndex = -1;
    }

    function showSuggestions() {
        const searchInput = document.getElementById('businessSearch');
        const searchTerm = searchInput.value.trim();

        if (searchTerm.length >= 2) {
            loadSearchSuggestions(searchTerm);
        }
    }

    function hideSuggestions() {
        const suggestionsContainer = document.getElementById('searchSuggestions');
        if (suggestionsContainer) {
            suggestionsContainer.style.display = 'none';
        }
        selectedSuggestionIndex = -1;
    }

    function selectSuggestion(suggestionText) {
        const searchInput = document.getElementById('businessSearch');
        searchInput.value = suggestionText;
        hideSuggestions();
        filterBusinesses();
    }

    function handleSearchKeydown(event) {
        const suggestionsContainer = document.getElementById('searchSuggestions');
        if (!suggestionsContainer || suggestionsContainer.style.display === 'none') {
            return;
        }

        switch (event.key) {
            case 'ArrowDown':
                event.preventDefault();
                selectedSuggestionIndex = Math.min(selectedSuggestionIndex + 1, searchSuggestions.length - 1);
                updateSuggestionSelection();
                break;
            case 'ArrowUp':
                event.preventDefault();
                selectedSuggestionIndex = Math.max(selectedSuggestionIndex - 1, -1);
                updateSuggestionSelection();
                break;
            case 'Enter':
                event.preventDefault();
                if (selectedSuggestionIndex >= 0 && searchSuggestions[selectedSuggestionIndex]) {
                    selectSuggestion(searchSuggestions[selectedSuggestionIndex].fullText);
                } else {
                    filterBusinesses();
                }
                break;
            case 'Escape':
                hideSuggestions();
                break;
        }
    }

    function updateSuggestionSelection() {
        const suggestionItems = document.querySelectorAll('.search-suggestion-item');
        suggestionItems.forEach((item, index) => {
            if (index === selectedSuggestionIndex) {
                item.style.backgroundColor = '#f3f4f6';
            } else {
                item.style.backgroundColor = '';
            }
        });
    }

    // Dynamic filter functions removed - using single search input only

    function renderEmptyColumnsTable(emptyColumns, rows) {
        // Create or update the empty columns table
        let emptyTableContainer = document.getElementById('emptyColumnsTable');
        if (!emptyTableContainer) {
            emptyTableContainer = document.createElement('div');
            emptyTableContainer.id = 'emptyColumnsTable';
            emptyTableContainer.className = 'empty-columns-container';

            // Insert after the main table
            const tableContainer = document.querySelector('.table-container');
            if (tableContainer) {
                tableContainer.insertAdjacentElement('afterend', emptyTableContainer);
            }
        }

        emptyTableContainer.innerHTML = `
            <div class="table-container">
                <div class="table-header">
                    <h3>
                        <i class="fas fa-exclamation-triangle"></i>
                        Empty/Incomplete Columns
                    </h3>
                    <div class="table-actions">
                        <button class="btn btn-secondary" onclick="toggleEmptyColumns()">
                            <i class="fas fa-eye-slash"></i>
                            Hide Empty Columns
                        </button>
                    </div>
                </div>
                <div class="table-wrapper">
                    <table class="business-table" id="emptyColumnsTableContent">
                        <thead>
                            <tr>
                                ${emptyColumns.map(col => `<th>${col.column_name}</th>`).join('')}
                                <th>Data Quality</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${rows.slice(0, 10).map(row => `
                                <tr>
                                    ${emptyColumns.map(column => {
                                        const value = row[column.column_name] || '';
                                        return `<td title="${value}">${value || '<span class="empty-cell">No Data</span>'}</td>`;
                                    }).join('')}
                                    <td>
                                        <span class="data-quality-badge low">
                                            <i class="fas fa-exclamation-circle"></i>
                                            Incomplete
                                        </span>
                                    </td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            </div>
        `;
    }

    // Excel Import Functions
    function setupExcelImport() {
        const fileInput = document.getElementById('excelFileInput');
        const uploadArea = document.getElementById('uploadArea');


        if (!fileInput || !uploadArea) {
            console.error('Required elements not found for Excel import setup');
            return;
        }

        // File input change
        fileInput.addEventListener('change', handleFileSelect);

        // Drag and drop
        uploadArea.addEventListener('dragover', handleDragOver);
        uploadArea.addEventListener('dragleave', handleDragLeave);
        uploadArea.addEventListener('drop', handleFileDrop);
        
        // Only trigger file input click if not clicking on the button
        uploadArea.addEventListener('click', (e) => {
            // Don't trigger if clicking on the button or file info area
            if (!e.target.closest('.btn') && !e.target.closest('.file-info')) {
                fileInput.click();
            }
        });

    }

    function handleFileSelect(event) {
        const file = event.target.files[0];
        if (file) {
            displayFileInfo(file);
        } else {}
    }

    function handleDragOver(event) {
        event.preventDefault();
        event.currentTarget.classList.add('dragover');
    }

    function handleDragLeave(event) {
        event.currentTarget.classList.remove('dragover');
    }

    function handleFileDrop(event) {
        event.preventDefault();
        event.currentTarget.classList.remove('dragover');

        const files = event.dataTransfer.files;
        if (files.length > 0) {
            const file = files[0];
            const fileInput = document.getElementById('excelFileInput');
            
            // Create a new FileList-like object to avoid triggering change event
            const dt = new DataTransfer();
            dt.items.add(file);
            fileInput.files = dt.files;
            
            // Manually call displayFileInfo instead of relying on change event
            displayFileInfo(file);
        }
    }

    function displayFileInfo(file) {

        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        const fileInfo = document.getElementById('fileInfo');
        const uploadArea = document.getElementById('uploadArea');
        const importBtn = document.getElementById('importBtn');


        if (!fileName || !fileSize || !fileInfo || !uploadArea || !importBtn) {
            console.error('Required elements not found for file display');
            return;
        }

        // Enhanced file info display
        fileName.textContent = file.name;
        fileSize.textContent = `${formatFileSize(file.size)} • ${getFileType(file.name)}`;

        uploadArea.style.display = 'none';
        fileInfo.style.display = 'block';
        importBtn.style.display = 'block';

    }

    function getFileType(filename) {
        const extension = filename.split('.').pop().toLowerCase();
        switch (extension) {
            case 'csv':
                return 'CSV File';
            case 'xls':
                return 'Excel 97-2003';
            case 'xlsx':
                return 'Excel 2007+';
            default:
                return 'Unknown Type';
        }
    }

    function removeFile() {
        const fileInput = document.getElementById('excelFileInput');
        const fileInfo = document.getElementById('fileInfo');
        const uploadArea = document.getElementById('uploadArea');
        const importBtn = document.getElementById('importBtn');

        fileInput.value = '';
        fileInfo.style.display = 'none';
        uploadArea.style.display = 'block';
        importBtn.style.display = 'none';
    }

    function formatFileSize(bytes) {
        if (bytes >= 1073741824) {
            return (bytes / 1073741824).toFixed(2) + ' GB';
        } else if (bytes >= 1048576) {
            return (bytes / 1048576).toFixed(2) + ' MB';
        } else if (bytes >= 1024) {
            return (bytes / 1024).toFixed(2) + ' KB';
        } else {
            return bytes + ' bytes';
        }
    }

    function openImportModal() {
        document.getElementById('importModal').style.display = 'block';
        resetImportModal();

        // Ensure event listeners are set up when modal opens
        setTimeout(() => {
            setupExcelImport();
        }, 100);
    }

    function closeImportModal() {
        document.getElementById('importModal').style.display = 'none';
        resetImportModal();
    }

    function resetImportModal() {
        // Reset to step 1
        document.getElementById('importStep1').style.display = 'block';
        document.getElementById('importStep2').style.display = 'none';
        document.getElementById('importStep3').style.display = 'none';

        // Reset file input
        removeFile();

        // Reset progress
        document.getElementById('progressFill').style.width = '0%';
        document.getElementById('progressText').innerHTML = 'Processing...';
    }

    function startImport() {
        const fileInput = document.getElementById('excelFileInput');
        const file = fileInput.files[0];

        if (!file) {
            showNotification('Please select a file first', 'error');
            return;
        }

        // Show progress step
        document.getElementById('importStep1').style.display = 'none';
        document.getElementById('importStep2').style.display = 'block';

        // Update progress text with filename
        const progressText = document.getElementById('progressText');
        progressText.innerHTML = `
            <div class="progress-info">
                <i class="fas fa-upload"></i>
                <span>Uploading: <strong>${file.name}</strong></span>
            </div>
            <div class="progress-percentage">0%</div>
        `;

        // Create FormData
        const formData = new FormData();
        formData.append('excel_file', file);

        // Enhanced progress simulation with different stages
        let progress = 0;
        let currentStage = 'uploading';
        const stages = [{
                name: 'uploading',
                text: 'Uploading file...',
                icon: 'fa-upload'
            },
            {
                name: 'processing',
                text: 'Processing data...',
                icon: 'fa-cogs'
            },
            {
                name: 'validating',
                text: 'Validating data...',
                icon: 'fa-check-circle'
            },
            {
                name: 'saving',
                text: 'Saving to database...',
                icon: 'fa-database'
            }
        ];

        const progressInterval = setInterval(() => {
            progress += Math.random() * 15;
            if (progress > 90) progress = 90;

            // Update stage based on progress
            if (progress < 25) currentStage = 'uploading';
            else if (progress < 50) currentStage = 'processing';
            else if (progress < 75) currentStage = 'validating';
            else currentStage = 'saving';

            const stage = stages.find(s => s.name === currentStage);

            document.getElementById('progressFill').style.width = progress + '%';
            progressText.innerHTML = `
                <div class="progress-info">
                    <i class="fas ${stage.icon}"></i>
                    <span>${stage.text} <strong>${file.name}</strong></span>
                </div>
                <div class="progress-percentage">${Math.round(progress)}%</div>
            `;
        }, 300);

        // Send to server
        fetch('/obo/api/excel/import.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);

                // Handle authentication errors
                if (response.status === 401) {
                    showNotification('Session expired. Please log in again.', 'error');
                    setTimeout(() => {
                        window.location.href = '/obo/view/auth/Login.php';
                    }, 2000);
                    return Promise.reject('Authentication required');
                }

                // Check if response is JSON
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    console.error('Response is not JSON, content-type:', contentType);
                    return response.text().then(text => {
                        console.error('Response text:', text);
                        showNotification('Server error: Invalid response format', 'error');
                        throw new Error('Server returned non-JSON response: ' + text.substring(0, 200));
                    });
                }

                return response.json();
            })
            .then(data => {
                clearInterval(progressInterval);
                console.log('Import response:', data);

                if (data.success) {
                    // Complete progress with success message
                    document.getElementById('progressFill').style.width = '100%';
                    progressText.innerHTML = `
                        <div class="progress-info success">
                            <i class="fas fa-check-circle"></i>
                            <span>Import completed successfully!</span>
                        </div>
                        <div class="progress-percentage">100%</div>
                    `;

                    setTimeout(() => {
                        showImportSuccess(data.data);
                    }, 800);
                } else {
                    console.error('Import failed:', data.message);
                    showNotification(data.message || 'Import failed', 'error');
                    resetImportModal();
                }
            })
            .catch(error => {
                clearInterval(progressInterval);
                console.error('Import error:', error);
                showNotification('Import failed: ' + error.message, 'error');
                resetImportModal();
            });
    }

    function showImportSuccess(data) {
        currentImportId = data.import_id;
        // Save to localStorage for persistence
        localStorage.setItem('currentImportId', currentImportId);

        // Show success step
        document.getElementById('importStep2').style.display = 'none';
        document.getElementById('importStep3').style.display = 'block';

        // Get the original filename from the file input
        const fileInput = document.getElementById('excelFileInput');
        const originalFilename = fileInput.files[0] ? fileInput.files[0].name : 'Unknown file';

        // Update summary with filename and more details
        const summary = document.getElementById('importSummary');
        summary.innerHTML = `
        <div class="import-detail">
            <i class="fas fa-file-excel"></i>
            <div class="detail-content">
                <strong>File Name:</strong> ${originalFilename}
            </div>
        </div>
        <div class="import-detail">
            <i class="fas fa-table"></i>
            <div class="detail-content">
                <strong>Columns:</strong> ${data.columns.length} columns detected
            </div>
        </div>
        <div class="import-detail">
            <i class="fas fa-list-ol"></i>
            <div class="detail-content">
                <strong>Rows:</strong> ${data.total_rows} rows imported successfully
            </div>
        </div>
        <div class="import-detail">
            <i class="fas fa-columns"></i>
            <div class="detail-content">
                <strong>Column Names:</strong> ${data.columns.join(', ')}
            </div>
        </div>
    `;

        // Update footer buttons
        const footer = document.querySelector('#importModal .modal-footer');
        footer.innerHTML = `
        <button type="button" class="btn btn-secondary" onclick="closeImportModal()">Close</button>
        <button type="button" class="btn btn-primary" onclick="viewImportedData()">
            <i class="fas fa-eye"></i>
            View Data
        </button>
    `;

        // After upload, load the latest import into the main table
        loadLatestImportAndRender();
    }

    function viewImportedData() {
        if (!currentImportId) {
            showNotification('No import data available', 'error');
            return;
        }

        closeImportModal();
        // Small delay to ensure modal is closed before opening new one
        setTimeout(() => {
            openDynamicDataModal(currentImportId);
        }, 100);
    }

    function openDynamicDataModal(importId) {
        currentImportId = importId;
        // Save to localStorage for persistence
        localStorage.setItem('currentImportId', currentImportId);
        currentPage = 1;

        document.getElementById('dynamicDataModal').style.display = 'block';
        loadDynamicData();
    }

    function closeDynamicDataModal() {
        document.getElementById('dynamicDataModal').style.display = 'none';
        currentImportId = null;
    }

    function loadDynamicData() {
        if (!currentImportId) {
            console.error('No current import ID');
            return;
        }

        const url = `/obo/api/excel/get_data.php?import_id=${currentImportId}&page=${currentPage}&limit=99999`;
        console.log('Loading data from:', url);

        fetch(url)
            .then(response => {
                console.log('Data response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Data response:', data);
                if (data.success) {
                    displayDynamicTable(data.data);
                } else {
                    console.error('Data load failed:', data.message);
                    showNotification(data.message || 'Failed to load data', 'error');
                }
            })
            .catch(error => {
                console.error('Load data error:', error);
                showNotification('Failed to load data: ' + error.message, 'error');
            });
    }

    function displayDynamicTable(data) {
        console.log('Displaying dynamic table with data:', data);

        const tableHead = document.getElementById('dynamicTableHead');
        const tableBody = document.getElementById('dynamicTableBody');
        const modalTitle = document.getElementById('dynamicModalTitle');
        const pageInfo = document.getElementById('pageInfo');

        if (!tableHead || !tableBody || !modalTitle || !pageInfo) {
            console.error('Required DOM elements not found');
            return;
        }

        // Update title
        modalTitle.textContent = `Imported Data - ${data.import.original_filename}`;

        // Update pagination
        currentPage = data.pagination.current_page;
        totalPages = data.pagination.total_pages;
        pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;

        // Update pagination buttons
        document.getElementById('prevPage').disabled = !data.pagination.has_prev;
        document.getElementById('nextPage').disabled = !data.pagination.has_next;

        // Build table header
        let headerHTML = '<tr>';
        data.columns.forEach(column => {
            headerHTML += `<th>${column.column_name}</th>`;
        });
        headerHTML += '</tr>';
        tableHead.innerHTML = headerHTML;

        // Build table body
        let bodyHTML = '';
        data.rows.forEach(row => {
            bodyHTML += '<tr>';
            data.columns.forEach(column => {
                const value = row[column.column_name] || '';
                bodyHTML += `<td title="${value}">${value}</td>`;
            });
            bodyHTML += '</tr>';
        });
        tableBody.innerHTML = bodyHTML;

        console.log('Table updated with', data.rows.length, 'rows and', data.columns.length, 'columns');
    }

    function changePage(direction) {
        const newPage = currentPage + direction;
        if (newPage >= 1 && newPage <= totalPages) {
            currentPage = newPage;
            loadDynamicData();
        }
    }

    function refreshData() {
        loadDynamicData();
    }

    function toggleEmptyColumns() {
        const emptyTable = document.getElementById('emptyColumnsTable');
        if (!emptyTable) return;

        const isVisible = emptyTable.style.display !== 'none';
        emptyTable.style.display = isVisible ? 'none' : 'block';

        const button = document.querySelector('[onclick="toggleEmptyColumns()"]');
        if (button) {
            const icon = button.querySelector('i');
            const text = button.querySelector('span') || button.childNodes[button.childNodes.length - 1];

            if (isVisible) {
                icon.className = 'fas fa-eye';
                button.innerHTML = '<i class="fas fa-eye"></i> Show Empty Columns';
            } else {
                icon.className = 'fas fa-eye-slash';
                button.innerHTML = '<i class="fas fa-eye-slash"></i> Hide Empty Columns';
            }
        }
    }

    // Pagination Functions - Modified for client-side display
    function updatePaginationControls() {
        const paginationContainer = document.getElementById('paginationContainer');
        const paginationInfo = document.getElementById('paginationInfo');

        if (!paginationContainer || totalRecords === 0) {
            if (paginationContainer) {
                paginationContainer.style.display = 'none';
            }
            return;
        }

        // Show pagination info
        paginationContainer.style.display = 'flex';
        paginationInfo.textContent = `Showing all ${totalRecords} entries`;

        // Hide pagination controls since we're showing all data
        const firstPage = document.getElementById('firstPage');
        const prevPage = document.getElementById('prevPage');
        const nextPage = document.getElementById('nextPage');
        const lastPage = document.getElementById('lastPage');
        const pageNumbers = document.getElementById('pageNumbers');

        if (firstPage) firstPage.style.display = 'none';
        if (prevPage) prevPage.style.display = 'none';
        if (nextPage) nextPage.style.display = 'none';
        if (lastPage) lastPage.style.display = 'none';
        if (pageNumbers) pageNumbers.style.display = 'none';
    }

    function goToPage(page) {
        if (page < 1 || page > totalPages || page === currentPage) {
            return;
        }

        currentPage = page;

        // Re-render the table with new page
        if (allData.length > 0) {
            // Get the columns from the current table header
            const thead = document.querySelector('#businessTable thead tr');
            const columns = Array.from(thead.querySelectorAll('th')).slice(0, -1).map(th => ({
                column_name: th.textContent
            }));

            const tbody = document.querySelector('#businessTable tbody');
            renderMainTableWithPagination(columns, allData, thead, tbody);
            updatePaginationControls();

            // Recalculate stats
            setTimeout(() => {
                calculateDynamicStats();
            }, 100);
        }
    }

    function changePageSize() {
        const newPageSize = parseInt(document.getElementById('pageSize').value);
        if (newPageSize !== pageSize) {
            pageSize = newPageSize;
            currentPage = 1;
            totalPages = Math.ceil(totalRecords / pageSize);

            // Re-render the table
            if (allData.length > 0) {
                const thead = document.querySelector('#businessTable thead tr');
                const columns = Array.from(thead.querySelectorAll('th')).slice(0, -1).map(th => ({
                    column_name: th.textContent
                }));

                const tbody = document.querySelector('#businessTable tbody');
                renderMainTableWithPagination(columns, allData, thead, tbody);
                updatePaginationControls();

                // Recalculate stats
                setTimeout(() => {
                    calculateDynamicStats();
                }, 100);
            }
        }
    }

    // Close modals when clicking outside
    window.onclick = function(event) {
        const addBusinessModal = document.getElementById('addBusinessModal');
        const importModal = document.getElementById('importModal');
        const dynamicDataModal = document.getElementById('dynamicDataModal');

        if (event.target == addBusinessModal) {
            closeAddBusinessModal();
        }
        if (event.target == importModal) {
            closeImportModal();
        }
        if (event.target == dynamicDataModal) {
            closeDynamicDataModal();
        }
    }
</script>