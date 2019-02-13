<?php

class Groups_model extends CI_Model{
    
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
    public function get_groups($id = null){
        if($id === null){
            $this->db->where('groups.IsActive = ', 1);
            $this->db->select('groups.*, users.username as addedby');
            $this->db->from('groups');
            $this->db->join('users', 'users.id = groups.userId');
            // $this->db->where('IsActive', 1);
            $query = $this->db->get();
        }elseif(is_array($id)){
            $this->db->where('groups.IsActive = ', 1);
            $this->db->where($id);
            $this->db->select('groups.*, users.username as addedby');
            $this->db->from('groups');
            $this->db->join('users', 'users.id = groups.userId');
            $query = $this->db->get();
            // $query = $this->db->get();
        }else{
            $this->db->where('groups.IsActive = ', 1);
            $this->db->select('groups.*, users.username as addedby');
            $this->db->from('groups');
            $this->db->join('users', 'users.id = groups.userId');
            $this->db->where('groups.id = ', $id);
            $query = $this->db->get();
        }
        return $query->result_array();
    }


    //-------------CRUD--------------------------
    /**
     * @usage
     */
    public function insert($data){
        $this->db->insert('groups', $data);
        return $this->db->insert_id();
    }

    public function insertPG($data){
        $this->db->insert('pages_groups', $data);
    }

    public function deletePG($data){
        $this->db->where('id', $data);
        $this->db->delete('pages_groups');
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
        $this->db->update('groups');
        //$this->db->delete('users', $id);
        return $this->db->affected_rows();
    }
    //-------------END CRUS--------------------


}
