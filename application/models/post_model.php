<?php

class Post_model extends CI_Model{
    
    // public function __construct()
    // {
    //         //$this->load->database();
    // }
    
    function getRows($params = array()){
        // $this->db->where('posts.IsActive = ', 1);
        $where = "(PostStatus = 2 or PostStatus = 3)";
        $this->db->where($where);
        $this->db->select('posts.*, users.username as addedby');
        $this->db->from('posts');
        $this->db->join('users', 'users.id = posts.created_by');
        //$this->db->select('*');
        //$this->db->from('');
        // $this->db->join('users', 'users.id = groups.userId');

        //filter data by searched keywords
                                                // if(!empty($params['search']['group'])){
                                                //     $this->db->where('posts_pages.pageId',$params['search']['group']);
                                                // }
        //filter data by searched keywords
                                                // if(!empty($params['search']['fbpage'])){
                                                //     $this->db->where('posts_pages.pageId',$params['search']['fbpage']);
                                                // }
        //filter data by searched keywords
        if(!empty($params['search']['createdBy'])){
            $this->db->where('posts.created_by = ',$params['search']['createdBy']);
        }
        //filter data by searched keywords
        // if(!empty($params['search']['date_from'])){
        //     if(!empty($params['search']['date_to'])){
        //             $od = $params['search']['date_from'];
        //             $do = $params['search']['date_to'];
        //             $w = '(posts.created_date BETWEEN ' .$od .' AND ' .$do .')';
        //             $this->db->where($w);
        //         }else{
        //             $this->db->where('posts.created_date >=',$params['search']['date_from']);
        //         }
        // }elseif(!empty($params['search']['date_to'])){
        //     $this->db->where('posts.created_date <=',$params['search']['date_to']);
        // }
                            // if(($params['search']['date_from'] !== '' ) || ($params['search']['to'] !== '' )){
                            //                 $od = $params['search']['date_from'];
                            //                $do = $params['search']['date_to'];
                            //                $w = '(posts.created_date BETWEEN ' .$od .' AND ' .$do .')';
                            //                 $this->db->where($w);
                            // }
                            // if(($params['search']['date_from'] !== '' ) || ($params['search']['to'] == '' )){
                            //     $this->db->where('posts.created_date >=',$params['search']['date_from']);
                            // }
                            // if(($params['search']['date_from'] == '' ) || ($params['search']['to'] !== '' )){
                            //     $this->db->where('posts.created_date <=',$params['search']['date_to']);
                            // }
        //filter data by title
        if(!empty($params['search']['wtitle'])){
            $this->db->like('posts.title',$params['search']['wtitle']);
        }
        //filter data by searched keywords
        // if(!empty($params['search']['date_to'])){
        //     $this->db->where('posts.created_date <=',$params['search']['date_to']);
        // }

        //filter data by searched keywords
        // if(!empty($params['search']['post_status'])){
        //     $this->db->where('posts.PostStatus',$params['search']['post_status']);
        // }
        //filter data by searched keywords
        if(!empty($params['search']['archived'])){
            $this->db->where('posts.IsActive',$params['search']['archived']);
        }else{
            $this->db->where('posts.IsActive', 1);
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


}
