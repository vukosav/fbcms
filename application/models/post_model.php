<?php

class Post_model extends CI_Model{
    
    // public function __construct()
    // {
    //         //$this->load->database();
    // }
    
    function getRows($params = array(), $pos=null){
        // $this->db->where('posts.IsActive = ', 1);
        // $where = "(PostStatus = 2 or PostStatus = 3)";
        // $this->db->where($where);  SUM( case when posts_pages.postingStatus=1 then 1 else 0 end ) as draft,
        //$this->db->distinct();
        $this->db->select('CountPages(posts_pages.postId) ukupno, 
        PostPagesStatCount(posts.id, 4) as error,
        PostPagesStatCount(posts.id, 3) as sent,
        PostPagesStatCount(posts.id, 2) as inProgres,
        posts.*, ErrorsForPost(posts.id) AS job_errors, PagesForPost(posts.id) AS pages, GroupsForPost(posts.id) AS groups, users.username as addedby'); /*PagesForPost(posts.id) AS pages,*/
        $this->db->from('posts');
        $this->db->join('users', 'users.id = posts.created_by');
        //$this->db->select('*');
        //$this->db->from('');
        $this->db->join('posts_pages', 'posts_pages.postId = posts.id', 'left outer');
        $this->db->join('groups_in_post', 'groups_in_post.postId = posts.id', 'left outer');
        $this->db->group_by('posts.id');
        

        //filter data by searched keywords
        if(!empty($params['search']['group'])){
            $this->db->where('groups_in_post.groupId',$params['search']['group']);
        }
        //filter data by searched keywords
        if(!empty($params['search']['fbpage'])){
            $this->db->where('posts_pages.pageId',$params['search']['fbpage']);
        }
        //filter data by searched keywords
        if($this->session->userdata('user')['role'] == 2){
            $this->db->where('posts.created_by = ',$this->session->userdata('user')['user_id']);
        }
        if(!empty($params['search']['createdBy'])){
            $this->db->where('posts.created_by = ',$params['search']['createdBy']);
        }
        // filter data by searched keywords
        if(!empty($params['search']['date_from'])){
            $this->db->where('posts.created_date >=',$params['search']['date_from']);
        }
        if(!empty($params['search']['date_to'])){
            $this->db->where('posts.created_date <=',$params['search']['date_to']);
        }
        //filter data by searched keywords
        if(!empty($params['search']['archived'])){
            $this->db->where('posts.IsActive', 0);
        }else{
            $this->db->where('posts.IsActive', 1);
        }
        //filter data by searched keywords
        if(isset($pos)){
            if($pos==1){
                if(!empty($params['search']['inProgres'])){ 
                    $this->db->where('posts.PostStatus', 3);
                }else{
                     $this->db->where('(PostStatus = 2 or PostStatus = 3)');
                }
            }elseif($pos==2){
                $this->db->where('(PostStatus = 1)');
            }else{
                $this->db->where('(PostStatus = 4)');
            }
        }
        //filter data by searched keywords
        if(!empty($params['search']['paused'])){
            $this->db->where('posts.ActionStatus', 2);
        }
        if(!empty($params['search']['scheduled'])){
            $this->db->where('isScheduled = 1');
        }
        //filter data by searched keywords
        if(!empty($params['search']['errors'])){
            $this->db->where('posts_pages.postingStatus = 4');
        }
        //filter data by title
        if(!empty($params['search']['wtitle'])){
            // $this->db->like('posts.title',$params['search']['wtitle']);
            // $this->db->or_like('posts.content', $params['search']['wtitle']);
            $this->db->where("(posts.title LIKE '%{$params['search']['wtitle']}%' || posts.content LIKE '%{$params['search']['wtitle']}%')");
        }
        //filter data by searched keywords
        // if(!empty($params['search']['post_status'])){
        //     $this->db->where('posts.PostStatus',$params['search']['post_status']);
        // }
        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        //get records
        $this->db->order_by('posts.id desc');
        $query = $this->db->get();
        //return fetched data
        // $debug_array = []

        return ($query->num_rows() > 0)?$query->result_array():array();
    }
    
    function getRowsArchived($params = array(), $pos=null){
        //$this->db->distinct();
        $this->db->select('CountPagesArchive(posts_pages_archive.postId) ukupno,
        PostPagesArchStatCount(posts_archive.id, 4) as error,
        PostPagesArchStatCount(posts_archive.id, 3) as sent,
        PostPagesArchStatCount(posts_archive.id, 2) as inProgres,
        posts_archive.*, ErrorsForPost_Archive(posts_archive.id) AS job_errors, GroupsForPost(posts_archive.id) AS groups, PagesForPostArchive(posts_archive.id) AS pages, users.username as addedby'); /*PagesForPost(posts_archive.id) AS pages,*/
        $this->db->from('posts_archive');
        $this->db->join('users', 'users.id = posts_archive.created_by');
        //$this->db->select('*');
        //$this->db->from('');
        $this->db->join('posts_pages_archive', 'posts_pages_archive.postId = posts_archive.id', 'left outer');
        $this->db->join('groups_in_post', 'groups_in_post.postId = posts_archive.id', 'left outer');
        $this->db->group_by('posts_archive.id');
        

        //filter data by searched keywords
                                                if(!empty($params['search']['group'])){
                                                    $this->db->where('groups_in_post.groupId',$params['search']['group']);
                                                }
        //filter data by searched keywords
        if(!empty($params['search']['fbpage'])){
            $this->db->where('posts_pages_archive.pageId',$params['search']['fbpage']);
        }
        //filter data by searched keywords
        if($this->session->userdata('user')['role'] == 2){
            $this->db->where('posts_archive.created_by = ',$this->session->userdata('user')['user_id']);
        }
        if(!empty($params['search']['createdBy'])){
            $this->db->where('posts_archive.created_by = ',$params['search']['createdBy']);
        }
        // filter data by searched keywords
        if(!empty($params['search']['date_from'])){
            $this->db->where('posts_archive.created_date >=',$params['search']['date_from']);
        }
        if(!empty($params['search']['date_to'])){
            $this->db->where('posts_archive.created_date <=',$params['search']['date_to']);
        }
        if(!empty($params['search']['archived'])){
            $a = 1;
        }

        //filter data by searched keywords
        if(isset($pos)){
            if($pos==1){
                if(!empty($params['search']['inProgres'])){ 
                    $this->db->where('posts_archive.PostStatus', 3);
                }else{
                     $this->db->where('(PostStatus = 2 or PostStatus = 3)');
                }
            }elseif($pos==2){
                $this->db->where('(PostStatus = 1)');
            }else{
                $this->db->where('(PostStatus = 4)');
            }
        }
        //filter data by searched keywords
        if(!empty($params['search']['paused'])){
            $this->db->where('posts_archive.ActionStatus', 2);
        }
        if(!empty($params['search']['scheduled'])){
            $this->db->where('isScheduled = 1');
        }
        //filter data by searched keywords
        if(!empty($params['search']['errors'])){
            $this->db->where('posts_pages_archive.postingStatus = 4');
        }
        //filter data by title
        if(!empty($params['search']['wtitle'])){
            // $this->db->like('posts_archive.title',$params['search']['wtitle']);
            // $this->db->or_like('posts_archive.content', $params['search']['wtitle']);
            $this->db->where("(posts_archive.title LIKE '%{$params['search']['wtitle']}%' || posts_archive.content LIKE '%{$params['search']['wtitle']}%')");
        }
        //filter data by searched keywords
        // if(!empty($params['search']['post_status'])){
        //     $this->db->where('posts_archive.PostStatus',$params['search']['post_status']);
        // }
        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        //get records
        $this->db->order_by('posts_archive.dateArchive desc');
        $query = $this->db->get();
        //return fetched data
        // $debug_array = []

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


//jelena start

public function insert_post($user_id, $w_title, $message, $upload_img, $upload_video, $add_link) {

    $this->db->set('created_by',$user_id);
    $this->db->set('title',$w_title);
    $this->db->set('content',$message);
    $this->db->set('created_date', date("Y-m-d H:i:s"));
    $this->db->set('PostStatus', 1);
    $this->db->set('ActionStatus', 0);
    $this->db->set('isActive', 1);
    $q = $this->db->insert('posts');
    
    $inserted_post_id=$this->db->insert_id();
    if($upload_img!==""){
        $attach_type="image";
        $attach_location=$upload_img;
    } 

    if ($upload_video!=="") {
        $attach_type="video";
        $attach_location=$upload_video;
    }

    if ($add_link!=="") {
        $attach_type="link";
        $attach_location=$add_link;
    }

    if (  $inserted_post_id!== null ) {
        $this->db->set('post_id', $this->db->insert_id());
        $this->db->set('attach_type',$attach_type);
        $this->db->set('attach_location',$attach_location);
        $this->db->set('caption', "");
        $this->db->set('localResources', 1);
        $query = $this->db->insert('post_attachments');
    }

    return $inserted_post_id ;

}   
//jelena end

}
