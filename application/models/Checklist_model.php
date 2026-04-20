<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checklist_model extends CI_Model
{
    public function get_month_data($equipment_id, $year, $month)
    {
        $this->db->select('
        inspection_responses.question_id,
        inspection_responses.response,
        DATE(inspections.completed_at) as inspection_date
    ');

        $this->db->from('inspection_responses');
        $this->db->join('inspections', 'inspections.id = inspection_responses.inspection_id');

        $this->db->where('inspections.equipment_id', $equipment_id);
        $this->db->where('inspections.status', 'completed');

        // Filter by year & month
        $this->db->where('YEAR(inspections.completed_at)', $year);
        $this->db->where('MONTH(inspections.completed_at)', $month);

        $query = $this->db->get();

        $result = [];

        foreach ($query->result_array() as $row) {

            $day = date('j', strtotime($row['inspection_date'])); // 1–31
            $question_id = $row['question_id'];

            // ✅ USE ID INSTEAD OF QUESTION TEXT
            $result[$question_id][$day] = $row['response'];
        }

        return $result;
    }


    public function get_questions($equipment_id)
    {
        return $this->db
            ->select('id, question')
            ->where('equipment_id', $equipment_id)
            ->order_by('order_index', 'ASC')
            ->get('checklist_questions')
            ->result_array();
    }
}