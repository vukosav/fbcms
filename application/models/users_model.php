<?php

class Users_model extends CI_Model{
    
    public function __construct()
    {
            //$this->load->database();
    }
    
    /**
     * @usage
     * Single:
     * All:
     * Custom:
     */
    public function get_users($id = null){
        if($id === null){
            $this->db->where('users.IsActive = ', 1);
            $this->db->select('users.*, roles.name as rname, uu.username as addedby');
            $this->db->from('users');
            $this->db->join('roles', 'roles.id = users.roleId');
            $this->db->join('users as uu', 'uu.id = users.createdBy', 'left outer');
            // $this->db->where('IsActive', 1);
            $query = $this->db->get();
        }elseif(is_array($id)){
            $this->db->where('users.IsActive = ', 1);
            $this->db->where($id);
            $this->db->select('users.*, roles.name as rname, uu.username as addedby');
            $this->db->from('users');
            $this->db->join('roles', 'roles.id = users.roleId');
            $this->db->join('users as uu', 'uu.id = users.createdBy', 'left outer');
            $query = $this->db->get();
            // $query = $this->db->get();
        }else{
            $this->db->select('users.*, roles.name as rname, uu.username as addedby');
            $this->db->from('users');
            $this->db->join('roles', 'roles.id = users.roleId');
            $this->db->join('users as uu', 'uu.id = users.createdBy', 'left outer');
            $this->db->where('users.id = ', 1);
            $query = $this->db->get();
        }
        return $query->result_array();
    }
    



    //-------------CRUD--------------------------
    /**
     * @usage
     */
    public function insert($data){
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    /**
    * @usage
    */
    // public function update($data, $post_id){
    //     $this->db->where(['post_id', $post_id]);
    //     $this->db->update('post', $data);
    //     return $this->db->affected_rows();
    // }

    /**
    * @usage
    */
    public function delete($id){
        $this->db->set('IsActive', false);
        $this->db->where('id', $id);
        $this->db->update('users');
        //$this->db->delete('users', $id);
        return $this->db->affected_rows();
    }
    //-------------END CRUS--------------------


}
