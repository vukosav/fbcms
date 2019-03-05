<?php

class Other_model extends CI_Model{
    
    public function __construct()
    {
            //$this->load->database();
    }
    public function get_users($id = null){
            $this->db->where('IsActive = ', 1);
            // $this->db->select('groups.*, users.username as addedby');
            // $this->db->from('groups');
            // $this->db->join('users', 'users.id = groups.userId');
            // $this->db->where('groups.id = ', $id);
            $this->db->order_by('username','asc');
            $query = $this->db->get('users');
        return $query->result_array();
    }

    public function get_role(){
        $this->db->order_by('name','asc');
        $query = $this->db->get('roles');
        return $query->result_array();
    }

    public function get_group(){
        $this->db->order_by('name','asc');
        $query = $this->db->get('groups');
        return $query->result_array();
    }

    public function get_fbpage($userid = null){
        $this->db->where('IsActive = ', 1);
        isset($userid)?$this->db->where('userId = ', $userid):FALSE;
        $this->db->order_by('fbPageName','asc');
        $query = $this->db->get('pages');
    return $query->result_array();
}
}
