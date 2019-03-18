<?php
class Send_from_queue extends CI_Controller {

    public function __construct(){
        
                parent::__construct();
                $this->load->helper('url_helper');
                $this->load->model('FB_model');
                //$this->load->model('Users_model');
    }


        private function send_message($queue_id, $fb,$post_id,$input_post_title,$input_post_message,$fbPageId,$fbPageAT){
                $res =  array(
                    'error' => false,
                    'message' => '',
                    'f_post_id' => ''
                );
            try {
                $response = $fb->post('/' . $fbPageId . '/feed',array ( 'message' => $input_post_message,), $fbPageAT);
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
        private function send_link_message($queue_id,$fb,$post_id,$input_post_title,$input_post_message,$fbPageId, $fbPageAT){
            $res =  array(
                'error' => false,
                'message' => '',
                'f_post_id' => ''
            );
            $post_attachment_data = $this->FB_model->get_post_attachments($post_id,'link');
            $input_post_link=$post_attachment_data[0]["attach_location"];
            try {
                $response = $fb->post('/' . $fbPageId . '/feed',
                array (
                    'message' => $input_post_message,
                    'link' => $input_post_link,
                    ),
                    $fbPageAT);
                    $res['message'] = "Your post has been sent to facebook.";
                } catch(Facebook\Exceptions\FacebookResponseException $e) {
                        
                            $res['error'] = true;
                            $res['message'] = $e->getMessage();
                            
                } catch(Facebook\Exceptions\FacebookSDKException $e) {
                            $res['error'] = true;
                            $res['message'] = $e->getMessage(); 
                }
                $graphNode = $response->getGraphNode();
                $fb_post_id = $graphNode['id'];
                $res['f_post_id'] = $fb_post_id;
                return $res;
                
                }
        private function send_image_message($queue_id,$fb,$post_id,$input_post_title,$input_post_message,$fbPageId,$fbPageAT){
            $res =  array(
                'error' => false,
                'message' => '',
                'f_post_id' => ''
            );
            $post_attachment_data = $this->FB_model->get_post_attachments($post_id,'image');
            $num_of_images = count($post_attachment_data); 
            if($num_of_images>0){
                    $array_for_send= array('message' => $input_post_message);
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
       
       
       
       
        private function send_video_message($queue_id,$fb,$post_id,$input_post_title,$input_post_message,$fbPageId,$fbPageAT){
            $res =  array(
                'error' => false,
                'message' => '',
                'f_post_id' => ''
            );
            $post_attachment_data = $this->FB_model->get_post_attachments($post_id,'video');
            try {
                        $response = $fb->post('/' . $fbPageId . '/videos',
                        array (
                            'title'  => $input_post_title,
                            'description' => $input_post_message,
                            'source'  => $fb->videoToUpload('./uploads/' . $post_attachment_data[0]["attach_location"]),
                        ),
                        $fbPageAT
                    );
                    $res['message'] = "Your post has been sent to facebook.";
                    $graphNode = $response->getGraphNode();
                    $fb_post_id = $graphNode['id'];
                    $res['f_post_id'] = $fb_post_id;
                } catch(Facebook\Exceptions\FacebookResponseException $e) {
                    $res['error'] = true;
                    $res['message'] = $e->getMessage();
                } catch(Facebook\Exceptions\FacebookSDKException $e) {
                    $res['error'] = true;
                    $res['message'] = $e->getMessage();
                }
                return $res;
            }
        

        
        
        
        
   


      
      
      
      
      
      
public function index($queue_id){
          if (!isset($_SESSION)) { session_start();}  

        require_once FCPATH . '/vendor/autoload.php'; // change path as needed  

        $fb = new \Facebook\Facebook([
        'app_id' => '503878473471513',
        'app_secret' => '28cbbb9f440b1b016e9ce54376ada17e',
        'default_graph_version' => 'v3.2'
        ]);
    
 
        
        $ress=$this->FB_model->get_post_page_for_queue_id($queue_id);
        $dat_array_db = array_values($ress);
        $fbPageId = $dat_array_db[0]['fbPageId'];
        $fbPageAT= $dat_array_db[0]['fbPageAT'];
        $post_id = $dat_array_db[0]['postId'];

        $post_data =  $this->FB_model->get_post_data($post_id);

        $input_post_type = $post_data[0]["post_type"];
        $input_post_title=$post_data[0]["title"];
        $input_post_message=$post_data[0]["content"];
        
        
         if($input_post_type=='message'){
            $res = $this->send_message($queue_id,$fb,$post_id,$input_post_title,$input_post_message,$fbPageId,$fbPageAT);
        }
        elseif($input_post_type=='link') {
            $res = $this->send_link_message($queue_id,$fb,$post_id,$input_post_title,$input_post_message,$fbPageId,$fbPageAT);
        }    
        elseif ($input_post_type=='image') { 
            $res = $this->send_image_message($queue_id,$fb,$post_id,$input_post_title,$input_post_message,$fbPageId,$fbPageAT);
        }     
        elseif ($input_post_type=='video') { 
            $res = $this->send_video_message($queue_id,$fb,$post_id,$input_post_title,$input_post_message,$fbPageId,$fbPageAT);
        }
         echo json_encode($res);  
    }
}
    
?>