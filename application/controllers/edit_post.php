<?php

class Edit_Post extends CI_Controller {

    public function __construct()  {
         parent::__construct();
         $this->load->helper('url_helper');
         $this->load->model('pages_model');
         $this->load->model('post_model');
    }

    public function index(){

   
            $user_id=1;

            $data=array();

            $queued_post=false;
            $input_post_type="link";
            $input_post_id="";
            $input_post_message="";


            $post_row_type="";
            $input_post_link="";

            $input_post_picture="";
            $input_post_video="";

            $input_post_name="";
            $input_post_caption="";
            $input_post_description="";

            $input_post_fb_preset_id=1;

            $fbaccountDetails="";
            $fbaccountDetails_fb_id = "";
            $fbaccountDetails_firstname = "Page";
            $fbaccountDetails_lastname = "Name";

           
           $data=array(
                'user_id' => $user_id,
                'queued_post' => $queued_post,
                'input_post_type' => $input_post_type,
                'input_post_id' => $input_post_id,
                'input_post_message' => $input_post_message,
                'post_row_type' => $post_row_type,
                'input_post_link' => $input_post_link,
                'input_post_picture' =>$input_post_picture,
                'input_post_video' => $input_post_video,
                'input_post_name' => $input_post_name,
                'input_post_caption' => $input_post_caption,
                'input_post_description' => $input_post_description,
                'input_post_fb_preset_id' => $input_post_fb_preset_id,
                'fbaccountDetails' =>  $fbaccountDetails,
                'fbaccountDetails_fb_id' => $fbaccountDetails_fb_id,
                'fbaccountDetails_firstname' => $fbaccountDetails_firstname,
                'fbaccountDetails_lastname' => $fbaccountDetails_lastname
           );
           
           $this->load->view('post/edit_post_view', $data);
        }
      // else {
           //todo - redirect ...
        //      echo 'no user logged in';
      // }


    }
    


?> 

