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
            isset($id)?$this->db->where('id = ', $id):FALSE;
            $this->db->order_by('username','asc');
            $query = $this->db->get('users');
        return $query->result_array();
    }

    public function get_role(){
        $this->db->order_by('name','asc');
        $query = $this->db->get('roles');
        return $query->result_array();
    }

    public function get_group($userid = null){
        $this->db->order_by('name','asc');
        isset($userid)?$this->db->where('userId = ', $userid):FALSE;
        $this->db->where('isActive = ', 1);
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
