// Dashboard metrics fetch & render

function formatNumber(num) {
    try { return Number(num).toLocaleString(); } catch (_) { return String(num); }
}

function renderDashboardMetrics(data) {
    const m = data && data.data ? data.data : {};
    const totalUsers = document.getElementById('metricTotalUsers');
    const activeInspections = document.getElementById('metricActiveInspections');
    const completedReports = document.getElementById('metricCompletedReports');
    const pendingApprovals = document.getElementById('metricPendingApprovals');

    if (totalUsers) totalUsers.textContent = formatNumber(m.total_users || 0);
    if (activeInspections) activeInspections.textContent = formatNumber(m.active_inspections || 0);
    if (completedReports) completedReports.textContent = formatNumber(m.completed_reports || 0);
    if (pendingApprovals) pendingApprovals.textContent = formatNumber(m.pending_approvals || 0);
}

function loadDashboardMetrics() {
    fetch('../../api/dashboard/metrics.php')
        .then(r => r.json())
        .then(res => {
            if (!res.success) throw new Error(res.message || 'Failed to load metrics');
            renderDashboardMetrics(res);
        })
        .catch(err => {
            console.error('Failed to load dashboard metrics', err);
        });
}

// expose
window.loadDashboardMetrics = loadDashboardMetrics;
window.renderDashboardMetrics = renderDashboardMetrics;


