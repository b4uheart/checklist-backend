<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inspection_response_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function create($inspection_id, $question_id, $response, $remark = '', $image_url = '') {
        // Generate UUID
        $uuid = bin2hex(random_bytes(16));
        
        $data = array(
            'id' => $uuid,
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
            $uuid = bin2hex(random_bytes(16));
            $data[] = array(
                'id' => $uuid,
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
}
?>

