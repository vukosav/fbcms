<?php

class FB_model extends CI_Model{

public function get_post_data($post_id){
   // $this->db->where('PostStatus =', 4);
    if($post_id>0){
        $this->db->where('id', $post_id);
        $query = $this->db->get('posts');
        return $query->result_array();
        //return ($query->num_rows() > 0)?$query->result_array():array();
    }
    else {
        return 0; //message that there is no ppst with such id
    }
}

public function get_post_attachments($post_id, $post_type){
    // $this->db->where('PostStatus =', 4);
     if($post_id>0){
        
        $this->db->where('post_id', $post_id);
        $this->db->where('attach_type', $post_type);
        $query = $this->db->get('post_attachments');
        return ($query->num_rows() > 0)?$query->result_array():array();
    }
    else {
         return 0; //message that there is no post with such id
     }
 }

 public function delete_post_attachments($post_id){
    // $this->db->where('PostStatus =', 4);
     if($post_id>0){
         $query = $this->db->delete('post_attachments', $post_id);
         return $this->db->affected_rows();
    }
    else {
         return 0; //
     }
 }

public function insert_post($user_id, $selected_page_id, $w_title, $post_type, $message, $upload_video, $add_link, $upload_images_list) {

  
    $this->db->set('created_by',$user_id);
    $this->db->set('title',$w_title);
    $this->db->set('content',$message);
    $this->db->set('created_date', date("Y-m-d H:i:s"));
    $this->db->set('PostStatus', 1);
    $this->db->set('ActionStatus', 0);
    $this->db->set('post_type', $post_type);
    $this->db->set('isActive', 1);
    $q = $this->db->insert('posts');
    
    $inserted_post_id=$this->db->insert_id();

    
    if(  $inserted_post_id!== null){
        if($post_type!=="message"){            
            if ($post_type=="video" && $upload_video!=="") {
                $attach_type="video";
                $attach_location=$upload_video;
            }

            if ($post_type=="link" && $add_link!=="") {
                $attach_type="link";
                $attach_location=$add_link;
            }
            if($post_type !="image"){
                $this->db->set('post_id', $this->db->insert_id());
                $this->db->set('attach_type',$attach_type);
                $this->db->set('attach_location',$attach_location);
                $this->db->set('caption', "");
                $this->db->set('localResources', 1);
                $query = $this->db->insert('post_attachments');
            }

            if($post_type=="image"){
                $image_array = explode(',',$upload_images_list);
                
               // var_dump($image_array);
                foreach($image_array as $image ){
                    //echo 'imagesrc ' . $image;
                    $attach_type="image";
                    $attach_location=$image;

                    $this->db->set('post_id', $inserted_post_id);
                    $this->db->set('attach_type',$attach_type);
                    $this->db->set('attach_location',$attach_location);
                    $this->db->set('caption', "");
                    $this->db->set('localResources', 1);
                    $query = $this->db->insert('post_attachments');
                }
            } 
                
        }

        //page(s)to post on   
        if($selected_page_id>0){
        
            
            $this->db->set('postId', $inserted_post_id);
            $this->db->set('pageId', $selected_page_id);
            $this->db->set('postingStatus',1); //Not started
            $this->db->set('actionStatus', 1); //Draft
            $this->db->set('dateCreated',date("Y-m-d H:i:s"));
            $query = $this->db->insert('posts_pages');
    
        }
            

        return $inserted_post_id ;
    }
    else {
        echo 'no post inserted';
    }



}   

public function get_groups_for_user($user_id) {
    $this->db->select('id, name');
    $this->db->where('userId',$user_id);
    $this->db->where('isActive',true);
    $query = $this->db->get('groups');
    
    return ($query->num_rows() > 0)?$query->result_array():array();
}


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

          $ins_num=$ins_num + $this->insert_page($fbpage_id, $fbPage_name, $fbPageAccessToken, $user_id);
         } 
     return $ins_num;    
  } 
 
 public function insert_page($fbpage_id, $fbPage_name, $fbPageAccessToken, $user_id){
     //check if page is already inserted for user
     $this->db->where('userId',$user_id);
     $this->db->where('fbPageId',$fbpage_id);
     $q = $this->db->get('pages');
  
     if ( $q->num_rows() == 0 ) 
     {
        $this->db->set("userId",$user_id);
        $this->db->set("fbPageId",$fbpage_id);
        $this->db->set("fbPageName",$fbPage_name);
        $this->db->set("fbPageAT",$fbPageAccessToken);
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
             $this->db->set("fbPageAT",$fbPageAccessToken);
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


 public function get_pages_for_post_with_fbid_and_fbAT($post_id){

    $this->db->where('posts_pages.postId=', $post_id);
    $this->db->select('posts_pages.pageId, pages.fbPageId, pages.fbPageAT ');
    $this->db->from('posts_pages');
    $this->db->join('pages', 'posts_pages.pageId = pages.id');
    $query = $this->db->get();
       
    return ($query->num_rows() > 0)?$query->result_array():array();
 }


}