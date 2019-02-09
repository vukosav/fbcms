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
            $this->db->select('users.*, roles.name as rname, uu.username as addedby');
            $this->db->from('users');
            $this->db->join('roles', 'roles.id = users.roleId');
            $this->db->join('users as uu', 'uu.id = users.createdBy', 'left outer');
            $query = $this->db->get();
        }elseif(is_array($id)){
            $this->db->select('users.name, roles.name as rname, uu.username as addedby');
            $this->db->from('users');
            $this->db->join('roles', 'roles.id = users.roleId');
            $this->db->join('users as uu', 'uu.id = users.createdBy', 'left outer');
            $query = $this->db->get_where($id);
            // $query = $this->db->get();
        }else{
            $query = $this->db->get('users', ['id' => $id]);
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
    public function update($data, $post_id){
        $this->db->where(['post_id', $post_id]);
        $this->db->update('post', $data);
        return $this->db->affected_rows();
    }

    /**
    * @usage
    */
    public function delete($data, $post_id){
        $this->db->delete('post', ['post_id', $post_id]);
        return $this->db->affected_rows();
    }
    //-------------END CRUS--------------------


}
