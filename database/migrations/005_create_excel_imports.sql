USE `obo_db`;
-- Create excel_imports table for tracking import sessions
CREATE TABLE IF NOT EXISTS excel_imports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) NOT NULL,
    original_filename VARCHAR(255) NOT NULL,
    file_size INT NOT NULL,
    total_rows INT DEFAULT 0,
    processed_rows INT DEFAULT 0,
    status ENUM('uploaded', 'processing', 'completed', 'failed') DEFAULT 'uploaded',
    error_message TEXT NULL,
    created_by INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
);

-- Create excel_import_data table for storing imported data dynamically
CREATE TABLE IF NOT EXISTS excel_import_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    import_id INT NOT NULL,
    row_number INT NOT NULL,
    column_name VARCHAR(100) NOT NULL,
    column_value TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (import_id) REFERENCES excel_imports(id) ON DELETE CASCADE,
    INDEX idx_import_row (import_id, row_number),
    INDEX idx_import_column (import_id, column_name)
);

-- Create excel_import_columns table for tracking column structure
CREATE TABLE IF NOT EXISTS excel_import_columns (
    id INT AUTO_INCREMENT PRIMARY KEY,
    import_id INT NOT NULL,
    column_index INT NOT NULL,
    column_name VARCHAR(100) NOT NULL,
    column_type ENUM('text', 'number', 'date', 'boolean') DEFAULT 'text',
    is_required BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (import_id) REFERENCES excel_imports(id) ON DELETE CASCADE,
    UNIQUE KEY unique_import_column (import_id, column_index)
);
