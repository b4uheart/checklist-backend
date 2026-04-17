<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checklist_question_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_by_id($equipment_id) {
        $this->db->where('equipment_id', $equipment_id);
        $this->db->order_by('order_index', 'ASC');
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('checklist_questions');
        return $query->result_array();
    }

    public function count_by_equipment_ids($equipment_ids) {
        if (empty($equipment_ids)) {
            return array();
        }

        $rows = $this->db
            ->select('equipment_id, COUNT(*) AS total_questions', false)
            ->from('checklist_questions')
            ->where_in('equipment_id', $equipment_ids)
            ->group_by('equipment_id')
            ->get()
            ->result_array();

        $counts = array();
        foreach ($rows as $row) {
            $counts[(int) $row['equipment_id']] = (int) $row['total_questions'];
        }

        return $counts;
    }
}
?>
