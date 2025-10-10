<?php
/**
 * Dynamic Inspection Manager
 * Handles all inspection types dynamically
 */

require_once __DIR__ . '/../../database/db.php';

class InspectionManager {
    private $pdo;
    
    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }
    
    /**
     * Create a new inspection
     */
    public function createInspection($inspectorId, $inspectorRole, $formData, $feeData = []) {
        try {
            $this->pdo->beginTransaction();
            
            // Generate unique inspection number
            $inspectionNumber = $this->generateInspectionNumber($inspectorRole);
            
            // Insert main inspection record
            $stmt = $this->pdo->prepare("
                INSERT INTO inspections (inspection_number, inspector_id, inspector_role, status) 
                VALUES (?, ?, ?, 'pending')
            ");
            $stmt->execute([$inspectionNumber, $inspectorId, $inspectorRole]);
            $inspectionId = $this->pdo->lastInsertId();
            
            // Store form data dynamically
            $this->storeFormData($inspectionId, $formData);
            
            // Store fee calculations
            if (!empty($feeData)) {
                $this->storeFeeData($inspectionId, $feeData);
            }
            
            // Add to history
            $this->addHistory($inspectionId, 'created', 'Inspection created', $inspectorId);
            
            $this->pdo->commit();
            
            return [
                'success' => true,
                'inspection_id' => $inspectionId,
                'inspection_number' => $inspectionNumber
            ];
            
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception('Failed to create inspection: ' . $e->getMessage());
        }
    }
    
    /**
     * Store form data dynamically
     */
    private function storeFormData($inspectionId, $formData) {
        $stmt = $this->pdo->prepare("
            INSERT INTO inspection_details (inspection_id, field_name, field_value, field_type) 
            VALUES (?, ?, ?, ?)
        ");
        
        foreach ($formData as $field => $value) {
            if (is_array($value)) {
                $value = json_encode($value);
                $type = 'json';
            } elseif (is_numeric($value)) {
                $type = 'number';
            } elseif (strtotime($value) !== false && (strpos($value, '-') !== false || strpos($value, '/') !== false)) {
                $type = 'date';
            } elseif (preg_match('/^\d{2}:\d{2}$/', $value)) {
                $type = 'time';
            } else {
                $type = 'text';
            }
            
            $stmt->execute([$inspectionId, $field, $value, $type]);
        }
    }
    
    /**
     * Store fee calculation data
     */
    private function storeFeeData($inspectionId, $feeData) {
        $stmt = $this->pdo->prepare("
            INSERT INTO inspection_fees (inspection_id, fee_category, fee_subcategory, quantity, unit_price, total_amount) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        
        foreach ($feeData as $category => $data) {
            if (is_array($data)) {
                foreach ($data as $subcategory => $feeInfo) {
                    if (isset($feeInfo['quantity']) && isset($feeInfo['unit_price'])) {
                        $totalAmount = $feeInfo['quantity'] * $feeInfo['unit_price'];
                        $stmt->execute([
                            $inspectionId,
                            $category,
                            $subcategory,
                            $feeInfo['quantity'],
                            $feeInfo['unit_price'],
                            $totalAmount
                        ]);
                    }
                }
            }
        }
    }
    
    /**
     * Get inspection by ID
     */
    public function getInspection($inspectionId) {
        $stmt = $this->pdo->prepare("
            SELECT i.*, u.name as inspector_name 
            FROM inspections i 
            JOIN users u ON i.inspector_id = u.id 
            WHERE i.id = ?
        ");
        $stmt->execute([$inspectionId]);
        $inspection = $stmt->fetch();
        
        if (!$inspection) {
            return null;
        }
        
        // Get form data
        $inspection['form_data'] = $this->getFormData($inspectionId);
        
        // Get fee data
        $inspection['fee_data'] = $this->getFeeData($inspectionId);
        
        return $inspection;
    }
    
    /**
     * Get form data for inspection
     */
    private function getFormData($inspectionId) {
        $stmt = $this->pdo->prepare("
            SELECT field_name, field_value, field_type 
            FROM inspection_details 
            WHERE inspection_id = ?
        ");
        $stmt->execute([$inspectionId]);
        $details = $stmt->fetchAll();
        
        $formData = [];
        foreach ($details as $detail) {
            $value = $detail['field_value'];
            if ($detail['field_type'] === 'json') {
                $value = json_decode($value, true);
            }
            $formData[$detail['field_name']] = $value;
        }
        
        return $formData;
    }
    
    /**
     * Get fee data for inspection
     */
    private function getFeeData($inspectionId) {
        $stmt = $this->pdo->prepare("
            SELECT fee_category, fee_subcategory, quantity, unit_price, total_amount 
            FROM inspection_fees 
            WHERE inspection_id = ?
        ");
        $stmt->execute([$inspectionId]);
        return $stmt->fetchAll();
    }
    
    /**
     * Get inspections by inspector
     */
    public function getInspectionsByInspector($inspectorId, $limit = 50, $offset = 0) {
        $stmt = $this->pdo->prepare("
            SELECT i.*, 
                   COUNT(id.id) as detail_count,
                   SUM(if.total_amount) as total_fees
            FROM inspections i 
            LEFT JOIN inspection_details id ON i.id = id.inspection_id
            LEFT JOIN inspection_fees if ON i.id = if.inspection_id
            WHERE i.inspector_id = ? 
            GROUP BY i.id
            ORDER BY i.created_at DESC 
            LIMIT ? OFFSET ?
        ");
        $stmt->execute([$inspectorId, $limit, $offset]);
        return $stmt->fetchAll();
    }
    
    /**
     * Update inspection status
     */
    public function updateStatus($inspectionId, $status, $userId) {
        $stmt = $this->pdo->prepare("
            UPDATE inspections 
            SET status = ?, updated_at = CURRENT_TIMESTAMP 
            WHERE id = ?
        ");
        $stmt->execute([$status, $inspectionId]);
        
        $this->addHistory($inspectionId, 'status_changed', "Status changed to {$status}", $userId);
        
        return $stmt->rowCount() > 0;
    }
    
    /**
     * Add history entry
     */
    private function addHistory($inspectionId, $action, $description, $userId) {
        $stmt = $this->pdo->prepare("
            INSERT INTO inspection_history (inspection_id, action, description, changed_by) 
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$inspectionId, $action, $description, $userId]);
    }
    
    /**
     * Generate unique inspection number
     */
    private function generateInspectionNumber($inspectorRole) {
        $prefix = strtoupper(substr($inspectorRole, 0, 3));
        $year = date('Y');
        $month = date('m');
        
        // Get last inspection number for this role this month
        $stmt = $this->pdo->prepare("
            SELECT inspection_number 
            FROM inspections 
            WHERE inspector_role = ? 
            AND inspection_number LIKE ? 
            ORDER BY inspection_number DESC 
            LIMIT 1
        ");
        $pattern = "{$prefix}-{$year}{$month}-%";
        $stmt->execute([$inspectorRole, $pattern]);
        $lastNumber = $stmt->fetchColumn();
        
        if ($lastNumber) {
            $lastSeq = (int)substr($lastNumber, -4);
            $newSeq = $lastSeq + 1;
        } else {
            $newSeq = 1;
        }
        
        return sprintf("%s-%s%s-%04d", $prefix, $year, $month, $newSeq);
    }
    
    /**
     * Get inspection statistics
     */
    public function getStatistics($inspectorId = null) {
        $whereClause = $inspectorId ? "WHERE inspector_id = ?" : "";
        $params = $inspectorId ? [$inspectorId] : [];
        
        $stmt = $this->pdo->prepare("
            SELECT 
                COUNT(*) as total_inspections,
                SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'in_progress' THEN 1 ELSE 0 END) as in_progress,
                SUM(CASE WHEN DATE(created_at) = CURDATE() THEN 1 ELSE 0 END) as today,
                SUM(CASE WHEN created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) THEN 1 ELSE 0 END) as this_week
            FROM inspections 
            {$whereClause}
        ");
        $stmt->execute($params);
        return $stmt->fetch();
    }
}
