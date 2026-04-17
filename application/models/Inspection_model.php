<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inspection_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function create($equipment_id, $user_id) {
        // Generate UUID v4 without dashes: 32 hex chars
        $uuid = bin2hex(random_bytes(16));
        
        $data = array(
            'id' => $uuid,
            'equipment_id' => $equipment_id,
            'user_id' => $user_id,
            'status' => 'in_progress',
            'started_at' => date('Y-m-d H:i:s'),
            'sync_status' => 'synced'
        );
        
        $this->db->insert('inspections', $data);
        return $uuid; // return inspection_id
    }
}
?>

