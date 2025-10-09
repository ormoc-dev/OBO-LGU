<section class="section">
    <div class="section-header">
        <h2><i class="fas fa-cogs"></i> Mechanical Inspection Form</h2>
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
                    <label for="assessment"><i class="fas fa-check-circle"></i> Assessment</label>
                    <select id="assessment" required>
                        <option value="">Select Assessment</option>
                        <option value="passed">✅ Passed</option>
                        <option value="failed">❌ Failed</option>
                        <option value="conditional">⚠️ Conditional</option>
                        <option value="pending">⏳ Pending</option>
            </select>
        </div>
            </div>
        </div>
        
        <!-- Mechanical Inspection Fees Section -->
        <div class="form-section">
            <div class="section-title">
                <h3><i class="fas fa-calculator"></i> Mechanical Inspection Fees</h3>
                <p class="section-description">Calculate fees based on equipment specifications</p>
            </div>
            
            <div class="fee-categories">
                <!-- Refrigeration & Ice Plant -->
                <div class="fee-category">
                    <div class="category-header">
                        <h4><i class="fas fa-snowflake"></i> Refrigeration & Ice Plant</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="refrigerationTons">Tonnage</label>
                            <input type="number" id="refrigerationTons" min="0" step="0.1" placeholder="Enter tonnage">
                        </div>
                        <div class="form-group">
                            <label for="refrigerationCategory">Category</label>
                            <select id="refrigerationCategory">
                                <option value="">Select Category</option>
                                <option value="up_to_100">Up to 100 Tons</option>
                                <option value="100_to_150">Above 100 Tons up to 150 Tons</option>
                                <option value="150_to_300">Above 150 Tons up to 300 Tons</option>
                                <option value="300_to_500">Above 300 Tons up to 500 Tons</option>
                                <option value="above_500">Above 500 Tons</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Air Conditioning System -->
                <div class="fee-category">
                    <div class="category-header">
                        <h4><i class="fas fa-wind"></i> Air Conditioning System</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="acType">Type</label>
                            <select id="acType">
                                <option value="">Select Type</option>
                                <option value="window">Window Type ACU (per Unit)</option>
                                <option value="packaged">Packaged/Centralized AC (per Ton)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="acUnits">Units/Tons</label>
                            <input type="number" id="acUnits" min="0" placeholder="Number of units or tons">
                        </div>
                    </div>
                </div>
                
                <!-- Mechanical Ventilation -->
                <div class="fee-category">
                    <div class="category-header">
                        <h4><i class="fas fa-fan"></i> Mechanical Ventilation</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="ventilationKw">Power Rating (kW)</label>
                            <input type="number" id="ventilationKw" min="0" step="0.1" placeholder="Enter kW rating">
                        </div>
                        <div class="form-group">
                            <label for="ventilationCategory">Category</label>
                            <select id="ventilationCategory">
                                <option value="">Select Category</option>
                                <option value="up_to_1">Up to 1kW</option>
                                <option value="1_to_7_5">Above 1kW to 7.5kW</option>
                                <option value="above_7_5">Above 7.5kW</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Escalators & Moving Walks -->
                <div class="fee-category">
                    <div class="category-header">
                        <h4><i class="fas fa-walking"></i> Escalators & Moving Walks</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="escalatorType">Type</label>
                            <select id="escalatorType">
                                <option value="">Select Type</option>
                                <option value="escalator">Escalator & Moving Walks (per Unit)</option>
                                <option value="funicular">Funicular (per kW)</option>
                                <option value="cable_car">Cable Car (per kW)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="escalatorUnits">Units/kW</label>
                            <input type="number" id="escalatorUnits" min="0" placeholder="Number of units or kW">
                        </div>
                        <div class="form-group">
                            <label for="escalatorMeters">Lineal Meters</label>
                            <input type="number" id="escalatorMeters" min="0" step="0.1" placeholder="Lineal meters (if applicable)">
                        </div>
                    </div>
                </div>
                
                <!-- Elevators -->
                <div class="fee-category">
                    <div class="category-header">
                        <h4><i class="fas fa-elevator"></i> Elevators</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="elevatorType">Type</label>
                            <select id="elevatorType">
                                <option value="">Select Type</option>
                                <option value="passenger">Passenger Elevators</option>
                                <option value="freight">Freight Elevators</option>
                                <option value="dumbwaiter">Motor-driven Dumbwaiters</option>
                                <option value="construction">Construction Elevators</option>
                                <option value="car">Car Elevators</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="elevatorUnits">Number of Units</label>
                            <input type="number" id="elevatorUnits" min="0" placeholder="Number of units">
                        </div>
                        <div class="form-group">
                            <label for="elevatorLandings">Landings Above 5</label>
                            <input type="number" id="elevatorLandings" min="0" placeholder="Number of landings above 5">
                        </div>
                    </div>
                </div>
                
                <!-- Steam Boilers -->
                <div class="fee-category">
                    <div class="category-header">
                        <h4><i class="fas fa-fire"></i> Steam Boilers</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="boilerKw">Power Rating (kW)</label>
                            <input type="number" id="boilerKw" min="0" step="0.1" placeholder="Enter kW rating">
                        </div>
                        <div class="form-group">
                            <label for="boilerUnits">Number of Units</label>
                            <input type="number" id="boilerUnits" min="0" placeholder="Number of units">
                        </div>
                    </div>
                </div>
                
                <!-- Pressurized Water Heaters -->
                <div class="fee-category">
                    <div class="category-header">
                        <h4><i class="fas fa-thermometer-half"></i> Pressurized Water Heaters</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="waterHeaterUnits">Number of Units</label>
                            <input type="number" id="waterHeaterUnits" min="0" placeholder="Number of units">
                        </div>
                    </div>
                </div>
                
                <!-- Automatic Fire Extinguishers -->
                <div class="fee-category">
                    <div class="category-header">
                        <h4><i class="fas fa-fire-extinguisher"></i> Automatic Fire Extinguishers</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="sprinklerHeads">Number of Sprinkler Heads</label>
                            <input type="number" id="sprinklerHeads" min="0" placeholder="Number of sprinkler heads">
                        </div>
                    </div>
                </div>
                
                <!-- Water/Sump/Sewage Pumps -->
                <div class="fee-category">
                    <div class="category-header">
                        <h4><i class="fas fa-tint"></i> Water/Sump/Sewage Pumps</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="pumpKw">Power Rating (kW)</label>
                            <input type="number" id="pumpKw" min="0" step="0.1" placeholder="Enter kW rating">
                        </div>
                        <div class="form-group">
                            <label for="pumpUnits">Number of Units</label>
                            <input type="number" id="pumpUnits" min="0" placeholder="Number of units">
                        </div>
                    </div>
                </div>
                
                <!-- Diesel/Gasoline Engines & Generators -->
                <div class="fee-category">
                    <div class="category-header">
                        <h4><i class="fas fa-cog"></i> Diesel/Gasoline Engines & Generators</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="generatorKw">Power Rating (kW)</label>
                            <input type="number" id="generatorKw" min="0" step="0.1" placeholder="Enter kW rating">
                        </div>
                        <div class="form-group">
                            <label for="generatorUnits">Number of Units</label>
                            <input type="number" id="generatorUnits" min="0" placeholder="Number of units">
                        </div>
                    </div>
                </div>
                
                <!-- Compressed Air/Vacuum/Gases -->
                <div class="fee-category">
                    <div class="category-header">
                        <h4><i class="fas fa-wind"></i> Compressed Air/Vacuum/Gases</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="gasOutlets">Number of Outlets</label>
                            <input type="number" id="gasOutlets" min="0" placeholder="Number of outlets">
                        </div>
                    </div>
                </div>
                
                <!-- Power Piping -->
                <div class="fee-category">
                    <div class="category-header">
                        <h4><i class="fas fa-pipe"></i> Power Piping</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="pipingMeters">Lineal Meters</label>
                            <input type="number" id="pipingMeters" min="0" step="0.1" placeholder="Lineal meters">
                        </div>
                        <div class="form-group">
                            <label for="pipingVolume">Volume (cu.m.)</label>
                            <input type="number" id="pipingVolume" min="0" step="0.1" placeholder="Volume in cubic meters">
                        </div>
                    </div>
                </div>
                
                <!-- Other Internal Combustion Engines -->
                <div class="fee-category">
                    <div class="category-header">
                        <h4><i class="fas fa-truck"></i> Other Internal Combustion Engines</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="iceKw">Power Rating (kW)</label>
                            <input type="number" id="iceKw" min="0" step="0.1" placeholder="Enter kW rating">
                        </div>
                        <div class="form-group">
                            <label for="iceUnits">Number of Units</label>
                            <input type="number" id="iceUnits" min="0" placeholder="Number of units">
                        </div>
                    </div>
                </div>
                
                <!-- Other Machinery/Equipment -->
                <div class="fee-category">
                    <div class="category-header">
                        <h4><i class="fas fa-industry"></i> Other Machinery/Equipment</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="machineryKw">Power Rating (kW)</label>
                            <input type="number" id="machineryKw" min="0" step="0.1" placeholder="Enter kW rating">
                        </div>
                        <div class="form-group">
                            <label for="machineryUnits">Number of Units</label>
                            <input type="number" id="machineryUnits" min="0" placeholder="Number of units">
                        </div>
                    </div>
                </div>
                
                <!-- Pressure Vessels -->
                <div class="fee-category">
                    <div class="category-header">
                        <h4><i class="fas fa-drum"></i> Pressure Vessels</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="pressureVesselVolume">Volume (cu.m.)</label>
                            <input type="number" id="pressureVesselVolume" min="0" step="0.1" placeholder="Volume in cubic meters">
                        </div>
                    </div>
                </div>
                
                <!-- Pneumatic Tubes/Conveyors -->
                <div class="fee-category">
                    <div class="category-header">
                        <h4><i class="fas fa-conveyor-belt"></i> Pneumatic Tubes/Conveyors</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="conveyorMeters">Lineal Meters</label>
                            <input type="number" id="conveyorMeters" min="0" step="0.1" placeholder="Lineal meters">
                        </div>
                    </div>
                </div>
                
                <!-- Weighing Scale Structure -->
                <div class="fee-category">
                    <div class="category-header">
                        <h4><i class="fas fa-weight"></i> Weighing Scale Structure</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="scaleTons">Weight (Tons)</label>
                            <input type="number" id="scaleTons" min="0" step="0.1" placeholder="Weight in tons">
                        </div>
                    </div>
                </div>
                
                <!-- Pressure Gauges Testing -->
                <div class="fee-category">
                    <div class="category-header">
                        <h4><i class="fas fa-gauge"></i> Pressure Gauges Testing</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="pressureGauges">Number of Units</label>
                            <input type="number" id="pressureGauges" min="0" placeholder="Number of pressure gauges">
                        </div>
                    </div>
                </div>
                
                <!-- Gas Meters -->
                <div class="fee-category">
                    <div class="category-header">
                        <h4><i class="fas fa-gas-pump"></i> Gas Meters</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="gasMeters">Number of Gas Meters</label>
                            <input type="number" id="gasMeters" min="0" placeholder="Number of gas meters">
                        </div>
                    </div>
                </div>
                
                <!-- Mechanical Rides -->
                <div class="fee-category">
                    <div class="category-header">
                        <h4><i class="fas fa-ferris-wheel"></i> Mechanical Rides</h4>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="mechanicalRides">Number of Units</label>
                            <input type="number" id="mechanicalRides" min="0" placeholder="Number of mechanical rides">
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
