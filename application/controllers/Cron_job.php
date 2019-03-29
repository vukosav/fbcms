<?php
require_once FCPATH . '/vendor/autoload.php'; 
class Cron_job extends CI_Controller {
   
    public function __construct()
    {
            parent::__construct();
            
            $this->load->helper('url_helper');
             $this->load->model('FB_model');
    }
private function send_message($queue_id, $fb,$post_id,$input_post_title,$input_post_message,$fbPageId,$fbPageAT, $is_scheduled,$schedule_dt){
        $res =  array(
            'error' => false,
            'message' => '',
            'f_post_id' => ''
        );
    try {
        if($is_scheduled){
                $posting_array=array( 
                        'message' => $input_post_message,
                        'scheduled_publish_time'  => $schedule_dt, 
                        'published' => 'false'
                );
            }
            else {
                $posting_array=array( 'message' => $input_post_message);
            }
        $response = $fb->post('/' . $fbPageId . '/feed',$posting_array/*array ( 'message' => $input_post_message,)*/, $fbPageAT);
        $res['message'] = "Your post has been sent to facebook.";
        $graphNode = $response->getGraphNode();
        $fb_post_id = $graphNode['id'];
        $res['f_post_id'] = $fb_post_id;
        if($fb_post_id>0) {
        $res_fb = $this->FB_model->update_posting_with_fbPostId($queue_id, $fb_post_id);
    }
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        $res['error'] = true;
        $res['message'] = $e->getMessage();
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
            $res['error'] = true;
            $res['message'] = $e->getMessage();
    }
    var_dump($res);
    return $res;
    }
private function send_link_message($queue_id,$fb,$post_id,$input_post_title,$input_post_message,$fbPageId, $fbPageAT, $is_scheduled,$schedule_dt){
    $res =  array(
        'error' => false,
        'message' => '',
        'f_post_id' => ''
    );
    $post_attachment_data = $this->FB_model->get_post_attachments($post_id,'link');
    $input_post_link=$post_attachment_data[0]["attach_location"];
    try {
        if($is_scheduled){
                $posting_array=array( 
                        'message' => $input_post_message,
                        'scheduled_publish_time'  => $schedule_dt, 
                        'published' => 'false',
                        'link' => $input_post_link
                );
            }
            else {
                $posting_array=array( 'message' => $input_post_message,'link' => $input_post_link);
            }
        $response = $fb->post('/' . $fbPageId . '/feed',
        $posting_array/*array (
            'message' => $input_post_message,
            'link' => $input_post_link,
            )*/,
            $fbPageAT);
            $res['message'] = "Your post has been sent to facebook.";
             $graphNode = $response->getGraphNode();
             $fb_post_id = $graphNode['id'];
             $res['f_post_id'] = $fb_post_id;
             if($fb_post_id>0) {
                $res_fb = $this->FB_model->update_posting_with_fbPostId($queue_id, $fb_post_id);
            }
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
                
                    $res['error'] = true;
                    $res['message'] = $e->getMessage();
                    
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
                    $res['error'] = true;
                    $res['message'] = $e->getMessage(); 
        }
       
        
        return $res;
        
        }
private function send_image_message($queue_id,$fb,$post_id,$input_post_title,$input_post_message,$fbPageId,$fbPageAT, $is_scheduled,$schedule_dt){
    $res =  array(
        'error' => false,
        'message' => '',
        'f_post_id' => ''
    );
    $post_attachment_data = $this->FB_model->get_post_attachments($post_id,'image');
    $num_of_images = count($post_attachment_data); 
    if($num_of_images>0){
        if($is_scheduled){
                $array_for_send=array( 
                        'message' => $input_post_message,
                        'scheduled_publish_time'  => $schedule_dt, 
                        'published' => 'false'
                );
            }
            else {
                $array_for_send=array( 'message' => $input_post_message);
            }
            //$array_for_send= array('message' => $input_post_message);
            for ($i = 0; $i < $num_of_images; $i++) {                                    
                    try {
                        $response = $fb->post('/' . $fbPageId . '/photos',
                        array (
                            'message' => $input_post_message,
                            'published' => 'false',
                            'source'  => $fb->fileToUpload('./uploads/' . $post_attachment_data[$i]["attach_location"]),
                        ),
                        $fbPageAT
                    );
                } catch(Facebook\Exceptions\FacebookResponseException $e) {
                    $res['error'] = true;
                    $res['message'] = $e->getMessage();
                    return $res;  
                } catch(Facebook\Exceptions\FacebookSDKException $e) {
                    $res['error'] = true;
                    $res['message'] = $e->getMessage();
                    return $res;  
                }
                $graphNode = $response->getGraphNode();
                $array_for_send[ 'attached_media[' . $i  .']'] =  '{"media_fbid":"' . $graphNode['id'] . '"}';
            }
            try {
               
                $response = $fb->post('/' . $fbPageId . '/feed',$array_for_send, $fbPageAT);
                $graphNode = $response->getGraphNode();
                    $fb_post_id = $graphNode['id'];
                    $res['f_post_id'] = $fb_post_id;
                    $res['message'] = "Your post has been sent to facebook.";
                    $graphNode = $response->getGraphNode();
                    $fb_post_id = $graphNode['id'];
                    $res['f_post_id'] = $fb_post_id;
                    if($fb_post_id>0) {
                        $res_fb = $this->FB_model->update_posting_with_fbPostId($queue_id, $fb_post_id);
                    }
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                $res['error'] = true;
                $res['message'] = $e->getMessage();
                
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                $res['error'] = true;
                $res['message'] = $e->getMessage();
            }
    
      }

     return $res;        
  }







private function send_video_message($queue_id,$fb,$post_id,$input_post_title,$input_post_message,$fbPageId,$fbPageAT, $is_scheduled,$schedule_dt){
    $res =  array(
        'error' => false,
        'message' => '',
        'f_post_id' => ''
    );
    $post_attachment_data = $this->FB_model->get_post_attachments($post_id,'video');
    try {
        if($is_scheduled){
                $posting_array=array( 
                        'title'  => $input_post_title,
                        'description' => $input_post_message,
                        'source'  => $fb->videoToUpload('./uploads/' . $post_attachment_data[0]["attach_location"]),
                        'scheduled_publish_time'  => $schedule_dt, 
                        'published' => 'false'
                );
            }
            else {
                $posting_array=array(  
                        'title'  => $input_post_title,
                        'description' => $input_post_message,
                        'source'  => $fb->videoToUpload('./uploads/' . $post_attachment_data[0]["attach_location"])
                        );
                }
                $response = $fb->post('/' . $fbPageId . '/videos',
                $posting_array/*array (
                    'title'  => $input_post_title,
                    'description' => $input_post_message,
                    'source'  => $fb->videoToUpload('./uploads/' . $post_attachment_data[0]["attach_location"]),
                )*/,
                $fbPageAT
            );
            $res['message'] = "Your post has been sent to facebook.";
            $graphNode = $response->getGraphNode();
            $fb_post_id = $graphNode['id'];
            $res['f_post_id'] = $fb_post_id;
            if($fb_post_id>0) {
               $res_fb = $this->FB_model->update_posting_with_fbPostId($queue_id, $fb_post_id);
           }
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            $res['error'] = true;
            $res['message'] = $e->getMessage();
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            $res['error'] = true;
            $res['message'] = $e->getMessage();
        }
        return $res;
    }

    


    public function InsertToFB($fb,$queue_id){
        if (!isset($_SESSION)) { session_start();}  

     // require_once FCPATH . '/vendor/autoload.php'; // change path as needed  

    //   $fb = new \Facebook\Facebook([
    //   'app_id' => FB_APP_ID,
    //   'app_secret' => FB_APP_SECRET,
    //   'default_graph_version' => FB_API_VERSION
    //   ]);
  

      
      $ress=$this->FB_model->get_post_page_for_queue_id($queue_id);
      $dat_array_db = array_values($ress);
      $fbPageId = $dat_array_db[0]['fbPageId'];
      $fbPageAT= $dat_array_db[0]['fbPageAT'];
      $post_id = $dat_array_db[0]['postId'];
      $page_timezone = $dat_array_db[0]['timezone'];

      $post_data =  $this->FB_model->get_post_data($post_id);

      $input_post_type = $post_data[0]["post_type"];
      $input_post_title=$post_data[0]["title"];
      $input_post_message=$post_data[0]["content"];
      $is_scheduled = $post_data[0]["isScheduled"];
      $scheduledSame=$post_data[0]["scheduledSame"];
      $scheduleTimeUTC=$post_data[0]["scheduleTimeUTC"];
      $user_id = $post_data[0]["created_by"];

        $this->db->select('App_time_zone'); 
        $query = $this->db->get('global_parameters');
        $app_TZ = $query->result_array()[0]['App_time_zone'];

        $this->db->where('users.id=', $user_id);
        $this->db->select('timezone');
        $this->db->from('users');
        $query = $this->db->get();        
        $user_timezone=$query->result_array()[0]['timezone'];

        // if($is_scheduled == 1){
        //     $timezone = $page_timezone;
        //     if($timezone == null || $timezone == ''){
        //         $timezone = $app_TZ;
        //     }
        //     if($scheduledSame == 1){
        //         $timezone = $app_TZ;
        //     }

        //     $schedule_date =  new DateTime($post_data[0]["scheduledTime"]);
        //     $schedule_date->setTimezone(new DateTimeZone($timezone));
        //     $schedule_dt = strtotime( $schedule_date->format('Y-m-d H:i:s')/*$post_data[0]["scheduledTime"]*/);
        // }else{
        //    $schedule_dt=null;
        // }
        // $schedule_dt = null;
       if($input_post_type=='message'){
          $res = $this->send_message($queue_id,$fb,$post_id,$input_post_title,$input_post_message,$fbPageId,$fbPageAT, $is_scheduled,$scheduleTimeUTC);
      }
      elseif($input_post_type=='link') {
          $res = $this->send_link_message($queue_id,$fb,$post_id,$input_post_title,$input_post_message,$fbPageId,$fbPageAT, $is_scheduled,$scheduleTimeUTC);
      }    
      elseif ($input_post_type=='image') { 
          $res = $this->send_image_message($queue_id,$fb,$post_id,$input_post_title,$input_post_message,$fbPageId,$fbPageAT, $is_scheduled,$scheduleTimeUTC);
      }     
      elseif ($input_post_type=='video') { 
          $res = $this->send_video_message($queue_id,$fb,$post_id,$input_post_title,$input_post_message,$fbPageId,$fbPageAT, $is_scheduled,$scheduleTimeUTC);
      }
      return $res;  
  }



  public function update_posting($fb,$queue_id) {
        if (!isset($_SESSION)) { session_start();}  

       // require_once FCPATH . '/vendor/autoload.php'; // change path as needed  
  
        // $fb = new \Facebook\Facebook([
        // 'app_id' => '503878473471513',
        // 'app_secret' => '28cbbb9f440b1b016e9ce54376ada17e',
        // 'default_graph_version' => 'v3.2'
        // ]);
        $res =  array(
                'error' => false,
                'message' => '',
                'f_post_id' => ''
            );
        $ress=$this->FB_model->get_post_page_for_queue_id($queue_id);
        $dat_array_db = array_values($ress);
        
        //$fbPageId = $dat_array_db[0]['fbPageId'];
        $fbPageAT= $dat_array_db[0]['fbPageAT'];
        $fbPostId = $dat_array_db[0]['fbPostId'];
        $post_id = $dat_array_db[0]['postId'];
    
        $post_data =  $this->FB_model->get_post_data($post_id);

       $input_post_type = $post_data[0]["post_type"];
       //  $input_post_title=$post_data[0]["title"];
        $input_post_message=$post_data[0]["content"];
        
        if($input_post_type=='video'){
                try {
                    // Returns a `Facebook\FacebookResponse` object
                    $response = $fb->post(
                        '/' . $fbPostId,
                        array (
                       'description' => $input_post_message,                        
                        ),
                        $fbPageAT
                    ); 
                    //$graphNode = $response->getGraphNode();
                    $res['message'] = "Your post has been updated to facebook.";
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                    $res['error'] = true;
                    $res['message'] = $e->getMessage();
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                    $res['error'] = true;
                    $res['message'] = $e->getMessage();
            }
        }
            else 
        {
            try {
                    // Returns a `Facebook\FacebookResponse` object
                    $response = $fb->post(
                        '/' . $fbPostId,
                        array (
                        'message' => $input_post_message,
                        ),
                        $fbPageAT
                    ); 
                    //$graphNode = $response->getGraphNode();
                    $res['message'] = "Your post has been updated to facebook.";
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                    $res['error'] = true;
                    $res['message'] = $e->getMessage();
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                    $res['error'] = true;
                    $res['message'] = $e->getMessage();
            }
        }
    
        return $res;
      
    }

    
    public function delete_posting($fb,$queue_id){
        if (!isset($_SESSION)) { session_start();}  

        //require_once FCPATH . '/vendor/autoload.php'; // change path as needed  
  
        // $fb = new \Facebook\Facebook([
        // 'app_id' => '503878473471513',
        // 'app_secret' => '28cbbb9f440b1b016e9ce54376ada17e',
        // 'default_graph_version' => 'v3.2'
        // ]);
        $res =  array(
                'error' => false,
                'message' => '',
                'f_post_id' => ''
            );
        $ress=$this->FB_model->get_post_page_for_queue_id($queue_id);
        $dat_array_db = array_values($ress);
        
        //$fbPageId = $dat_array_db[0]['fbPageId'];
        $fbPageAT= $dat_array_db[0]['fbPageAT'];
        $post_id = $dat_array_db[0]['fbPostId'];

             //delete a posting with post_id on page with page_at
             try {
                // Returns a `Facebook\FacebookResponse` object
                        $response = $fb->delete(
                        '/' . $post_id,
                        array (),
                        $fbPageAT
                        );
                        $res['message'] = "Your post has been deleted from facebook.";
                } catch(Facebook\Exceptions\FacebookResponseException $e) {
                        $res['error'] = true;
                        $res['message'] = $e->getMessage();
                } catch(Facebook\Exceptions\FacebookSDKException $e) {
                        $res['error'] = true;
                        $res['message'] = $e->getMessage();
                }
                
            
                return $res;

    }


    public function delete_archive_posting($fb,$fbPageAT,  $fb_post_id){
        if (!isset($_SESSION)) { session_start();}  

        //require_once FCPATH . '/vendor/autoload.php'; // change path as needed  
  
        // $fb = new \Facebook\Facebook([
        // 'app_id' => '503878473471513',
        // 'app_secret' => '28cbbb9f440b1b016e9ce54376ada17e',
        // 'default_graph_version' => 'v3.2'
        // ]);
        $res =  array(
                'error' => false,
                'message' => '',
                'f_post_id' => ''
            );
        

             //delete a posting with post_id on page with page_at
             try {
                // Returns a `Facebook\FacebookResponse` object
                        $response = $fb->delete( '/' . $fb_post_id,array (),$fbPageAT);
                        $res['message'] = "Your post has been deleted from facebook.";
                } catch(Facebook\Exceptions\FacebookResponseException $e) {
                        $res['error'] = true;
                        $res['message'] = $e->getMessage();
                } catch(Facebook\Exceptions\FacebookSDKException $e) {
                        $res['error'] = true;
                        $res['message'] = $e->getMessage();
                }
                
            
                return $res;

    }




    public function start(){
            //kreiramo novi cron job
        $cron_job_error = "_ ";
        $cron_job_status = 1; // sve je ok, za gresku je 2
        $this->db->query("call NewCroneJob(@cr_job_id);");
        $cron_job_owner = $this->db->query("SELECT @cr_job_id;")->row('@cr_job_id');
        //cron job je kreiran
        //pripremljeni su job_thread-ovi i njima je owner_job upravo obvaj novokreirani cron_job
        
        // uzimamo ih iz db
        $data = $this->db->query("SELECT * FROM jobs_thread WHERE cron_job_id_owner = $cron_job_owner AND post_id_owner IS NULL AND  user_id_owner IS NULL");
        $data = $data->result_array();

        //za svaki thread_job
        foreach($data as $job_ids){
                //izvrsavamo ga ili pokrecemo jednu njegovu instancu
                $job_id = $job_ids['job_id'];
                $job_thread_result = $this->runThreadJob($job_id,$cron_job_owner); 
                if($job_thread_result['status']==2){
                        $cron_job_status = 2;
                        $cron_job_error= $cron_job_error . $job_thread_result['error'] . ";";
                }   
        }
        $cron_job_error="'" . $cron_job_error . "'";
       $this->db->query("call CroneJobFinish($cron_job_owner, $cron_job_error,  $cron_job_status);"); 
       $this->ArchiveJob();
    }

    public function runThreadJob($job_id,$cron_job_owner){
            
            // za svaki job_thread uzimamo element queue-a kojima je taj job setovan
            $data = $this->db->query("SELECT PS.id, PS.job_action 
                                        FROM  posts_pages  PS 
                                        JOIN posts P ON PS.postId = P.id 
                                        WHERE job_id = $job_id
                                        and P.PostStatus = 3
                                        and P.ActionStatus = 1
                                        and PS.postingStatus =  1
                                        and P.IsActive = 1 ");
            $data = $data->result_array();
            $job_status = 1; //sve je ok, za error stavljamo 2
            $job_error = '';
            //prolazimo kroz queue
            foreach($data as $qid){
                    $queue_id = $qid['id']; 
                    $type = $qid['job_action'];
                // ispitujemo da li je validan, to znaci da li je proslo dovoljno vremena
                // od prethodnog slanja ka fb-u za ovu stranu ili user-a, zavis sta je postavljeno u parametrima
                 
                    $valid =   $this->db->query("SELECT StartQueuedItem($queue_id,$cron_job_owner,$job_id) as validan");

                    $valid = $valid->result_array();

                if($valid[0]['validan'] == '0'){
                        // $task_end_status = 'i-o-i-' .  $type;
                        // $data = array(
                        //         'job_id' => $job_id,
                        //         'task_end_status' => $task_end_status,
                        //         'queue_id' => $queue_id,
                        //         'active' =>1
                        //     );
                        // $this->db->insert('task_to_finish', $data);
                    continue;
                }else{ 
                        //setujemo queue item da je ongoing
                        //$this->db->query("call OnGoing($queue_id);");
                        //saljemo request a fb-u(insert, update, delete)
                        $res =  $this->SendQueueItemToFB($queue_id, $type);
                         if($res['status']=="success"){
                                 //fb-OK
                                $this->db->query("call SetFinishedStatuse($queue_id);");
                         }else{
                                 //fb-Error
                                 $job_status = 2;
                                 $error ="'" . $res['error'] . "'";
                                 $job_error =  $job_error . $res['error'] . $queue_id . ",";
                                 $job_error = str_replace("'","_", $job_error);
                                $this->db->query("call SetErrorStatuse($queue_id,'$job_error');");
                         }
                          
                }
            }
            $this->db->query("call ThreadJobFinish($job_id);"); 
            return  array('status' =>  $job_status, 'error'=> $job_error);
    
       
    }
    
    public function SendQueueItemToFB($queue_id, $action){
              $fb = new \Facebook\Facebook([
                        'app_id' => FB_APP_ID,
                        'app_secret' => FB_APP_SECRET,
                        'default_graph_version' => FB_API_VERSION
                        ]);
        if($action == "1"){
                //sleep(5);
                try{
                $res = $this->InsertToFB($fb,$queue_id);
                }catch(Exception $e){
                       var_dump($e);
                }
                if($res['error']){
                   return array('status' => "error", 'error'=> $res['message']);
                }else{
                    return array('status' => "success", 'error'=> "");
               }
        }
        elseif($action == "2"){
            //    sleep(10);
                $res = $this->update_posting($fb,$queue_id);
                if($res['error']){
                 return array('status' => "error", 'error'=> $res['message']);
              }else{
               return array('status' => "success", 'error'=> "");
              }

        }elseif($action == "3"){
              //  sleep(10);
               $res = $this->delete_posting($fb,$queue_id);
               if($res['error']){
                return array('status' => "error", 'error'=> $res['message']);
             }else{
               return array('status' => "success", 'error'=> "");
             }
        }
       // return "success";
       // return "error";
     }

      public function ArchiveJob(){
        $data = $this->db->query("SELECT P.id  from  posts_archive  P  WHERE P.is_deleted_from_fb = 0");
        $data = $data->result_array();
        $job_status = 1; //sve je ok, za error stavljamo 2
        $job_error = '';
        //prolazimo kroz queue
        foreach($data as $qid){
                $this->DeleteArchiveFromDB( $qid['id']);
        }
      }
     public function DeleteArchiveFromDB($post_id){
        $fb = new \Facebook\Facebook([
            'app_id' => FB_APP_ID,
            'app_secret' => FB_APP_SECRET,
            'default_graph_version' => FB_API_VERSION
            ]);
        $data = $this->db->query("SELECT P.id post_id, PS.id, PS.fbPostId, pages.fbPageId, pages.fbPageAT
                                        FROM posts_pages_archive  PS 
                                        JOIN posts_archive P ON PS.postId = P.id 
                                        JOIN pages ON PS.pageId = pages.id
                                        WHERE P.id = $post_id and PS.fbPostId is not null");
        $data = $data->result_array();
        $job_status = 1; //sve je ok, za error stavljamo 2
        $job_error = '';
        //prolazimo kroz queue
        foreach($data as $qid){
                $fbPageAT = $qid['fbPageAT'];
                $fb_post_id =  $qid['fbPostId'];
                $post_id =  $qid['post_id'];
                $res = $this->delete_archive_posting($fb,$fbPageAT,  $fb_post_id);
                if($res['error']){ $job_status = 2;}
        }
         if($job_status == 1){
                $this->db->query("UPDATE posts_archive  SET is_deleted_from_fb = 1 WHERE id = $post_id");
         }
      }
} 