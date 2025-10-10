USE `obo_db`;

-- Create inspections table to store all inspection forms
CREATE TABLE IF NOT EXISTS `inspections` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `inspection_number` VARCHAR(50) NOT NULL UNIQUE,
  `inspector_id` INT UNSIGNED NOT NULL,
  `inspector_role` ENUM(
    'electrical/electronics', 
    'architectural', 
    'mechanical',
    'civil/structural',
    'line/grade',
    'sanitary/plumbing'
  ) NOT NULL,
  `status` ENUM('pending', 'in_progress', 'completed', 'failed', 'cancelled') NOT NULL DEFAULT 'pending',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_inspector_id` (`inspector_id`),
  KEY `idx_inspector_role` (`inspector_role`),
  KEY `idx_status` (`status`),
  KEY `idx_created_at` (`created_at`),
  FOREIGN KEY (`inspector_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create inspection_details table to store form data
CREATE TABLE IF NOT EXISTS `inspection_details` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `inspection_id` INT UNSIGNED NOT NULL,
  `field_name` VARCHAR(100) NOT NULL,
  `field_value` TEXT,
  `field_type` ENUM('text', 'number', 'date', 'time', 'select', 'textarea', 'json') NOT NULL DEFAULT 'text',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_inspection_id` (`inspection_id`),
  KEY `idx_field_name` (`field_name`),
  FOREIGN KEY (`inspection_id`) REFERENCES `inspections`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create inspection_fees table to store fee calculations
CREATE TABLE IF NOT EXISTS `inspection_fees` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `inspection_id` INT UNSIGNED NOT NULL,
  `fee_category` VARCHAR(100) NOT NULL,
  `fee_subcategory` VARCHAR(100),
  `quantity` DECIMAL(10,2) DEFAULT 0.00,
  `unit_price` DECIMAL(10,2) DEFAULT 0.00,
  `total_amount` DECIMAL(10,2) DEFAULT 0.00,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_inspection_id` (`inspection_id`),
  KEY `idx_fee_category` (`fee_category`),
  FOREIGN KEY (`inspection_id`) REFERENCES `inspections`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create inspection_attachments table for file uploads
CREATE TABLE IF NOT EXISTS `inspection_attachments` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `inspection_id` INT UNSIGNED NOT NULL,
  `file_name` VARCHAR(255) NOT NULL,
  `file_path` VARCHAR(500) NOT NULL,
  `file_type` VARCHAR(100) NOT NULL,
  `file_size` INT UNSIGNED NOT NULL,
  `uploaded_by` INT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_inspection_id` (`inspection_id`),
  KEY `idx_uploaded_by` (`uploaded_by`),
  FOREIGN KEY (`inspection_id`) REFERENCES `inspections`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`uploaded_by`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create inspection_history table for audit trail
CREATE TABLE IF NOT EXISTS `inspection_history` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `inspection_id` INT UNSIGNED NOT NULL,
  `action` VARCHAR(50) NOT NULL,
  `description` TEXT,
  `changed_by` INT UNSIGNED NOT NULL,
  `changed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_inspection_id` (`inspection_id`),
  KEY `idx_changed_by` (`changed_by`),
  KEY `idx_changed_at` (`changed_at`),
  FOREIGN KEY (`inspection_id`) REFERENCES `inspections`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`changed_by`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
