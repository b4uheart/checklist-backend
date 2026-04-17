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

        $auth_header = $this->get_bearer_header();

        if ($auth_header && strpos($auth_header, 'Bearer ') === 0) {
            $token = substr($auth_header, 7);
            $decoded = $this->jwt_lib->decode($token);

            if ($decoded && isset($decoded->user_id)) {
                $this->user_id = (int) $decoded->user_id;
                return;
            }
        }

        $this->respond(array(
            'success' => false,
            'error' => 'Unauthorized. Valid Bearer token required.',
            'code' => 'AUTH_UNAUTHORIZED'
        ), 401);
        exit;
    }

    private function get_bearer_header()
    {
        $headers = function_exists('apache_request_headers') ? apache_request_headers() : array();

        foreach ($headers as $key => $value) {
            if (strtolower($key) === 'authorization') {
                return $value;
            }
        }

        if (!empty($_SERVER['HTTP_AUTHORIZATION'])) {
            return $_SERVER['HTTP_AUTHORIZATION'];
        }

        if (!empty($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
            return $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        }

        return '';
    }

    private function respond($data, $status = 200)
    {
        $this->output->set_status_header($status);
        echo json_encode($data);
    }

    private function time_ago($datetime)
    {
        if (empty($datetime)) {
            return '';
        }

        $timestamp = strtotime($datetime);
        if (!$timestamp) {
            return '';
        }

        $diff = time() - $timestamp;

        if ($diff < 60) {
            return $diff . ' sec ago';
        }

        if ($diff < 3600) {
            return floor($diff / 60) . ' min ago';
        }

        if ($diff < 86400) {
            return floor($diff / 3600) . ' hr ago';
        }

        return floor($diff / 86400) . ' day ago';
    }

    public function equipment_qr($qr_code)
    {
        $equipment = $this->Equipment_model->get_by_qr($qr_code);
        if ($equipment) {
            $this->respond(array('success' => true, 'data' => $equipment));
        } else {
            $this->respond(array('success' => false, 'error' => 'Equipment not found', 'code' => 'EQUIPMENT_NOT_FOUND'), 404);
        }
    }

    public function questions($equipment_id)
    {
        $questions = $this->Checklist_question_model->get_by_id($equipment_id);
        $this->respond(array('success' => true, 'data' => $questions));
    }

    public function save_inspection()
    {
        $input = json_decode($this->input->raw_input_stream, true);

        if (!isset($input['equipment_id']) || !isset($input['responses']) || !is_array($input['responses'])) {
            $this->respond(array('success' => false, 'error' => 'Invalid input. Require equipment_id and responses array.', 'code' => 'VALIDATION_ERROR'), 400);
            return;
        }

        $equipment_id = $input['equipment_id'];
        $responses = $input['responses'];

        if (!$this->Equipment_model->get_by_id($equipment_id)) {
            $this->respond(array('success' => false, 'error' => 'Equipment not found', 'code' => 'EQUIPMENT_NOT_FOUND'), 404);
            return;
        }

        $inspection_id = $this->Inspection_model->create($equipment_id, $this->user_id);
        $saved_count = $this->Inspection_response_model->bulk_create($inspection_id, $responses);

        $this->db->where('id', $inspection_id);
        $this->db->update('inspections', array(
            'status' => 'completed',
            'completed_at' => date('Y-m-d H:i:s')
        ));

        $this->respond(array(
            'success' => true,
            'inspection_id' => (int) $inspection_id,
            'saved_responses' => $saved_count
        ));
    }

    public function auth_me()
    {
        $user = $this->User_model->get_by_id($this->user_id);

        if (!$user) {
            $this->respond(array('success' => false, 'error' => 'User not found', 'code' => 'USER_NOT_FOUND'), 404);
            return;
        }

        $this->respond(array(
            'success' => true,
            'user' => array(
                'id' => (int) $user['id'],
                'name' => $user['name'],
                'email' => !empty($user['email']) ? $user['email'] : $user['username'],
                'role' => $user['role'],
            ),
        ));
    }

    public function auth_logout()
    {
        $this->respond(array(
            'success' => true,
            'message' => 'Logged out successfully'
        ));
    }

    public function dashboard_summary()
    {
        $this->respond(array(
            'success' => true,
            'data' => array(
                'total_equipment' => $this->Equipment_model->count_all(),
                'completed_today' => $this->Inspection_model->count_completed_today(),
                'pending_count' => $this->Inspection_model->count_pending(),
                'compliance_rate' => $this->Inspection_model->compliance_rate(),
            ),
        ));
    }

    public function dashboard_recent_scans()
    {
        $limit = (int) $this->input->get('limit');
        if ($limit <= 0) {
            $limit = 10;
        }

        $rows = $this->Inspection_model->get_recent_scans($limit);
        $data = array();

        foreach ($rows as $row) {
            $scanned_at = !empty($row['completed_at']) ? $row['completed_at'] : $row['started_at'];
            $data[] = array(
                'equipment_id' => (int) $row['equipment_id'],
                'equipment_name' => $row['equipment_name'],
                'qr_code' => $row['qr_code'],
                'inspection_id' => (int) $row['inspection_id'],
                'status' => $row['status'],
                'scanned_at' => !empty($scanned_at) ? date('c', strtotime($scanned_at)) : null,
                'time_ago' => $this->time_ago($scanned_at),
            );
        }

        $this->respond(array(
            'success' => true,
            'data' => $data,
        ));
    }

    public function inspections_history()
    {
        $result = $this->Inspection_model->get_history(array(
            'page' => $this->input->get('page'),
            'limit' => $this->input->get('limit'),
            'equipment_id' => $this->input->get('equipment_id'),
            'date_from' => $this->input->get('date_from'),
            'date_to' => $this->input->get('date_to'),
            'status' => $this->input->get('status'),
        ));

        $inspection_ids = array_map('intval', array_column($result['data'], 'inspection_id'));
        $equipment_ids = array_map('intval', array_column($result['data'], 'equipment_id'));
        $answered_counts = $this->Inspection_response_model->get_answer_counts_by_inspection_ids($inspection_ids);
        $question_counts = $this->Checklist_question_model->count_by_equipment_ids($equipment_ids);

        $data = array();
        foreach ($result['data'] as $row) {
            $answered = $answered_counts[(int) $row['inspection_id']] ?? 0;
            $total_questions = $question_counts[(int) $row['equipment_id']] ?? 0;
            $progress = $total_questions > 0 ? round($answered / $total_questions, 2) : 0;

            $data[] = array(
                'inspection_id' => (int) $row['inspection_id'],
                'equipment_id' => (int) $row['equipment_id'],
                'equipment_name' => $row['equipment_name'],
                'qr_code' => $row['qr_code'],
                'completed_at' => !empty($row['completed_at']) ? date('c', strtotime($row['completed_at'])) : null,
                'answered_count' => $answered,
                'total_questions' => $total_questions,
                'progress' => $progress,
                'status' => $row['status'],
            );
        }

        $this->respond(array(
            'success' => true,
            'data' => $data,
            'meta' => $result['meta'],
        ));
    }

    public function inspection_detail($inspection_id)
    {
        $inspection = $this->Inspection_model->get_detail($inspection_id);

        if (!$inspection) {
            $this->respond(array('success' => false, 'error' => 'Inspection not found', 'code' => 'INSPECTION_NOT_FOUND'), 404);
            return;
        }

        $responses = $this->Inspection_response_model->get_by_inspection($inspection_id);

        $this->respond(array(
            'success' => true,
            'data' => array(
                'inspection_id' => (int) $inspection['inspection_id'],
                'equipment' => array(
                    'id' => (int) $inspection['equipment_id'],
                    'name' => $inspection['equipment_name'],
                    'qr_code' => $inspection['qr_code'],
                ),
                'completed_at' => !empty($inspection['completed_at']) ? date('c', strtotime($inspection['completed_at'])) : null,
                'inspector' => array(
                    'id' => (int) $inspection['user_id'],
                    'name' => $inspection['inspector_name'],
                    'email' => $inspection['inspector_email'],
                ),
                'responses' => $responses,
            ),
        ));
    }
}
?>
