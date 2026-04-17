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
        return $this->session->userdata('user_id');
    }

    /**
     * Authenticate user by email/password
     * @param string $email
     * @param string $password
     * @return array|false User data or false
     */
    public function login_user($email, $password) {
        $this->db->group_start();
        $this->db->where('username', $email);
        $this->db->or_where('email', $email);
        $this->db->group_end();
        $user = $this->db->get('users')->row_array();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function get_by_id($id) {
        return $this->db->get_where('users', array('id' => (int) $id))->row_array();
    }
}
?>
