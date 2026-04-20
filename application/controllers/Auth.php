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
		$this->load->model('User_model');
		$this->load->library('session');

		// 👉 If GET → show login page
		if ($this->input->method() === 'get') {
			$data = [
				'page_title' => 'Login | Checklist',
				'app_name' => 'Checklist',
				'app_tagline' => 'Organize daily work, track priorities, and keep your team aligned.',
			];
			return $this->load->view('auth/login', $data);
		}

		// 👉 Detect if request is API (JSON) or Browser (form)
		$contentType = $this->input->server('CONTENT_TYPE') ?? '';
		$rawInput = file_get_contents("php://input");

		$isJson = stripos($contentType, 'application/json') !== false
			|| (!empty($rawInput) && is_array(json_decode($rawInput, true)));

		$raw = json_decode(file_get_contents("php://input"), true);

		$email = $this->input->post('email') ?: ($raw['email'] ?? '');
		$password = $this->input->post('password') ?: ($raw['password'] ?? '');

		if (empty($email) || empty($password)) {
			if ($isJson) {
				return $this->jsonResponse(400, ['error' => 'Email and password required']);
			} else {
				$this->session->set_flashdata('error', 'Email and password required');
				return redirect('login');
			}
		}

		$user = $this->User_model->login_user($email, $password);

		if (!$user) {
			if ($isJson) {
				return $this->jsonResponse(401, ['error' => 'Invalid credentials']);
			} else {
				$this->session->set_flashdata('error', 'Invalid credentials');
				return redirect('login');
			}
		}

		// 👉 Payload
		$payload = [
			'user_id' => $user['id'],
			'username' => $user['username']
		];

		// 👉 Tokens
		$accessToken = $this->jwt_lib->encode($payload, 900); // 15 min
		$refreshToken = $this->jwt_lib->encode($payload, 60 * 60 * 24 * 30); // 30 days

		// 👉 If API request → return JSON
		if ($isJson) {
			return $this->jsonResponse(200, [
				'success' => true,
				'access_token' => $accessToken,
				'refresh_token' => $refreshToken,
				'user' => [
					'id' => (int) $user['id'],
					'name' => $user['name'] ?? $user['username'],
					'email' => $user['email'] ?? $user['username']
				]
			]);
		}

		// 👉 If Browser login → store session + redirect
		$this->session->set_userdata([
			'user_id' => $user['id'],
			'username' => $user['username'],
			'logged_in' => true
		]);

		// (optional) store token if you want
		$this->session->set_userdata('access_token', $accessToken);

		return redirect('dashboard'); // change to your route
	}

	public function refresh()
	{
		$raw = json_decode(file_get_contents("php://input"), true);
		$refreshToken = $raw['refresh_token'] ?? null;

		if (!$refreshToken) {
			return $this->jsonResponse(401, ['error' => 'Refresh token required']);
		}

		try {
			$decoded = $this->jwt_lib->decode($refreshToken);

			$payload = [
				'user_id' => $decoded->user_id,
				'username' => $decoded->username
			];

			$newAccessToken = $this->jwt_lib->encode($payload, 900);

			return $this->jsonResponse(200, [
				'access_token' => $newAccessToken
			]);

		} catch (Exception $e) {
			return $this->jsonResponse(401, ['error' => 'Invalid refresh token']);
		}
	}

	public function logout()
	{
		// Optional (for future DB-based token invalidation)
		return $this->jsonResponse(200, ['message' => 'Logged out']);
	}

	private function jsonResponse($status, $data)
	{
		return $this->output
			->set_status_header($status)
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}
}