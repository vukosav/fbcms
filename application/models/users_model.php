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
            $this->db->where('users.IsActive = ', 1);
            $this->db->select('users.*, roles.name as rname, uu.username as addedby');
            $this->db->from('users');
            $this->db->join('roles', 'roles.id = users.roleId');
            $this->db->join('users as uu', 'uu.id = users.createdBy', 'left outer');
            $this->db->where('users.id = ', $id);
            $query = $this->db->get();
        }
        return $query->result_array();
    }
    
    function getRows($params = array()){
        $this->db->where('users.IsActive = ', 1);
        $this->db->select('users.*, users.username, roles.name as rname, uu.username as addedby');
        $this->db->from('users');
        $this->db->join('roles', 'roles.id = users.roleId');
        $this->db->join('users as uu', 'uu.id = users.createdBy', 'left outer');
        //filter data by searched keywords
        if(!empty($params['search']['role'])){
            $this->db->where('users.roleId',$params['search']['role']);
        }
        //filter data by searched keywords
        if(!empty($params['search']['username'])){
            $this->db->like('users.username',$params['search']['username']);
        }
        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        //get records
        $query = $this->db->get();
        //return fetched data
        return ($query->num_rows() > 0)?$query->result_array():array();
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
