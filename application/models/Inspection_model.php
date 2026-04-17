<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inspection_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function create($equipment_id, $user_id) {
        $data = array(
            'equipment_id' => $equipment_id,
            'user_id' => $user_id,
            'status' => 'in_progress',
            'started_at' => date('Y-m-d H:i:s'),
            'sync_status' => 'synced'
        );

        $this->db->insert('inspections', $data);
        return (int) $this->db->insert_id();
    }

    public function count_completed_today() {
        return (int) $this->db
            ->where('status', 'completed')
            ->where('DATE(completed_at) =', date('Y-m-d'))
            ->count_all_results('inspections');
    }

    public function count_pending() {
        return (int) $this->db
            ->where('status !=', 'completed')
            ->count_all_results('inspections');
    }

    public function compliance_rate() {
        $result = $this->db
            ->select("SUM(CASE WHEN response = 'comply' THEN 1 ELSE 0 END) AS comply_count", false)
            ->select('COUNT(*) AS total_count', false)
            ->from('inspection_responses')
            ->get()
            ->row_array();

        $total = (int) ($result['total_count'] ?? 0);
        $comply = (int) ($result['comply_count'] ?? 0);

        if ($total === 0) {
            return 0;
        }

        return (int) round(($comply / $total) * 100);
    }

    public function get_recent_scans($limit = 10) {
        return $this->db
            ->select('inspections.id AS inspection_id, inspections.equipment_id, inspections.status, inspections.started_at, inspections.completed_at, equipment.name AS equipment_name, equipment.qr_code')
            ->from('inspections')
            ->join('equipment', 'equipment.id = inspections.equipment_id', 'left')
            ->order_by('COALESCE(inspections.completed_at, inspections.started_at)', 'DESC', false)
            ->limit((int) $limit)
            ->get()
            ->result_array();
    }

    public function get_history($filters = array()) {
        $page = max(1, (int) ($filters['page'] ?? 1));
        $limit = max(1, (int) ($filters['limit'] ?? 20));
        $offset = ($page - 1) * $limit;

        $base = $this->db
            ->from('inspections')
            ->join('equipment', 'equipment.id = inspections.equipment_id', 'left');

        if (!empty($filters['equipment_id'])) {
            $base->where('inspections.equipment_id', (int) $filters['equipment_id']);
        }

        if (!empty($filters['status'])) {
            $base->where('inspections.status', $filters['status']);
        }

        if (!empty($filters['date_from'])) {
            $base->where('DATE(inspections.completed_at) >=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $base->where('DATE(inspections.completed_at) <=', $filters['date_to']);
        }

        $count_query = clone $base;
        $total = (int) $count_query->count_all_results();

        $rows = $base
            ->select('inspections.id AS inspection_id, inspections.equipment_id, inspections.status, inspections.completed_at, equipment.name AS equipment_name, equipment.qr_code')
            ->order_by('inspections.completed_at', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->result_array();

        return array(
            'data' => $rows,
            'meta' => array(
                'page' => $page,
                'limit' => $limit,
                'total' => $total,
            ),
        );
    }

    public function get_detail($inspection_id) {
        return $this->db
            ->select('inspections.id AS inspection_id, inspections.completed_at, inspections.status, inspections.equipment_id, inspections.user_id, equipment.name AS equipment_name, equipment.qr_code, users.name AS inspector_name, users.email AS inspector_email')
            ->from('inspections')
            ->join('equipment', 'equipment.id = inspections.equipment_id', 'left')
            ->join('users', 'users.id = inspections.user_id', 'left')
            ->where('inspections.id', (int) $inspection_id)
            ->get()
            ->row_array();
    }
}
?>
