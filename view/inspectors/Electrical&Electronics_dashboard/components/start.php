<section class="section">
    <div class="section-header">
        <h2><i class="fas fa-bolt"></i> Electrical & Electronics Inspection Form</h2>
        <p class="section-subtitle">Complete inspection details and fee calculation</p>
    </div>

    <form id="startInspectionForm" class="professional-form">
        <!-- Application Information Section -->
        <div class="form-section">
            <div class="section-title">
                <h3><i class="fas fa-file-alt"></i> Application Information</h3>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="owner"><i class="fas fa-user"></i> Owner/Firm/Applicant</label>
                    <input type="text" id="owner" required placeholder="Enter full name or company name">
                </div>
                <div class="form-group">
                    <label for="businessName"><i class="fas fa-building"></i> Business Name</label>
                    <input type="text" id="businessName" required placeholder="Enter business name">
                </div>
                <div class="form-group full-width">
                    <label for="location"><i class="fas fa-map-marker-alt"></i> Building/Structure Location</label>
                    <input type="text" id="location" required placeholder="Enter complete address">
                </div>
                <div class="form-group">
                    <label for="applicationType"><i class="fas fa-clipboard-list"></i> Type of Application</label>
                    <input type="text" id="applicationType" value="Annual Inspection" readonly class="readonly-field">
                </div>
                <div class="form-group">
                    <label for="lcNumber"><i class="fas fa-id-card"></i> L/C No</label>
                    <input type="text" id="lcNumber" required placeholder="Enter L/C number">
                </div>
                <div class="form-group">
                    <label for="mbNumber"><i class="fas fa-hashtag"></i> MB No</label>
                    <input type="text" id="mbNumber" required placeholder="Enter MB number">
                </div>
                <div class="form-group">
                    <label for="applicationDate"><i class="fas fa-calendar-plus"></i> Date of Application</label>
                    <input type="date" id="applicationDate" required>
                </div>
                <div class="form-group">
                    <label for="returnDate"><i class="fas fa-calendar-check"></i> Date Returned to Application</label>
                    <input type="date" id="returnDate">
                </div>
            </div>
        </div>

        <!-- Inspection Details Section -->
        <div class="form-section">
            <div class="section-title">
                <h3><i class="fas fa-clipboard-check"></i> Inspection Details</h3>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="timeIn"><i class="fas fa-clock"></i> Time In</label>
                    <input type="time" id="timeIn" required>
                </div>
                <div class="form-group">
                    <label for="timeOut"><i class="fas fa-clock"></i> Time Out</label>
                    <input type="time" id="timeOut" required>
                </div>
                <div class="form-group">
                    <label for="inspectionDate"><i class="fas fa-calendar"></i> Date</label>
                    <input type="date" id="inspectionDate" required>
                </div>
                <div class="form-group">
                    <label for="assessment"><i class="fas fa-check-circle"></i> Assessment</label>
                    <select id="assessment" required>
                        <option value="">Select Assessment</option>
                        <option value="passed">Passed</option>
                        <option value="failed">Failed</option>
                        <option value="conditional">Conditional</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Electrical & Electronics Inspection Fees Section -->
        <div class="form-section">
            <div class="section-title">
                <h3><i class="fas fa-calculator"></i> Electrical & Electronics Inspection Fees</h3>
                <p class="section-description">Calculate fees based on electrical load and equipment specifications</p>
            </div>

            <!-- Fee Tabs -->
            <div class="fee-tabs">
                <button class="tab-btn active" data-tab="electrical">Electrical Systems</button>
                <button class="tab-btn" data-tab="electronics">Electronics Systems</button>
                <button class="tab-btn" data-tab="communication">Communication</button>
                <button class="tab-btn" data-tab="miscellaneous">Miscellaneous</button>
            </div>

            <div class="fee-categories">
                <!-- Electrical Systems Tab -->
                <div class="tab-content active" id="electrical">
                    <!-- Total Connected Load -->
                    <div class="fee-category">
                    <div class="category-header">
                            <h4><i class="fas fa-plug"></i> Total Connected Load</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                                <label for="connectedLoadKva">Connected Load (kVA)</label>
                                <input type="number" id="connectedLoadKva" min="0" step="0.1" placeholder="Enter kVA rating">
                        </div>
                        <div class="form-group">
                                <label for="connectedLoadCategory">Category</label>
                                <select id="connectedLoadCategory">
                                <option value="">Select Category</option>
                                    <option value="up_to_5">5 kVA or less</option>
                                    <option value="5_to_50">Over 5 kVA up to 50 kVA</option>
                                    <option value="50_to_300">Over 50 kVA up to 300 kVA</option>
                                    <option value="300_to_1500">Over 300 kVA up to 1,500 kVA</option>
                                    <option value="1500_to_6000">Over 1,500 kVA up to 6,000 kVA</option>
                                    <option value="above_6000">Over 6,000 kVA</option>
                            </select>
                            </div>
                    </div>
                </div>

                    <!-- Transformer/UPS/Generator -->
                <div class="fee-category">
                    <div class="category-header">
                            <h4><i class="fas fa-bolt"></i> Transformer/UPS/Power Generator</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                                <label for="transformerKva">Capacity (kVA)</label>
                                <input type="number" id="transformerKva" min="0" step="0.1" placeholder="Enter kVA rating">
                            </div>
                            <div class="form-group">
                                <label for="transformerCategory">Category</label>
                                <select id="transformerCategory">
                                    <option value="">Select Category</option>
                                    <option value="up_to_5">5 kVA or less</option>
                                    <option value="5_to_50">Over 5 kVA up to 50 kVA</option>
                                    <option value="50_to_300">Over 50 kVA up to 300 kVA</option>
                                    <option value="300_to_1500">Over 300 kVA up to 1,500 kVA</option>
                                    <option value="1500_to_6000">Over 1,500 kVA up to 6,000 kVA</option>
                                    <option value="above_6000">Over 6,000 kVA</option>
                            </select>
                        </div>
                    </div>
                </div>

                    <!-- Pole/Attachment Location Plan -->
                <div class="fee-category">
                    <div class="category-header">
                            <h4><i class="fas fa-map-pin"></i> Pole/Attachment Location Plan</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                                <label for="powerSupplyPoles">Power Supply Poles</label>
                                <input type="number" id="powerSupplyPoles" min="0" placeholder="Number of poles">
                        </div>
                        <div class="form-group">
                                <label for="guyingAttachments">Guying Attachments</label>
                                <input type="number" id="guyingAttachments" min="0" placeholder="Number of attachments">
                            </div>
                </div>
                </div>

                    <!-- Electric Meter Fees -->
                <div class="fee-category">
                    <div class="category-header">
                            <h4><i class="fas fa-tachometer-alt"></i> Electric Meter Fees</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                                <label for="meterType">Meter Type</label>
                                <select id="meterType">
                                <option value="">Select Type</option>
                                    <option value="residential">Residential</option>
                                    <option value="commercial">Commercial/Industrial</option>
                                    <option value="institutional">Institutional</option>
                            </select>
                        </div>
                        <div class="form-group">
                                <label for="meterCount">Number of Meters</label>
                                <input type="number" id="meterCount" min="0" placeholder="Number of meters">
                        </div>
                        </div>
                    </div>
                </div>

                <!-- Electronics Systems Tab -->
                <div class="tab-content" id="electronics">
                    <!-- Switching and Communication Systems -->
                <div class="fee-category">
                    <div class="category-header">
                            <h4><i class="fas fa-network-wired"></i> Switching and Communication Systems</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                                <label for="switchingPorts">Number of Ports</label>
                                <input type="number" id="switchingPorts" min="0" placeholder="Number of ports">
                    </div>
                </div>
                </div>

                    <!-- Broadcast & Communication Stations -->
                <div class="fee-category">
                    <div class="category-header">
                            <h4><i class="fas fa-broadcast-tower"></i> Broadcast & Communication Stations</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                                <label for="broadcastLocations">Number of Locations</label>
                                <input type="number" id="broadcastLocations" min="0" placeholder="Number of locations">
                        </div>
                    </div>
                </div>

                    <!-- Electronic Dispensing & Vending Machines -->
                <div class="fee-category">
                    <div class="category-header">
                            <h4><i class="fas fa-vending-machine"></i> Electronic Dispensing & Vending Machines</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                                <label for="vendingMachines">Number of Units</label>
                                <input type="number" id="vendingMachines" min="0" placeholder="Number of units">
                            </div>
                </div>
                </div>

                    <!-- Electronics & Communications Outlets -->
                <div class="fee-category">
                    <div class="category-header">
                            <h4><i class="fas fa-plug"></i> Electronics & Communications Outlets</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                                <label for="electronicsOutlets">Number of Outlets</label>
                                <input type="number" id="electronicsOutlets" min="0" placeholder="Number of outlets">
                            </div>
                    </div>
                </div>

                    <!-- Security & Control Systems -->
                <div class="fee-category">
                    <div class="category-header">
                            <h4><i class="fas fa-shield-alt"></i> Security & Control Systems</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                                <label for="securityTerminations">Number of Terminations</label>
                                <input type="number" id="securityTerminations" min="0" placeholder="Number of terminations">
                        </div>
                        </div>
                    </div>
                </div>

                <!-- Communication Tab -->
                <div class="tab-content" id="communication">
                    <!-- Studios & Production Facilities -->
                <div class="fee-category">
                    <div class="category-header">
                            <h4><i class="fas fa-video"></i> Studios & Production Facilities</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                                <label for="studioLocations">Number of Locations</label>
                                <input type="number" id="studioLocations" min="0" placeholder="Number of locations">
                        </div>
                    </div>
                </div>

                    <!-- Antenna Towers/Masts -->
                <div class="fee-category">
                    <div class="category-header">
                            <h4><i class="fas fa-satellite-dish"></i> Antenna Towers/Masts</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                                <label for="antennaStructures">Number of Structures</label>
                                <input type="number" id="antennaStructures" min="0" placeholder="Number of structures">
                            </div>
                </div>
                </div>

                    <!-- Electronic Signages & Display Systems -->
                <div class="fee-category">
                    <div class="category-header">
                            <h4><i class="fas fa-tv"></i> Electronic Signages & Display Systems</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                                <label for="electronicSignages">Number of Units</label>
                                <input type="number" id="electronicSignages" min="0" placeholder="Number of units">
                        </div>
                    </div>
                </div>

                    <!-- Poles and Attachments -->
                <div class="fee-category">
                    <div class="category-header">
                            <h4><i class="fas fa-pole"></i> Poles and Attachments</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                                <label for="poleCount">Number of Poles</label>
                                <input type="number" id="poleCount" min="0" placeholder="Number of poles">
                        </div>
                        <div class="form-group">
                                <label for="attachmentCount">Number of Attachments</label>
                                <input type="number" id="attachmentCount" min="0" placeholder="Number of attachments">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Miscellaneous Tab -->
                <div class="tab-content" id="miscellaneous">
                    <!-- Other Electronic Devices -->
                <div class="fee-category">
                    <div class="category-header">
                            <h4><i class="fas fa-microchip"></i> Other Electronic Devices</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                                <label for="otherDevices">Number of Units</label>
                                <input type="number" id="otherDevices" min="0" placeholder="Number of units">
                        </div>
                    </div>
                </div>
                </div>
            </div>

            <!-- Fee Calculation Display -->
            <div class="fee-summary">
                <div class="fee-display">
                    <label for="calculatedFee"><i class="fas fa-money-bill-wave"></i> Total Calculated Fee</label>
                    <div class="fee-input-group">
                        <span class="currency-symbol">₱</span>
                        <input type="text" id="calculatedFee" readonly placeholder="0.00" class="fee-input">
                    </div>
                    <button type="button" class="btn btn-small" onclick="window.calculateFees()" style="margin-top: 10px;">
                        <i class="fas fa-calculator"></i> Recalculate
                    </button>
                </div>
            </div>
        </div>

        <!-- Additional Information Section -->
        <div class="form-section">
            <div class="section-title">
                <h3><i class="fas fa-comments"></i> Additional Information</h3>
            </div>
            <div class="form-grid">
                <div class="form-group full-width">
                    <label for="remarks"><i class="fas fa-clipboard-list"></i> Inspection Remarks</label>
                    <textarea id="remarks" rows="4" placeholder="Enter detailed inspection remarks and findings..." required></textarea>
                </div>
                <div class="form-group full-width">
                    <label for="notes"><i class="fas fa-sticky-note"></i> Additional Notes</label>
                    <textarea id="notes" rows="3" placeholder="Any additional notes or comments (optional)"></textarea>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <button type="button" class="btn btn-secondary" onclick="resetForm()">
                <i class="fas fa-undo"></i> Reset Form
            </button>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Create Inspection
            </button>
        </div>

    </form>
    </section>

    <style>
    /* Tab Styles */
    .fee-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 0.5rem;
    }

    .tab-btn {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px 8px 0 0;
        padding: 0.75rem 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
        color: #6c757d;
        border-bottom: none;
        position: relative;
    }

    .tab-btn:hover {
        background: #e9ecef;
        color: #495057;
    }

    .tab-btn.active {
        background: #007bff;
        color: white;
        border-color: #007bff;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
    }

    .tab-content {
        display: none;
        animation: fadeIn 0.3s ease-in-out;
    }

    .tab-content.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Responsive tabs */
    @media (max-width: 768px) {
        .fee-tabs {
            flex-direction: column;
        }
        
        .tab-btn {
            border-radius: 8px;
            margin-bottom: 0.25rem;
        }
    }
    /* Professional Form Styling */
    .professional-form {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        padding: 2rem;
        margin: 1rem 0;
    }

    .section-header {
        text-align: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e9ecef;
    }

    .section-header h2 {
        color: #2c3e50;
        font-size: 1.8rem;
        font-weight: 600;
        margin: 0 0 0.5rem 0;
    }

    .section-header h2 i {
        color: #3498db;
        margin-right: 0.5rem;
    }

    .section-subtitle {
        color: #6c757d;
        font-size: 1rem;
        margin: 0;
    }

    .form-section {
        margin-bottom: 2.5rem;
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1.5rem;
        border-left: 4px solid #3498db;
    }

    .section-title {
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #dee2e6;
    }

    .section-title h3 {
        color: #2c3e50;
        font-size: 1.3rem;
        font-weight: 600;
        margin: 0;
    }

    .section-title h3 i {
        color: #3498db;
        margin-right: 0.5rem;
    }

    .section-description {
        color: #6c757d;
        font-size: 0.9rem;
        margin: 0.5rem 0 0 0;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-group label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
    }

    .form-group label i {
        color: #3498db;
        margin-right: 0.5rem;
        width: 16px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        padding: 0.75rem;
        border: 2px solid #e9ecef;
        border-radius: 6px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        background: #ffffff;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #3498db;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
    }

    .readonly-field {
        background-color: #f8f9fa !important;
        color: #6c757d !important;
        cursor: not-allowed;
    }

    .fee-categories {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .fee-category {
        background: #ffffff;
        border-radius: 8px;
        padding: 1.5rem;
        border: 1px solid #e9ecef;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .category-header {
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e9ecef;
    }

    .category-header h4 {
        color: #2c3e50;
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
    }

    .category-header h4 i {
        color: #3498db;
        margin-right: 0.5rem;
    }

    .fee-summary {
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: white;
        padding: 1.5rem;
        border-radius: 8px;
        margin-top: 1.5rem;
    }

    .fee-display {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .fee-display label {
        color: white;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .fee-input-group {
        display: flex;
        align-items: center;
        background: white;
        border-radius: 6px;
        padding: 0.5rem;
        min-width: 200px;
    }

    .currency-symbol {
        color: #2c3e50;
        font-weight: bold;
        font-size: 1.2rem;
        margin-right: 0.5rem;
    }

    .fee-input {
        border: none !important;
        background: transparent !important;
        font-size: 1.5rem;
        font-weight: bold;
        color: #2c3e50;
        text-align: center;
        box-shadow: none !important;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e9ecef;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: white;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #2980b9, #1f618d);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
    }

    .btn-small {
        padding: 0.5rem 1rem;
        font-size: 0.8rem;
        background: #17a2b8;
        color: white;
    }

    .btn-small:hover {
        background: #138496;
        transform: translateY(-1px);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }

    /* Animation for form sections */
    .form-section {
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>