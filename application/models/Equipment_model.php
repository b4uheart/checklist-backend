<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Equipment_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_by_qr($qr_code)
    {
        $this->db->where('qr_code', $qr_code);
        $query = $this->db->get('equipment');
        return $query->row_array();
    }

    public function get_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('equipment');
        return $query->row_array();
    }

    public function count_all()
    {
        return (int) $this->db->count_all('equipment');
    }

    public function update_last_inspection_date($equipment_id, $today_date)
    {

        // Calculate tomorrow's date
        $next_date = date('Y-m-d', strtotime($today_date . ' +1 day'));

        $this->db->where('id', $equipment_id);
        $this->db->update('equipment', [
            'last_maintenance_date' => $today_date,
            'next_maintenance_date' => $next_date
        ]);
    }

    public function get_last_inspection_date($equipment_id)
    {
        $this->db->where('id', $equipment_id);
        $query = $this->db->get('equipment');
        return $query->row_array()['last_maintenance_date'];
    }

    public function get_all()
    {
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('equipment');
        return $query->result_array();
    }

    public function create($data)
    {
        $this->db->insert('equipment', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            $error = $this->db->error(); // 👈 get DB error

            // Log error (recommended)
            log_message('error', 'DB Insert Error: ' . json_encode($error));

            // Optionally return error for debugging
            return [
                'status' => false,
                'error' => $error
            ];
        }
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('equipment', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('equipment');
    }
}
?>