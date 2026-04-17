<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get current logged in user ID from session/JWT
     */
    public function get_current_user_id() {
        // For web sessions or API (set from JWT)
        return $this->session->userdata('user_id');
    }

    /**
     * Authenticate user by email/password
     * @param string $email
     * @param string $password
     * @return array|false User data or false
     */
    public function login_user($email, $password) {
        $this->db->where('username', $email);
        $user = $this->db->get('users')->row_array();
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        
        }
        return false;
    }
}
?>

