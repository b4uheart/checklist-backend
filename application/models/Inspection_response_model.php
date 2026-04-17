<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inspection_response_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function create($inspection_id, $question_id, $response, $remark = '', $image_url = '') {
        $data = array(
            'inspection_id' => $inspection_id,
            'question_id' => $question_id,
            'response' => $response,
            'remark' => $remark,
            'image_url' => $image_url,
            'created_at' => date('Y-m-d H:i:s')
        );

        return $this->db->insert('inspection_responses', $data);
    }

    public function bulk_create($inspection_id, $responses) {
        $data = array();
        foreach ($responses as $resp) {
            $data[] = array(
                'inspection_id' => $inspection_id,
                'question_id' => $resp['question_id'],
                'response' => $resp['response'],
                'remark' => isset($resp['remark']) ? $resp['remark'] : '',
                'image_url' => isset($resp['image_url']) ? $resp['image_url'] : '',
                'created_at' => date('Y-m-d H:i:s')
            );
        }
        $this->db->insert_batch('inspection_responses', $data);
        return count($responses);
    }

    public function get_by_inspection($inspection_id) {
        return $this->db
            ->select('inspection_responses.question_id, checklist_questions.question, inspection_responses.response, inspection_responses.remark, inspection_responses.image_url')
            ->from('inspection_responses')
            ->join('checklist_questions', 'checklist_questions.id = inspection_responses.question_id', 'left')
            ->where('inspection_responses.inspection_id', (int) $inspection_id)
            ->order_by('checklist_questions.order_index', 'ASC')
            ->order_by('inspection_responses.id', 'ASC')
            ->get()
            ->result_array();
    }

    public function get_answer_counts_by_inspection_ids($inspection_ids) {
        if (empty($inspection_ids)) {
            return array();
        }

        $rows = $this->db
            ->select('inspection_id, COUNT(*) AS answered_count', false)
            ->from('inspection_responses')
            ->where_in('inspection_id', $inspection_ids)
            ->group_by('inspection_id')
            ->get()
            ->result_array();

        $counts = array();
        foreach ($rows as $row) {
            $counts[(int) $row['inspection_id']] = (int) $row['answered_count'];
        }

        return $counts;
    }
}
?>
