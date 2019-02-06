<?php

class Post_model extends CI_Model{
    
    public function __construct()
    {
            //$this->load->database();
    }
    
    //-------------QUEUED-----------------------
    /**
     * @usage
     * Single:
     * All:
     * Custom:
     */
    public function get_queued($id = null){
        $where = "(PostStatus = 2 or PostStatus = 3)";
        $this->db->where($where);
        // $this->db->where('PostStatus =', 2);
        // $this->db->or_where('PostStatus =', 3);
        if($id === null){
            $query = $this->db->get('posts');
        }elseif(is_array($id)){
            $query = $this->db->get_where('posts', $id);
        }else{
            $query = $this->db->get('posts', ['id' => $id]);
        }
        return $query->result_array();
    }
    //-------------END QUEUED----------------------

    //-------------DRAFT---------------------------
    /**
     * @usage
     * Single:
     * All:
     * Custom:
     */
    public function get_draft($id = null){
        $this->db->where('PostStatus =', 1);
        if($id === null){
            $query = $this->db->get('posts');
        }elseif(is_array($id)){
            $query = $this->db->get_where('posts', ['id' => $id]);
        }else{
            $query = $this->db->get('posts', $id);
        }
        return $query->result_array();
    }
    //-------------END DRAFT---------------------
    
    //-------------SENT--------------------------
    /**
     * @usage
     * Single:
     * All:
     * Custom:
     */
    public function get_sent($id = null){
        $this->db->where('PostStatus =', 4);
        if($id === null){
            $query = $this->db->get('posts');
        }elseif(is_array($id)){
            $query = $this->db->get_where('posts', ['id' => $id]);
        }else{
            $query = $this->db->get('posts', $id);
        }
        return $query->result_array();
    }
    //-------------END SENT--------------------


    //-------------CRUD--------------------------
    /**
     * @usage
     */
    public function insert($data){
        $this->db->insert('post', $data);
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




    // public function get_queued_search($id = null){
    //     $where = "(PostStatus = 2 or PostStatus = 3)";
    //     $this->db->where($where);
    //     // $this->db->where('PostStatus =', 2);
    //     // $this->db->or_where('PostStatus =', 3);
    //     if($id === null){
    //         $query = $this->db->get('posts');
    //     }elseif(is_array($id)){
    //         $query = $this->db->like($id);
    //         $query = $this->db->get('posts');
    //     }else{
    //         $query = $this->db->get('posts', ['id' => $id]);
    //     }
    //     return $query->result_array();
    // }

    function search($keyword)
    {
        $this->load->helper('url');

        $data = array(
            'working_title' => $this->input->post('working_title')
            //'group' => $this->input->post('group'),
            // 'fbpage' => $this->input->post('fbpage'),
            // 'date_from' => $this->input->post('date_from'),
            // 'date_to' => $this->input->post('date_to'),
            // 'user' => $this->input->post('user')
        );
        //$this->db->where($keyword);
        $query  =   $this->db->get('posts');
        $query  =   $this->db->get_where('posts', $keyword);
        return $query->result_array();
    }

}
