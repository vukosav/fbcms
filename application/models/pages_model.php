<?php

class Pages_model extends CI_Model{
    
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
    public function get_pages($id = null){
        if($id === null){
            $this->db->where('pages.IsActive = ', 1);
            $this->db->select('pages.*, users.username as addedby');
            $this->db->from('pages');
            $this->db->join('users', 'users.id = pages.userId');
            // $this->db->where('IsActive', 1);
            $query = $this->db->get();
        }elseif(is_array($id)){
            $this->db->where('pages.IsActive = ', 1);
            $this->db->where($id);
            $this->db->select('pages.*, users.username as addedby');
            $this->db->from('pages');
            $this->db->join('users', 'users.id = pages.userId');
            $query = $this->db->get();
            // $query = $this->db->get();
        }else{
            $this->db->where('pages.IsActive = ', 1);
            $this->db->select('pages.*, users.username as addedby');
            $this->db->from('pages');
            $this->db->join('users', 'users.id = pages.userId');
            $this->db->where('pages.id = ', $id);
            $query = $this->db->get();
        }
        return $query->result_array();
    }

    public function get_free_pages($gid){
        $query = $this->db->query('SELECT pages.id, pages.fbPageName FROM pages
        WHERE pages.id NOT IN (SELECT pageId FROM pages_groups WHERE groupId = ' .$gid.')');
        if($query){
            return $query->result_array();
        }
        return false;
    }

    public function get_added_pages($gid){
        $query = $this->db->query('SELECT pages_groups.id pgid, pages.id, pages.fbPageName FROM pages
                          JOIN pages_groups ON pages.id = pages_groups.pageId
                          JOIN groups ON groups.id = pages_groups.groupId
                          WHERE pages.id IN (SELECT pageId FROM pages_groups WHERE groupId = ' .$gid.')');
        if($query){
            return $query->result_array();
        }
        return false;
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
