<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url'));
	}

	public function index()
	{
		redirect('login');
	}

	public function login()
	{
		if ($this->input->method() === 'get') {
			$data = array(
				'page_title' => 'Login | Checklist',
				'app_name' => 'Checklist',
				'app_tagline' => 'Organize daily work, track priorities, and keep your team aligned.',
			);
			$this->load->view('auth/login', $data);
			return;
		}

		$this->load->model('User_model');
		$this->load->library('session');

		$raw = json_decode(file_get_contents("php://input"), true);

		$email = $this->input->post('email') ?: ($raw['email'] ?? '');
		$password = $this->input->post('password') ?: ($raw['password'] ?? '');

		if (empty($email) || empty($password)) {
			if ($this->input->is_ajax_request() || $this->input->method() === 'post') {
				$this->output->set_content_type('application/json');
				$this->output->set_status_header(400);
				echo json_encode(['success' => false, 'error' => 'Email and password required']);
			} else {
				$this->session->set_flashdata('error', 'Email and password required');
				redirect('login');
			}
			return;
		}

		$user = $this->User_model->login_user($email, $password);

		if ($user) {
			$this->session->set_userdata([
				'user_id' => $user['id'],
				'username' => $user['username']
			]);

			$payload = [
				'user_id' => $user['id'],
				'username' => $user['username']
			];
			$token = $this->jwt_lib->encode($payload);

			if ($this->input->is_ajax_request() || strpos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false) {
				$this->output->set_content_type('application/json');
				echo json_encode([
					'success' => true,
					'token' => $token,
					'user' => [
						'id' => (int) $user['id'],
						'name' => $user['name'] ?? $user['username'],
						'email' => !empty($user['email']) ? $user['email'] : $user['username']
					]
				]);
			} else {
				redirect('dashboard');
			}
		} else {
			if ($this->input->is_ajax_request() || strpos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false) {
				$this->output->set_content_type('application/json');
				$this->output->set_status_header(401);
				echo json_encode(['success' => false, 'error' => 'Invalid credentials']);
			} else {
				$this->session->set_flashdata('error', 'Invalid credentials');
				redirect('login');
			}
		}
	}
}
