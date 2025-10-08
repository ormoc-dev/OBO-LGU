<section class="section">
    <div class="section-header">
        <h2>Start New Mechanical Inspection</h2>
    </div>
    <form id="startInspectionForm" class="form">
        <div class="form-row">
            <label>Site/Facility</label>
            <input type="text" id="site" required>
        </div>
        <div class="form-row">
            <label>Inspection Type</label>
            <select id="inspectionType" required>
                <option value="">Select type</option>
                <option value="elevator">Elevator</option>
                <option value="escalator">Escalator</option>
                <option value="boiler">Boiler</option>
                <option value="pressure">Pressure Vessel</option>
            </select>
        </div>
        <div class="form-row">
            <label>Schedule</label>
            <input type="datetime-local" id="schedule" required>
        </div>
        <div class="form-row">
            <label>Google Maps Link</label>
            <input type="url" id="mapLink" placeholder="https://maps.google.com/?q=...">
        </div>
        <div class="form-row">
            <label>Notes</label>
            <textarea id="notes" rows="3" placeholder="Optional"></textarea>
        </div>
        <div class="form-actions">
            <button type="button" class="btn btn-secondary" onclick="navigateMech('dashboard')">Cancel</button>
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>
</section>