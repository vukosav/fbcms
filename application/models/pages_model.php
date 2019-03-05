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
    function getRows($params = array()){
        $this->db->where('pages.IsActive = ', 1);
        if($this->session->userdata('user')['role'] == 2){
            $this->db->where('userId = ', $this->session->userdata('user')['user_id']);
        }
        $this->db->select('pages.*, users.username as addedby, GroupsForPages(pages.id) AS groups');
        $this->db->from('pages');
        $this->db->join('users', 'users.id = pages.userId');
        
        //$this->db->join('groups', 'pages_groups.groupId = groups.id', 'left outer');

        //filter data by user
        if(!empty($params['search']['group'])){
            $this->db->join('pages_groups', 'pages_groups.pageId = pages.id', 'left outer');
            $this->db->where('pages_groups.groupId = ',$params['search']['group']);
        }
        //filter data by page name        
        if(!empty($params['search']['pagename'])){
            $this->db->like('pages.fbPageName',$params['search']['pagename']);
        }
        //sort data by ascending or desceding order
        // if(!empty($params['search']['sortBy'])){
        //     $this->db->order_by('groups.name',$params['search']['sortBy']);
        // }else{
        //     $this->db->order_by('groups.id','desc');
        // }
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
        $query = $this->db->query('SELECT pages.id, pages_groups.id as pgid, pages.fbPageName FROM pages
        JOIN pages_groups ON pages.id = pages_groups.pageId
        WHERE pages_groups.groupId = ' .$gid.' AND pages.id IN (SELECT pageId FROM pages_groups WHERE groupId = ' .$gid.')');
        // $query = $this->db->query('SELECT pages_groups.id pgid, pages.id, pages.fbPageName FROM pages
        //                   JOIN pages_groups ON pages.id = pages_groups.pageId
        //                   JOIN groups ON groups.id = pages_groups.groupId
        //                   WHERE pages.id IN (SELECT pageId FROM pages_groups WHERE groupId = ' .$gid.')
        //                   GROUP BY  pages.id');
        if($query){
            return $query->result_array();
        }
        return false;
    }

    public function get_free_groups($pid){
        $query = $this->db->query('SELECT groups.id, groups.name FROM groups
        WHERE groups.id NOT IN (SELECT groupId FROM pages_groups WHERE pageId = ' .$pid.')');
        if($query){
            return $query->result_array();
        }
        return false;
    }

    public function get_added_groups($pid){
        $query = $this->db->query('SELECT pages_groups.id pgid, groups.id, groups.name FROM groups
        JOIN pages_groups ON groups.id = pages_groups.groupId
        WHERE pages_groups.pageId = ' .$pid.' AND groups.id IN (SELECT groupId FROM pages_groups WHERE pageId = ' .$pid.')');
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
        $this->db->set('isActive', false);
        $this->db->where('id', $id);
        $this->db->update('pages');
        //$this->db->delete('users', $id);
        return $this->db->affected_rows();
    }

    //-------------END CRUS--------------------


//jelena start
public function list_new_pages( $fb_pages, $user_id){

      
    $new_pages=$fb_pages['data'];
    $last = count( $new_pages)-1;
     
     for ($i = 0; $i <= $last; $i++) {

          $fbpage_id=$fb_pages['data'][$i]['id'];
          $fbPage_name=$fb_pages['data'][$i]['name'];
          $fbPage_at=$fb_pages['data'][$i]['access_token'];

          $this->db->where('userId',$user_id);
          $this->db->where('fbPageId',$fbpage_id);
          $q = $this->db->get('pages');
       
         if ( $q->num_rows() > 0 ){
             $res = $q->result_array();
             if( $res[0]['isActive']==true) { 
                 unset($new_pages[$i]);
             } 
         }
     } 
     return (is_array($new_pages)) ? array_values($new_pages) : null;  

 }

  public function add_new_pages( $fb_pages, $user_id){

     $ins_num=0;
     $last = count( $fb_pages['data'])-1;
     
     for ($i = 0; $i <= $last; $i++) {
  
          $fbpage_id=$fb_pages['data'][$i]['id'];
          $fbPage_name=$fb_pages['data'][$i]['name'];
          $fbPage_at=$fb_pages['data'][$i]['access_token'];

          $ins_num=$ins_num + $this->insert_page($fbpage_id, $fbPage_name, $user_id);
         } 
     return $ins_num;    
  } 
 
 public function insert_page($fbpage_id, $fbPage_name, $user_id){
     //check if page is already inserted for user
     $this->db->where('userId',$user_id);
     $this->db->where('fbPageId',$fbpage_id);
     $q = $this->db->get('pages');
  
     if ( $q->num_rows() == 0 ) 
     {
        $this->db->set("userId",$user_id);
        $this->db->set("fbPageId",$fbpage_id);
        $this->db->set("fbPageName",$fbPage_name);
        $this->db->set("dateAdded",date("Y-m-d H:i:s")); 
        $this->db->insert('pages');
     
        return $this->db->affected_rows() ;
     }   
    elseif ($q->num_rows() == 1){
         $data = $q->result_array();
         if( $data[0]['isActive']==false){
             //archived page, we should reconnect it
             $this->db->where("userId",$user_id);
             $this->db->where("fbPageId",$fbpage_id);
             $this->db->set("fbPageName",$fbPage_name);
             $this->db->set("isActive",true); 
             $this->db->update('pages');

             return $this->db->affected_rows() ;
         } else {
                     return 0;
                 }   
    }
    else 
    {    
        return 0;
    }
 }

 public function insert_fb_user($user_id,$fb_user_id, $fb_name, $accessToken){

      //check if fbuser is already inserted for user
      $this->db->where('user_id',$user_id);
      $this->db->where('fb_user_id',$fb_user_id);
      $q = $this->db->get('fb_users');
   
      if ( $q->num_rows() == 0 ) 
      {
         $this->db->set("user_id",$user_id);
         $this->db->set("fb_user_id",$fb_user_id);
         $this->db->set("fb_name",$fb_name);
         $this->db->set("fb_access_token",$accessToken); 
         $this->db->insert('fb_users');
      
         return $this->db->affected_rows() ;
      }   
 }

 public function get_pages_for_user($user_id) {

     $this->db->select('id, fbPageName');
     $this->db->where('userId',$user_id);
     $this->db->where('isActive',true);
     $query = $this->db->get('pages');

     return ($query->num_rows() > 0)?$query->result_array():array();
 }

//jelena end

}
