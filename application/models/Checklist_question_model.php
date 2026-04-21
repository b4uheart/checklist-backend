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

    public function get_question($id, $equipment_id = null) {
        $this->db->where('id', $id);

        if ($equipment_id !== null) {
            $this->db->where('equipment_id', $equipment_id);
        }

        return $this->db->get('checklist_questions')->row_array();
    }

    public function create($data) {
        $this->db->insert('checklist_questions', $data);
        return $this->db->affected_rows() > 0;
    }

    public function update($id, $data, $equipment_id = null) {
        $this->db->where('id', $id);

        if ($equipment_id !== null) {
            $this->db->where('equipment_id', $equipment_id);
        }

        return $this->db->update('checklist_questions', $data);
    }

    public function delete($id, $equipment_id = null) {
        $this->db->where('id', $id);

        if ($equipment_id !== null) {
            $this->db->where('equipment_id', $equipment_id);
        }

        return $this->db->delete('checklist_questions');
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
