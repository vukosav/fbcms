<?php

class Admin_model extends CI_Model{
    
    // public function __construct()
    // {
    //         // $this->load->database();
    // }
    
    public function getRows(){
        $query = $this->db->get('global_parameters');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function set($data){
        $query = $this->db->get('global_parameters');
        if ($query->num_rows() > 0) {
            foreach ($data as $key => $value) {
                $this->db->set($key, $value);
            }
            $this->db->update('global_parameters');
    
            return $this->db->affected_rows() > 0;
        } else {
            $this->db->insert('global_parameters', $data);
            return $this->db->insert_id();
        }
    }
}
