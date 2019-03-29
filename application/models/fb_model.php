<?php

class FB_model extends CI_Model{

    public function get_post_id_for_queue_id($queue_id){
        if($queue_id>0){
            
            $this->db->select('postId');
            $this->db->where('id=', $queue_id);
            $query=$this->db->get('posts_pages');
           

            return ($query->num_rows() > 0) ? $query->row()->postId : 0 ;
        }
        else {
            return 0; //message that there is no post for such queue id
        }

    }
    public function get_post_page_for_queue_id($queue_id){

        $this->db->where('posts_pages.id=', $queue_id);
        $this->db->select('posts_pages.postId,posts_pages.fbPostId,posts_pages.pageId, pages.fbPageId, pages.fbPageAT,pages.timezone ');
        $this->db->from('posts_pages');
        $this->db->join('pages', 'posts_pages.pageId = pages.id');
        $query = $this->db->get();
        
        return ($query->num_rows() > 0)?$query->result_array():array();

    }
    public function update_posting_with_fbPostId($queue_id, $fb_post_id){

        $this->db->set('fbPostId', $fb_post_id);
        $this->db->set('datePublishedFB', date("Y-m-d H:i:s"));
        $this->db->where('id=', $queue_id);
        $q = $this->db->update('posts_pages');
            
       return $this->db->affected_rows();
    }
    public function get_post_data($post_id){
     // $this->db->where('PostStatus =', 4);
        if($post_id>0){
            $this->db->where('id=', $post_id);
            $query = $this->db->get('posts');
            return $query->result_array();
            //return ($query->num_rows() > 0)?$query->result_array():array();
        }
        else {
            return 0; //message that there is no p0st with such id
        }
    }
    public function get_post_attachments($post_id, $post_type){
        
        if($post_id>0){
            
            $this->db->where('post_id=', $post_id);
            $this->db->where('attach_type=', $post_type);
            $query = $this->db->get('post_attachments');
            return ($query->num_rows() > 0)?$query->result_array():array();
        }
        else {
            return 0; //no post with such id in db
        }
    }
    public function get_selected_pages_for_post($post_id){
        $this->db->where('page_by_hand_in_post.postId=', $post_id);
        $this->db->select('page_by_hand_in_post.pageId, pages.fbPageName ');
        $this->db->from('page_by_hand_in_post');
        $this->db->join('pages', 'page_by_hand_in_post.pageId = pages.id');
        $query = $this->db->get();
        
        return ($query->num_rows() > 0)?$query->result_array():array();
      /*  $this->db->where('posts_pages.postId=', $post_id);
        $this->db->select('posts_pages.pageId, pages.fbPageName ');
        $this->db->from('posts_pages');
        $this->db->join('pages', 'posts_pages.pageId = pages.id');
        $query = $this->db->get();
        
        return ($query->num_rows() > 0)?$query->result_array():array();



        if($post_id>0){
            
            $this->db->where('post_id', $post_id);
            $query = $this->db->get('posts_pages');
            return ($query->num_rows() > 0)?$query->result_array():array();
        }
        else {
            return 0; //no post with such id in db
        }
       */

    }    
    public function delete_post_attachments($post_id){
        // $this->db->where('PostStatus =', 4);
        if($post_id>0){
            $this->db->where('post_id=',$post_id);
            $query = $this->db->delete('post_attachments');
            return $this->db->affected_rows();
        }
        else {
            return 0; //
        }
    }
    public function delete_post_pages($post_id){
        // $this->db->where('PostStatus =', 4);
        if($post_id>0){
            $query = $this->db->where('postId=',$post_id);
            $query = $this->db->delete('posts_pages');
            return $this->db->affected_rows();
        }
        else {
            return 0; //
        }
    }

    public function delete_page_by_hand_in_post($post_id){
        // $this->db->where('PostStatus =', 4);
        if($post_id>0){
            $query = $this->db->where('postId=',$post_id);
            $query = $this->db->delete('page_by_hand_in_post');
            return $this->db->affected_rows();
        }
        else {
            return 0; //
        }
    }

    public function delete_groups_in_post($post_id){
        // $this->db->where('PostStatus =', 4);
        if($post_id>0){
            $query = $this->db->where('postId=',$post_id);
            $query = $this->db->delete('groups_in_post');
            return $this->db->affected_rows();
        }
        else {
            return 0; //
        }
    }
    public function insert_post($post_status, $user_id, $selected_page_id, $w_title, $post_type, 
        $message, $upload_video, $add_link, $upload_images_list, 
        $is_scheduled, $schedule_date_time,  $scheduledSame, $arrayPagesObj,$arrayGroupsOb) {    
            
           if($post_status=='1'){
           //draft
           
            $posting_status=null;
          }

          if($post_status=='2'){
            //queued
           
            $posting_status=1;
          }
            
            $this->db->set('created_by',$user_id);
            $this->db->set('title',$w_title);
            $this->db->set('content',$message);
            $this->db->set('created_date', date("Y-m-d H:i:s"));
            $this->db->set('PostStatus', $post_status);
            $this->db->set('ActionStatus', null);
            $this->db->set('post_type', $post_type);
            $this->db->set('IsActive', 1);
            $this->db->set('scheduledTime', $schedule_date_time);
            $this->db->set('scheduledSame', $scheduledSame);
            $this->db->set('isScheduled', $is_scheduled);
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
                 $page_id_array =  array();
                 if( $arrayPagesObj != null && is_array($arrayPagesObj)){   
                        foreach($arrayPagesObj as $pageObj ){
                            array_push($page_id_array,$pageObj->id); 
                        } 
                    }
                    if($arrayGroupsOb != null && is_array($arrayGroupsOb)){
                        foreach($arrayGroupsOb as $group){
                            if($group->pages != null && is_array($group->pages)){
                                foreach($group->pages as $pageObj ){
                                    if (!in_array($pageObj->id, $page_id_array, true)) {
                                        array_push($page_id_array,$pageObj->id); 
                                    }
                                } 
                            }
                        }
                    }
                
                //page(s)to post on
                
                //if($selected_page_id>0){

                   // $page_array = explode(',',$selected_page_id);
                    foreach( $page_id_array as $pid ){
                    //foreach($page_array as $page_id ){
                        //echo 'imagesrc ' . $image;                      
                
                        $this->db->set('pageId', $pid);
                        $this->db->set('postId', $inserted_post_id);
                        
                        $this->db->set('postingStatus', $posting_status); 
                        $this->db->set('job_id',null); 
                        $this->db->set('job_action',1); 
                            
                        $this->db->set('dateCreated',date("Y-m-d H:i:s"));
                        $query = $this->db->insert('posts_pages');
                    }
            
                   

                    if($arrayGroupsOb != null && is_array($arrayGroupsOb)){
                        foreach($arrayGroupsOb as $group){
                            if($group->pages != null && is_array($group->pages)){
                                foreach($group->pages as $pageObj ){
                                    $this->db->set('pageId', $pageObj->id);
                                    $this->db->set('postId', $inserted_post_id);
                                    $this->db->set('groupId',$group->id);
                                    $query = $this->db->insert('groups_in_post');
                                } 
                            }
                        }
                    }
                    if( $arrayPagesObj != null && is_array($arrayPagesObj)){   
                        foreach($arrayPagesObj as $pageObj ){
                            array_push($page_id_array,$pageObj->id); 
                            $this->db->set('pageId', $pageObj->id);
                            $this->db->set('postId', $inserted_post_id);
                            $query = $this->db->insert('page_by_hand_in_post');
                        } 
                    }
                return $inserted_post_id ;
            }
            else {
                echo 'no post inserted';
            }

    }   
   /* 
    public function update_post($post_id, $post_status, $user_id, $selected_page_id, $w_title, $post_type, 
        $message, $upload_video, $add_link, $upload_images_list, 
        $is_scheduled, $schedule_date_time, $arrayPagesObj,$arrayGroupsOb) {    

            $schedule_date_time=strtotime($schedule_date_time);

          if($post_status=='1'){
            //draft
           
            $posting_status=null;
          }

          if($post_status=='2'){
            //queued
            
            $posting_status=1;
          }
            
            //$this->db->set('created_by',$user_id);
            $this->db->where('id=', $post_id);
            $this->db->set('title',$w_title);
            $this->db->set('content',$message);
            $this->db->set('created_date', date("Y-m-d H:i:s"));
           // $this->db->set('PostStatus', $post_status);
          //  $this->db->set('ActionStatus', null);
            $this->db->set('post_type', $post_type);
           // $this->db->set('IsActive',1);
            $this->db->set('scheduledTime', $schedule_date_time);
            $this->db->set('isScheduled', $is_scheduled);
            $q = $this->db->update('posts');
            
                   
            if(   $this->db->affected_rows() >0 ){
                if($post_type!=="message"){  
                    //post has attachments 
                    //delete previous incarnation post attachments
                    $ret=$this->delete_post_attachments($post_id);

                    if ($post_type=="video" && $upload_video!=="") {
                        $attach_type="video";
                        $attach_location=$upload_video;
                    }

                    if ($post_type=="link" && $add_link!=="") {
                        $attach_type="link";
                        $attach_location=$add_link;
                    }

                    //insert new attachments != image
                    if($post_type !="image"){
                        $this->db->set('post_id',$post_id);
                        $this->db->set('attach_type',$attach_type);
                        $this->db->set('attach_location',$attach_location);
                        $this->db->set('caption', "");
                        $this->db->set('localResources', 1);
                        $query = $this->db->insert('post_attachments');
                    }

                    //insert new images
                    if($post_type=="image"){
                        $image_array = explode(',',$upload_images_list);
                        
                        // var_dump($image_array);
                        foreach($image_array as $image ){
                            //echo 'imagesrc ' . $image;
                            $attach_type="image";
                            $attach_location=$image;

                            $this->db->set('post_id', $post_id);
                            $this->db->set('attach_type',$attach_type);
                            $this->db->set('attach_location',$attach_location);
                            $this->db->set('caption', "");
                            $this->db->set('localResources', 1);
                            $query = $this->db->insert('post_attachments');
                        }
                    } 
                        
                }

                $valid =   $this->db->query("SELECT CanEditPageAndGroups($post_id) as validan");
                $valid = $valid->result_array();

                if($valid[0]['validan'] == '0'){
                    return $post_id ;
                }else{
                  
                  
                  
                    $page_id_array =  array();
                    if( $arrayPagesObj != null && is_array($arrayPagesObj)){   
                           foreach($arrayPagesObj as $pageObj ){
                               array_push($page_id_array,$pageObj->id); 
                           } 
                       }
                       if($arrayGroupsOb != null && is_array($arrayGroupsOb)){
                           foreach($arrayGroupsOb as $group){
                               if($group->pages != null && is_array($group->pages)){
                                   foreach($group->pages as $pageObj ){
                                       if (!in_array($pageObj->id, $page_id_array, true)) {
                                           array_push($page_id_array,$pageObj->id); 
                                       }
                                   } 
                               }
                           }
                       }
                       $ret=$this->delete_post_pages($post_id);
                       foreach( $page_id_array as $pid ){
                       //foreach($page_array as $page_id ){
                           //echo 'imagesrc ' . $image;                      
                   
                           $this->db->set('pageId', $pid);
                           $this->db->set('postId', $post_id);
                           
                           $this->db->set('postingStatus', $posting_status); 
                           $this->db->set('job_id',null); 
                           $this->db->set('job_action',1); 
                               
                           $this->db->set('dateCreated',date("Y-m-d H:i:s"));
                           $query = $this->db->insert('posts_pages');
                       }
               
                       $ret=$this->delete_groups_in_post($post_id);
   
                       if($arrayGroupsOb != null && is_array($arrayGroupsOb)){
                           foreach($arrayGroupsOb as $group){
                               if($group->pages != null && is_array($group->pages)){
                                   foreach($group->pages as $pageObj ){
                                       $this->db->set('pageId', $pageObj->id);
                                       $this->db->set('postId', $post_id);
                                       $this->db->set('groupId',$group->id);
                                       $query = $this->db->insert('groups_in_post');
                                   } 
                               }
                           }
                       }

                       $ret=$this->delete_page_by_hand_in_post($post_id);
                       if( $arrayPagesObj != null && is_array($arrayPagesObj)){   
                           foreach($arrayPagesObj as $pageObj ){
                               array_push($page_id_array,$pageObj->id); 
                               $this->db->set('pageId', $pageObj->id);
                               $this->db->set('postId', $post_id);
                               $query = $this->db->insert('page_by_hand_in_post');
                           } 
                       }

                    // if($selected_page_id>0){

                    //     //delete previous incarnation pages for post
                    //     $ret=$this->delete_post_pages($post_id);
                    
                    //     //insert new pages to send post to
                    //     $this->db->set('postId', $post_id);
                    //     $this->db->set('pageId', $selected_page_id);
                    //     $this->db->set('postingStatus', $posting_status); 
                    //     $this->db->set('job_id',null); 
                    //     $this->db->set('job_action',1);                     
                    //     $this->db->set('dateCreated',date("Y-m-d H:i:s"));
                    //     $query = $this->db->insert('posts_pages');
                
                    //}
                }
                    
                return $post_id ;
            }
            else {
                echo 'no post inserted';//add error handling & redirect ...
            }

    }  
    */

    public function update_post($post_id, $post_status, $user_id, $selected_page_id, $w_title, 
        $post_type, $message, $upload_video, $add_link, $upload_images_list, $is_scheduled, 
        $schedule_date_time, $scheduledSame, $arrayPagesObj,$arrayGroupsOb) {   

            // if($post_status=='1'){
            //         //draft           
            //         $posting_status=null;
            // }
            // if($post_status=='2'){
            //         //queued            
            //         $posting_status=1;
            // }


            $this->db->where('id=', $post_id);
            $query = $this->db->get('posts');
            $queryarr = $query->result_array();
            $db_post_status = $queryarr[0]['PostStatus'];
            if($db_post_status == '1' && $post_status == '2'){
                $this->db->where('id=', $post_id);
                $this->db->set('title', $w_title);
                $this->db->set('content', $message);
                //$this->db->set('created_date', date("Y-m-d H:i:s"));
                $this->db->set('PostStatus', $post_status);
                $this->db->set('ActionStatus', null);   
                $this->db->set('post_type', $post_type);
                //$this->db->set('IsActive',1);
                $this->db->set('scheduledTime', $schedule_date_time);
                $this->db->set('scheduledSame', $scheduledSame);
                $this->db->set('isScheduled', $is_scheduled);
            } else {  
                $this->db->where('id=', $post_id);
                $this->db->set('title', $w_title);
                $this->db->set('content', $message);
                $this->db->set('post_type', $post_type);
                $this->db->set('scheduledTime', $schedule_date_time);
                $this->db->set('isScheduled', $is_scheduled);
            }
            $q = $this->db->update('posts');

            //delete previous post incarnation attachments
            $ret=$this->delete_post_attachments($post_id);
            
            //prepare for insert of new post attacments
            if ($post_type=="video" && $upload_video!=="") {
                        $attach_type="video";
                        $attach_location=$upload_video;
            }
            if ($post_type=="link" && $add_link!=="") {
                        $attach_type="link";
                        $attach_location=$add_link;
            }
            //insert new attachments != image
            if($post_type =="video" || $post_type == "link"){
                $this->db->set('post_id',$post_id);
                $this->db->set('attach_type',$attach_type);
                $this->db->set('attach_location',$attach_location);
                $this->db->set('caption', "");
                $this->db->set('localResources', 1);
                $query = $this->db->insert('post_attachments');
            }
            //insert new images
            if($post_type=="image"){
                $image_array = explode(',',$upload_images_list);
                        
                // var_dump($image_array);
                foreach($image_array as $image ){
                    //echo 'imagesrc ' . $image;
                    $attach_type="image";
                    $attach_location=$image;

                    $this->db->set('post_id', $post_id);
                    $this->db->set('attach_type',$attach_type);
                    $this->db->set('attach_location',$attach_location);
                    $this->db->set('caption', "");
                    $this->db->set('localResources', 1);
                    $query = $this->db->insert('post_attachments');
                }
            }         
            $valid = $this->db->query("SELECT CanEditPageAndGroups($post_id) as validan");
            $valid = $valid->result_array();

            if($valid[0]['validan'] == '0'){
                    return $post_id ;
            }
            else{

                $page_id_array =  array();
                if( $arrayPagesObj != null && is_array($arrayPagesObj)){   
                    foreach($arrayPagesObj as $pageObj ){
                       array_push($page_id_array,$pageObj->id); 
                    }        
                }
                
                if($arrayGroupsOb != null && is_array($arrayGroupsOb)){
                    foreach($arrayGroupsOb as $group){
                        if($group->pages != null && is_array($group->pages)){
                            foreach($group->pages as $pageObj ){
                                if (!in_array($pageObj->id, $page_id_array, true)) {
                                    array_push($page_id_array,$pageObj->id); 
                                }
                            } 
                        }
                    }
                }
                
                $ret=$this->delete_post_pages($post_id);     
                foreach( $page_id_array as $pid ){
                    $this->db->set('pageId', $pid);
                    $this->db->set('postId', $post_id);
                                
                    $this->db->set('postingStatus', 1); 
                    $this->db->set('job_id',null); 
                    $this->db->set('job_action',1); 
                                
                    $this->db->set('dateCreated',date("Y-m-d H:i:s"));
                    $query = $this->db->insert('posts_pages');
                }
                $ret=$this->delete_groups_in_post($post_id);   
                if($arrayGroupsOb != null && is_array($arrayGroupsOb)){
                    foreach($arrayGroupsOb as $group){
                        if($group->pages != null && is_array($group->pages)){
                            foreach($group->pages as $pageObj ){
                                $this->db->set('pageId', $pageObj->id);
                                $this->db->set('postId', $post_id);
                                $this->db->set('groupId',$group->id);
                                $query = $this->db->insert('groups_in_post');
                            } 
                        }
                    }
                }
                $ret=$this->delete_page_by_hand_in_post($post_id);
                if( $arrayPagesObj != null && is_array($arrayPagesObj)){   
                    foreach($arrayPagesObj as $pageObj ){
                        array_push($page_id_array,$pageObj->id); 
                        $this->db->set('pageId', $pageObj->id);
                        $this->db->set('postId', $post_id);
                        $query = $this->db->insert('page_by_hand_in_post');
                    } 
                } 
            }     
        return $post_id;
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
    public function insert_page($fbpage_id, $fbPage_name, $fbPageAccessToken, $user_id,  $is_valid_at, $expires_at){
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
            $this->db->set("fbat_valid",$is_valid_at);
            $this->db->set("fbat_expires",$expires_at);
            $this->db->set("last_fbupdate",date("Y-m-d H:i:s"));
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
                $this->db->set("fbat_valid",$is_valid_at);
                $this->db->set("fbat_expires",$expires_at);
                $this->db->set("last_fbupdate",date("Y-m-d H:i:s"));
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

    public function insert_fb_user($user_id,$fb_user_id, $fb_name, $accessToken,$expires_at, $is_valid_at){

        $this->db->where('user_id=',$user_id);
        $q = $this->db->get('fb_users');
        $fbuser= $q->result_array();
     
        if($q->num_rows()==1 && ($fbuser[0]["fb_user_id"]!== $fb_user_id)){
            //$message = '<br>You are trying to log in with facebook account: ' . $fb_name . '<br>Please log in with fb account you are registered with: ' . $fbuser[0]["fb_name"] ;
            //echo $message;
            return 0;
        }
        elseif($q->num_rows()==1 && ($fbuser[0]['fb_user_id']=== $fb_user_id)){
            //update data for existing fbuser
            $this->db->set("fb_name",$fb_name);
            $this->db->set("fb_access_token",$accessToken); 
             
            $this->db->set("fbat_valid",$is_valid_at);
            $this->db->set("fbat_expires",$expires_at);
            $this->db->set("last_fbupdate",date("Y-m-d H:i:s"));

            $this->db->where("user_id=",$user_id);
            $this->db->where("fb_user_id=",$fb_user_id);
            $this->db->update('fb_users');

            return $this->db->affected_rows() ;

        } elseif($q->num_rows() == 0){
            //insert data for new fbuser
            $this->db->set("user_id",$user_id);
            $this->db->set("fb_user_id",$fb_user_id);
            $this->db->set("fb_name",$fb_name);
            $this->db->set("fb_access_token",$accessToken); 

            $this->db->set("fbat_valid",$is_valid_at);
            $this->db->set("fbat_expires",$expires_at);
            $this->db->set("last_fbupdate",date("Y-m-d H:i:s"));

            $this->db->insert('fb_users');
        
            return $this->db->affected_rows() ;
        }  
    }
    public function get_pages_for_user($user_id) {
            $this->db->from('users');
            $this->db->where('id', $user_id); 
            $queryResult = $this->db->get();
            $role_id =  $queryResult->row('roleId');
        if($role_id == 1){
            $this->db->select('id, fbPageName');
            $this->db->where('isActive',true);
            $query = $this->db->get('pages');
            return ($query->num_rows() > 0)?$query->result_array():array();
        } 
        else{
            $this->db->select('id, fbPageName');
            $this->db->where('userId',$user_id);
            $this->db->where('isActive',true);
            $query = $this->db->get('pages');
            return ($query->num_rows() > 0)?$query->result_array():array();
        }
    }
    public function get_groups_for_user($user_id) {
        $this->db->from('users');
        $this->db->where('id', $user_id); 
        $queryResult = $this->db->get();
        $role_id =  $queryResult->row('roleId');
        if($role_id == 1){
            $this->db->select('id, name');
            $this->db->where('isActive',true);
            $query = $this->db->get('groups');
            return ($query->num_rows() > 0)?$query->result_array():array();
        } 
        else{
            $this->db->select('id, name');
            $this->db->where('userId',$user_id);
            $this->db->where('isActive',true);
            $query = $this->db->get('groups');
            return ($query->num_rows() > 0)?$query->result_array():array();
        }
    }
    
    public function get_groups_for_post($post_id){

        $query = $this->db->query('select distinct groups.id, groups.name from groups join groups_in_post on groups.id=groups_in_post.groupId where groups_in_post.postId = ' . $post_id);
        return ($query->num_rows() > 0)?$query->result_array():array();
    }

    public function get_pages_for_group_in_post($post_id,$group_id){
        $query = $this->db->query('select p.id, p.fbPageName from groups_in_post ginp join pages p on ginp.pageId = p.id 
        where ginp.groupId = ' . $group_id . ' and ginp.postId = ' . $post_id);
        return ($query->num_rows() > 0)?$query->result_array():array();

    }



    public function get_pages_for_group($group_id) {
        $query= $this->db->query('select p.id, p.fbPageName from pages_groups  pg join pages p on pg.pageId = p.id where pg.groupId = ' . $group_id);
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
    public function get_pages_added_by_hand_for_post_with_fbid_and_fbAT($post_id){

        $this->db->where('page_by_hand_in_post.postId=', $post_id);
        $this->db->select('page_by_hand_in_post.pageId, pages.fbPageId, pages.fbPageAT ');
        $this->db->from('page_by_hand_in_post');
        $this->db->join('pages', 'page_by_hand_in_post.pageId = pages.id');
        $query = $this->db->get();
        
        return ($query->num_rows() > 0)?$query->result_array():array();
    }
    public function get_user_token($user_id){
        $this->db->where("user_id=",$user_id);
        $query = $this->db->get('fb_users');

        return ($query->num_rows() > 0)?$query->result_array():array();
    }

    public function get_pages_tokens($user_id){

        $this->db->where('pages.IsActive = ', 1);
        $this->db->select('pages.*');
        $this->db->from('fb_users');
        $this->db->join('pages', 'fb_users.user_id = pages.userId');
        $this->db->where('fb_users.user_id=', $user_id);
        $query = $this->db->get();
        
        return ($query->num_rows() > 0)?$query->result_array():array();


    }
}