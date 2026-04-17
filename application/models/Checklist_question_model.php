<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checklist_question_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_by_id($equipment_id) {
        $this->db->where('equipment_id', $equipment_id);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('checklist_questions');
        return $query->result_array();
    }
}
?>

