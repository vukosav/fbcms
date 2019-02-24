<?php

class FB_Post extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->helper('url_helper');
            $this->load->model('fb_model');
            //$this->load->model('post_model');
  }

  public function index($post_id){ 
    //$post_id =0 or >0
    $_SESSION['user_id']=1;

    if(isset($_SESSION['user_id'])){       

      $user_id = $_SESSION['user_id'];

      if($post_id==0){
        
            //prepare default parameters for new post
            
            $queued_post=false; // hiding PAUSE,RESUME
            
            $input_post_type="message";
        
            $input_post_title="";

            $input_post_message="";
              
            $input_post_link="";
            $input_post_name="";
            $input_post_caption="";
            $input_post_description="";

            $input_post_picture="";
            $input_post_video="";

            $input_post_fb_preset_id=0;

            $fbaccountDetails="";
            $fbaccountDetails_fb_id = "";

            $fbaccountDetails_firstname = "Page";
            $fbaccountDetails_lastname = "Name";

      }
      else {
        //get data from database for $post_id

        $queued_post=false; // hiding PAUSE,RESUME
            
            $input_post_type="message";
        
            $input_post_title="";

            $input_post_message="";
              
            $input_post_link="";
            $input_post_name="";
            $input_post_caption="";
            $input_post_description="";

            $input_post_picture="";
            $input_post_video="";

            $input_post_fb_preset_id=0;

            $fbaccountDetails="";
            $fbaccountDetails_fb_id = "";

            $fbaccountDetails_firstname = "Page";
            $fbaccountDetails_lastname = "Name";

      }

      $data=array(
                'user_id' => $user_id,
                'queued_post' => $queued_post,
                'input_post_type' => $input_post_type,
                'input_post_id' => $post_id,
                'input_post_title' => $input_post_title,
                'input_post_message' => $input_post_message,                
                'input_post_link' => $input_post_link,
                'input_post_picture' =>$input_post_picture,
                'input_post_video' => $input_post_video,
                'input_post_name' => $input_post_name,
                'input_post_caption' => $input_post_caption,
                'input_post_description' => $input_post_description,
                'input_post_fb_preset_id' => $input_post_fb_preset_id,
                'fbaccountDetails' =>  $fbaccountDetails,
                'fbaccountDetails_fb_id' => '104189817385560', //$fbaccountDetails_fb_id,
                'fbaccountDetails_firstname' => $fbaccountDetails_firstname,
                'fbaccountDetails_lastname' => $fbaccountDetails_lastname
           );
      
           
           $this->load->view('post/edit_post_view', $data);
    }
    else {      
      redirect('login'); 
    }
    
  }


    public function insert_post($post_id){
        $this->load->helper(array('form', 'url'));
        
        
        
        if(isset($_SESSION['user_id'])){
            
            $user_id=$_SESSION['user_id'];
            
            
           
                $post_type=$this->input->post('postType');
                $post_status=$this->input->post('postStatus');
            
                $w_title=$this->input->post('postTitle'); 
            
                $message = $this->input->post('message');
                $upload_img=$this->input->post('imageURL'); 
                $upload_video = $this->input->post('video');
                $add_link=$this->input->post('link');
               

            if($post_id==0) {
                $res= $this->fb_model->insert_post($user_id, $w_title, $post_type, $message, $upload_img, $upload_video, $add_link);
                             
            echo 'Inserted Post id: ' . $res;
            } 
            else{
                $this->fb_model->update_post($user_id, $w_title, $post_type, $message, $upload_img, $upload_video, $add_link);
            }

            //redirect ('');
        }
        else {
            
            redirect ('login');
            
        }
    }

}