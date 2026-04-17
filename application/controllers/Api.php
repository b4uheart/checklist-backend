<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller
{

    protected $user_id;

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array(
            'Equipment_model',
            'Checklist_question_model',
            'Inspection_model',
            'Inspection_response_model',
            'User_model'
        ));

        $this->output->set_content_type('application/json');

        // Get Authorization header
        $headers = apache_request_headers();
        $auth_header = $headers['authorization'] ?? '';

        file_put_contents("headers_debug.txt", $auth_header);
        // echo "<pre>";
        //  echo json_encode($auth_header);
        //  die;
        

        if (strpos($auth_header, 'Bearer ') === 0) {
            $token = substr($auth_header, 7);

            $decoded = $this->jwt_lib->decode($token);
            
            if ($decoded && isset($decoded->user_id)) {
                // ✅ Store in memory (stateless)
                $this->user_id = $decoded->user_id;
                return;
            }
        }

        // Unauthorized
        $this->output->set_status_header(401);
        echo json_encode([
            'success' => false,
            'error' => 'Unauthorized. Valid Bearer token required.'
        ]);
        exit;
    }

    public function equipment_qr($qr_code)
    {

        $equipment = $this->Equipment_model->get_by_qr($qr_code);
        if ($equipment) {
            echo json_encode(array('success' => true, 'data' => $equipment));
        } else {
            $this->output->set_status_header(404);
            echo json_encode(array('success' => false, 'error' => 'Equipment not found'));
        }
    }

    public function questions($equipment_id)
    {
        $questions = $this->Checklist_question_model->get_by_id($equipment_id);
        echo json_encode(array('success' => true, 'data' => $questions));
    }

    public function save_inspection()
    {
        $input = json_decode($this->input->raw_input_stream, true);

        if (!isset($input['equipment_id']) || !isset($input['responses']) || !is_array($input['responses'])) {
            $this->output->set_status_header(400);
            echo json_encode(array('success' => false, 'error' => 'Invalid input. Require equipment_id and responses array.'));
            return;
        }

        $equipment_id = $input['equipment_id'];
        $responses = $input['responses'];
        $user_id = $this->user_id;

        // Validate equipment exists
        if (!$this->Equipment_model->get_by_id($equipment_id)) {
            $this->output->set_status_header(404);
            echo json_encode(array('success' => false, 'error' => 'Equipment not found'));
            return;
        }

        // Create inspection
        $inspection_id = $this->Inspection_model->create($equipment_id, $user_id);

        // Save responses
        $saved_count = $this->Inspection_response_model->bulk_create($inspection_id, $responses);

        // Update inspection completed
        $this->db->where('id', $inspection_id);
        $this->db->update('inspections', array(
            'status' => 'completed',
            'completed_at' => date('Y-m-d H:i:s')
        ));

        echo json_encode(array(
            'success' => true,
            'inspection_id' => $inspection_id,
            'saved_responses' => $saved_count
        ));
    }
}
?>