<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Equipment_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_by_qr($qr_code) {
        $this->db->where('qr_code', $qr_code);
        $query = $this->db->get('equipment');
        return $query->row_array();
    }

    public function get_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('equipment');
        return $query->row_array();
    }
}
?>

