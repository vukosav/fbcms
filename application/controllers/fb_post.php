<?php
class Fb_post extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->helper('url_helper');
            $this->load->model('FB_model');
            $this->load->model('Users_model');
  }

  public function index($post_id){ 
      //echo $post_id;
    //$post_id =0 or >0
   
    if($this->Users_model->isLoggedIn()){

        $user_id = $this->session->userdata('user')['user_id'];
        
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

            $res = $this->FB_model->get_groups_for_user($user_id);
            $user_groups = (is_array($res)) ? array_values($res) : null;

            $res = $this->FB_model->get_pages_for_user($user_id);
            $user_pages = (is_array($res)) ? array_values($res) : null;

            $input_post_image_list="";
            $image_list="";

            /*$res = $this->fb_model->get_groups_for_user($user_id);
            $user_groups = (is_array($res)) ? array_values($res) : null;*/

            $res = $this->FB_model->get_pages_for_user($user_id);
            $user_pages = (is_array($res)) ? array_values($res) : null;


        }
        else {
        //get data from database for post_id = $post_id
        $image_list="";
                 
            $this->load->helper('form');
            //$this->load->helper('url');
            
            $post_data =  $this->FB_model->get_post_data($post_id);
           // var_dump($post_data);
           
                if(count( $post_data)==1) {
                    $input_post_type = $post_data[0]["post_type"];
                    $input_post_title=$post_data[0]["title"];

                   // echo '$input_post_title ' . $input_post_title;
                    $input_post_message=$post_data[0]["content"];
                    
                    $input_post_link="";
                    $input_post_name="";
                    $input_post_caption="";
                    $input_post_description="";
    
                    $input_post_picture="";
                    $input_post_video="";
                    //to do - ubaciti u bazu novu kolonu ???
                    $input_post_fb_preset_id=0;
               
                    //ovo ne treba ovdje
                    $fbaccountDetails="";
                    $fbaccountDetails_fb_id = "";    
                    $fbaccountDetails_firstname = "Page";
                    $fbaccountDetails_lastname = "Name";

                    if($input_post_type=='link') {
                        $post_attachment_data = $this->FB_model->get_post_attachments($post_id,'link');
                        $input_post_link=$post_attachment_data[0]["attach_location"];
                       
                    }
                    if ($input_post_type=='video') {
                        $post_attachment_data = $this->FB_model->get_post_attachments($post_id,'video');
                        $input_post_video = $post_attachment_data[0]["attach_location"];

                    }
                    if ($input_post_type=='image') { 

                        $post_attachment_data = $this->FB_model->get_post_attachments($post_id,'image');

                        $num_of_images = count($post_attachment_data); 
                        $image_list=$post_attachment_data[0]["attach_location"];
                        if($num_of_images>0){
                            for ($i = 1; $i <= $num_of_images-1; $i++) {
                                $image_list = $image_list . ','  . $post_attachment_data[$i]["attach_location"];
                            }
                        }
                       //echo $image_list; 
                    }      
                //to do: get pages and groups set for post; compare user_id in session and in table
                //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

                /*$res = $this->fb_model->get_groups_for_user($user_id);
                $user_groups = (is_array($res)) ? array_values($res) : null;*/

                $res = $this->FB_model->get_pages_for_user($user_id);
                $user_pages = (is_array($res)) ? array_values($res) : null;

                //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

                }
                else {echo "error count !=1";}
    }
      $queued_post=false; // hiding PAUSE,RESUME
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
                'fbaccountDetails_lastname' => $fbaccountDetails_lastname,
                //'user_groups' => $user_groups,
                'user_pages' => $user_pages,
                'input_post_image_list' => $image_list
           );
      
        //   var_dump($data);
        $this->load->view('post/edit_post_view', $data);
    }
    else {      
      redirect('login'); 
    }
}  
public function test_echo(){
   echo 'rewrwerew';
   /* echo json_encode(array(
        'error' => true,
        'message' => 'validacija',
        'id' => $res
        ));*/
}
public function insert_post(){
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        
        
        if($this->Users_model->isLoggedIn()){

            $this->form_validation->set_rules(
                'postTitle', 'Post title',
                'trim|required',
                array(
                        'required'      => 'You have not provided %s.'
                )
            );

            $this->form_validation->set_rules(
                'message', 'Message text',
                'trim|required',
                array(
                        'required'      => 'You have not provided %s.'
                )
            );

           /* TODO
           $this->form_validation->set_rules(
                'selected_page_id', 'any Page to post on!',
                'trim|required',
                array(
                        'required'      => 'You have not selected %s.'
                )
            );*/


            $user_id = $this->session->userdata('user')['user_id'];

            $post_id=$this->input->post('postId'); 

            $post_type=$this->input->post('postType');
            $post_status=$this->input->post('postStatus');
            $w_title=$this->input->post('postTitle'); 
            $message = $this->input->post('message');
            //$upload_img=$this->input->post('imageURL'); 
            $upload_images_list = $this->input->post('file_list');

            $upload_video = $this->input->post('videoFileName');
            $add_link=$this->input->post('link');
            
            //page(s) to publish post on
            $selected_page_id = $this->input->post('selected_page_id'); 

            $input_post_fb_preset_id=0;
            $queued_post=false; // hiding PAUSE,RESUME
            $fbaccountDetails='';

            $data=array(
                      'user_id' => $user_id,
                      'queued_post' => $queued_post,
                      'input_post_type' => $post_type,
                      'input_post_id' => $post_id,
                      'input_post_title' => $w_title,
                      'input_post_message' => $message,                
                      'input_post_link' => $add_link,
                      'input_post_picture' =>$upload_images_list,
                      'input_post_video' => $upload_video,
                      //'input_post_name' => $input_post_name,
                      //'input_post_caption' => $input_post_caption,
                      //'input_post_description' => $input_post_description,
                      'input_post_fb_preset_id' => $input_post_fb_preset_id,
                      'fbaccountDetails' =>  $fbaccountDetails,
                      'fbaccountDetails_fb_id' => '104189817385560', //$fbaccountDetails_fb_id,
                      'fbaccountDetails_firstname' => 'Page',//$fbaccountDetails_firstname,
                      'fbaccountDetails_lastname' => 'Name', //$fbaccountDetails_lastname,
                      //'user_groups' => $user_groups,
                      //'user_pages' => $selected_page_id,
                      'input_post_image_list' => $upload_images_list,
                      'selected_page_id' => $selected_page_id
                 );


            if ($this->form_validation->run() === FALSE){
                //$data['title'] = 'Users';
                //$data['users'] = false;
                //$this->load->view('post/edit_post_view', $data);
                echo json_encode(array(
                    'error' => true,
                    'message' => 'validacija',
                    'id' => $res
                    ));
            }else{
            
                    if($post_id==0) {
                        $res= $this->FB_model->insert_post($user_id, $selected_page_id, $w_title, $post_type, $message, $upload_video, $add_link, $upload_images_list);
                                    
                       // echo 'Inserted Post id: ' . $res;

                        echo json_encode(array(
                            'error' => false,
                            'message' => 'OK',
                            'id' => $res
                            ));
                    } 
                    else{
                        $this->FB_model->update_post($user_id, $selected_page_id, $w_title, $post_type, $message, $upload_video, $add_link, $upload_images_list);
                    }
                    //redirect ('');
            }        
        }
        else {
            //not logged in
            redirect ('login');
            
        }
    }

}