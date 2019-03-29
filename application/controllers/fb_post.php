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
        //new post - create post
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
            $post_status="";

            /*$res = $this->fb_model->get_groups_for_user($user_id);
            $user_groups = (is_array($res)) ? array_values($res) : null;*/

            $res = $this->FB_model->get_pages_for_user($user_id);
            $user_pages = (is_array($res)) ? array_values($res) : null;

            $res2 = $this->FB_model->get_groups_for_user($user_id);
            $user_groups = (is_array($res)) ? array_values($res2) : null;
            $ug_num=count($user_groups);

            for($j=0;$j <$ug_num; $j++){
                $res_pageforgroup = $this->FB_model->get_pages_for_group($user_groups[$j]['id']);
                $user_groups[$j]['pages'] = $res_pageforgroup ;
            }
            $is_scheduled=0;
            $schedule_date_time=null;

            $selected_page_id=0;
            $selected_group_id=0;            
            $selected_post_groups = 0;


        }
        else {
            //get data from database for post_id = $post_id
            $image_list="";
            
                    
            $this->load->helper('form');
            //$this->load->helper('url');
            
            $post_data =  $this->FB_model->get_post_data($post_id);
           // var_dump($post_data);
           
                if(count( $post_data)==1) {

                    $post_status=$post_data[0]["PostStatus"];

                    $input_post_type = $post_data[0]["post_type"];
                    $input_post_title=$post_data[0]["title"];
                 
                   // echo '$input_post_title ' . $input_post_title;
                    $input_post_message=$post_data[0]["content"];

                    $is_scheduled=$post_data[0]["isScheduled"];
                    if($is_scheduled==1){
                        $schedule_date_time = $post_data[0]["scheduledTime"];
                    }
                    else {
                        $schedule_date_time=null;
                    }
                    
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
                    }            
        

                    $resg = $this->FB_model->get_groups_for_user($user_id);
                    $user_groups = (is_array($resg)) ? array_values($resg) : null;
                    $ug_num=count($user_groups);

                    for($j=0;$j <$ug_num; $j++){
                        $res_pageforgroup = $this->FB_model->get_pages_for_group($user_groups[$j]['id']);
                        $user_groups[$j]['pages'] = $res_pageforgroup ;
                    }

                    $ressg=$this->FB_model->get_groups_for_post($post_id);
                    $selected_post_groups = (is_array($ressg)) ? array_values($ressg) : null;
                    $psg_num=count($selected_post_groups);

                    for($k=0;$k <$psg_num; $k++){
                        $res_pageforgroup_in_post = $this->FB_model->get_pages_for_group_in_post($post_id,$selected_post_groups[$k]['id']);
                        $selected_post_groups[$k]['pages'] = $res_pageforgroup_in_post ;
                    }

                    //$selected_group_id=0; 


                    $resp = $this->FB_model->get_pages_for_user($user_id);
                    $user_pages = (is_array($resp)) ? array_values($resp) : null;
                
                    //pages set for post
                    $selected_page_id=$this->FB_model->get_selected_pages_for_post($post_id);
                  

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
                'user_groups' => $user_groups,
                'user_pages' => $user_pages,
                'input_post_image_list' => $image_list,
                'isScheduled' => $is_scheduled,
                'scheduleDateTime' => $schedule_date_time,
                'post_status' => $post_status,
                'selected_page_id' => $selected_page_id,
                'selected_post_groups' => $selected_post_groups,
           );
      
        //   var_dump($data);
        $this->load->view('post/edit_post_view', $data);
    }
    else {      
      redirect('login'); 
    }
} 

public function create_post(){ 
  
    if($this->Users_model->isLoggedIn()){

            $user_id = $this->session->userdata('user')['user_id'];
              
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
            $post_status="";

            $res = $this->FB_model->get_pages_for_user($user_id);
            $user_pages = (is_array($res)) ? array_values($res) : null;

            $res2 = $this->FB_model->get_groups_for_user($user_id);
            $user_groups = (is_array($res)) ? array_values($res2) : null;
            $ug_num=count($user_groups);

            for($j=0;$j <$ug_num; $j++){
                $res_pageforgroup = $this->FB_model->get_pages_for_group($user_groups[$j]['id']);
                $user_groups[$j]['pages'] = $res_pageforgroup ;
            }
            $is_scheduled=0;
            $schedule_date_time=null;
            $scheduledSame=0;

            $selected_page_id=0;
            $selected_group_id=0;            
            $selected_post_groups = 0;

            $queued_post=false; // hiding PAUSE,RESUME
            $input_ins_or_upd = "insert";

            $can_edit_groups_pages="1";
            $can_save_as_draft="1";
            

            $post_id=0;

            $this->db->where('users.id=', $user_id);
            $this->db->select('timezone');
            $this->db->from('users');
            $query = $this->db->get();        
            $user_timezone=$query->result_array()[0]['timezone'];
            $this->db->select('App_time_zone'); 
            $query = $this->db->get('global_parameters');
            $app_TZ = $query->result_array()[0]['App_time_zone'];

            if($user_timezone == null){
                $user_timezone = $app_TZ;
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
                'hidden_post_video_name' =>'',
                'input_post_name' => $input_post_name,
                'input_post_caption' => $input_post_caption,
                'input_post_description' => $input_post_description,
                'input_post_fb_preset_id' => $input_post_fb_preset_id,
                'fbaccountDetails' =>  $fbaccountDetails,
                'fbaccountDetails_fb_id' => '104189817385560', //$fbaccountDetails_fb_id,
                'fbaccountDetails_firstname' => $fbaccountDetails_firstname,
                'fbaccountDetails_lastname' => $fbaccountDetails_lastname,
                'user_groups' => $user_groups,
                'user_pages' => $user_pages,
                'input_post_image_list' => $image_list,
                'isScheduled' => $is_scheduled,
                'scheduleDateTime' => $schedule_date_time,
                'scheduledSame' =>$scheduledSame,
                'post_status' => $post_status,
                'selected_page_id' => $selected_page_id,
                'selected_post_groups' => $selected_post_groups,
                'input_ins_or_upd' => $input_ins_or_upd,
                'can_save_as_draft' => $can_save_as_draft,
                'can_edit_groups_pages' => $can_edit_groups_pages,
                'timezone'=> $user_timezone,                
                'posting_nums' => "",
                'edit_post_title'  => "Create post",
                'edit_post_subtitle' => 'Create your creative content in the form of Text, image or link to be shared to your multiple connected Facebook pages'
               
            );
           
        $this->load->view('post/edit_post_view', $data);
    }
    else {      
      redirect('login'); 
    }
}


private function GetDataFromDB($post_id){
    $post_data =  $this->FB_model->get_post_data($post_id);
    // var_dump($post_data);
    if(count($post_data)==0){
        return array();
    } else {
    
        $image_list="";
        $post_status=$post_data[0]["PostStatus"];

       
        $input_post_type = $post_data[0]["post_type"];
        $input_post_title=$post_data[0]["title"];

        // echo '$input_post_title ' . $input_post_title;
        $input_post_message=$post_data[0]["content"];

        $is_scheduled=$post_data[0]["isScheduled"];
        if($is_scheduled==1){
            $schedule_date_time = $post_data[0]["scheduledTime"];
        }
        else {
            $schedule_date_time=null;
        }        
        $scheduledSame=$post_data[0]["scheduledSame"];

        $input_post_link="";
        $input_post_name="";
        $input_post_caption="";
        $input_post_description="";

        $input_post_picture="";
        $input_post_video="";
        $hidden_post_video_name="";
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
            $input_post_video = base_url() . 'uploads/' . $post_attachment_data[0]["attach_location"];
            $hidden_post_video_name = $post_attachment_data[0]["attach_location"];

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
        }            

        $user_id = $this->session->userdata('user')['user_id'];

        $resg = $this->FB_model->get_groups_for_user($user_id);
        $user_groups = (is_array($resg)) ? array_values($resg) : null;
        $ug_num=count($user_groups);

        for($j=0;$j <$ug_num; $j++){
            $res_pageforgroup = $this->FB_model->get_pages_for_group($user_groups[$j]['id']);
            $user_groups[$j]['pages'] = $res_pageforgroup ;
        }

        $ressg=$this->FB_model->get_groups_for_post($post_id);
        $selected_post_groups = (is_array($ressg)) ? array_values($ressg) : null;
        $psg_num=count($selected_post_groups);

        for($k=0;$k <$psg_num; $k++){
            $res_pageforgroup_in_post = $this->FB_model->get_pages_for_group_in_post($post_id,$selected_post_groups[$k]['id']);
            $selected_post_groups[$k]['pages'] = $res_pageforgroup_in_post ;
        }

         $resp = $this->FB_model->get_pages_for_user($user_id);
        $user_pages = (is_array($resp)) ? array_values($resp) : null;

        //pages set for post
        $selected_page_id=$this->FB_model->get_selected_pages_for_post($post_id);
    
        $can_edit_groups_pages="1";
        $can_save_as_draft="1";

        $queued_post=false; // hiding PAUSE,RESUME

        $inprogress_data = $this->db->query("select CountPages(" . $post_id . ") ukupno, 
        PostPagesStatCount(" . $post_id . ", 4) as error,
        PostPagesStatCount(" . $post_id . ", 3) as sent,
        PostPagesStatCount(" . $post_id . ", 2) as inProgres");  
        $inprogress_data = $inprogress_data->result_array();   
        
        
        $inp_ukupno = $inprogress_data[0]['ukupno'];
        $inp_sent = $inprogress_data[0]['sent'];
        $posting_nums="Posted: " . $inprogress_data[0]['sent'] . '/' . $inprogress_data[0]['ukupno'];


                
        $this->db->where('users.id=', $user_id);
        $this->db->select('timezone');
        $this->db->from('users');
        $query = $this->db->get();        
        $user_timezone=$query->result_array()[0]['timezone'];

        $this->db->select('App_time_zone'); 
        $query = $this->db->get('global_parameters');
        $app_TZ = $query->result_array()[0]['App_time_zone'];
       
        if($user_timezone == null){
            $user_timezone = $app_TZ;
        }
    $data=array(
        'user_id' => $user_id,
        'queued_post' => $queued_post,
        'input_post_type' => $input_post_type,
        'input_post_id' =>  $post_id,
        'input_post_title' => $input_post_title,
        'input_post_message' => $input_post_message,                
        'input_post_link' => $input_post_link,
        'input_post_picture' =>$input_post_picture,
        'input_post_video' => $input_post_video,
        'hidden_post_video_name' =>$hidden_post_video_name,
        'input_post_name' => $input_post_name,
        'input_post_caption' => $input_post_caption,
        'input_post_description' => $input_post_description,
        'input_post_fb_preset_id' => $input_post_fb_preset_id,
        'fbaccountDetails' =>  $fbaccountDetails,
        'fbaccountDetails_fb_id' => '104189817385560', //$fbaccountDetails_fb_id,
        'fbaccountDetails_firstname' => $fbaccountDetails_firstname,
        'fbaccountDetails_lastname' => $fbaccountDetails_lastname,
        'user_groups' => $user_groups,
        'user_pages' => $user_pages,
        'input_post_image_list' => $image_list,
        'isScheduled' => $is_scheduled,
        'scheduleDateTime' => $schedule_date_time,
        'scheduledSame'=> $scheduledSame,
        'post_status' => $post_status,
        'selected_page_id' => $selected_page_id,
        'selected_post_groups' => $selected_post_groups,
        "input_ins_or_upd"=>"",
        "can_save_as_draft" => $can_save_as_draft,
        "can_edit_groups_pages" => $can_edit_groups_pages,
        'timezone'=> $user_timezone,
        'posting_nums' => $posting_nums      

        
    );
    return $data;
    }
}   

public function edit_post($post_id){
    //echo $post_id;
    if(!$this->Users_model->isLoggedIn()){
        redirect('login'); 
    }
    $user_id = $this->session->userdata('user')['user_id'];

        //get data from database for post_id = $post_id
        $image_list="";$this->db->query("call PreEdit($post_id, $user_id);");
                    
                        
       $this->load->helper('form');
       //$this->load->helper('url');
       
       $data = $this->GetDataFromDB($post_id);
       $data['input_ins_or_upd'] = "update";

        if($data['post_status'] == 1){
            $data['edit_post_title'] = "Draft post";   
            $data['posting_nums'] = "";
        }

        else if($data['post_status'] == 4){
            $data['edit_post_title'] = "Sent post";    
        }
        else{
            $data['edit_post_title'] = "Post in progress/sent"; 
            $data['edit_post_subtitle'] = "Create your creative content in the form of Text, image or link to be shared to your multiple connected Facebook pages";
        }   
       

       $validd =  $this->db->query("SELECT CanSetAsDraft($post_id) as validan");
       $validd = $validd->result_array();
       $can_save_as_draft = 0;// $validd[0]['validan'];
      
       $data['can_save_as_draft'] = $can_save_as_draft;

       
       $valide= $this->db->query("SELECT CanEditPageAndGroups($post_id) as validan");
       $valide = $valide->result_array();
       $can_edit_groups_pages=$valide[0]['validan'];
       $data['can_edit_groups_pages'] = $can_edit_groups_pages;
       
       $this->load->view('post/edit_post_view', $data);
       
} 

public function copy_post($post_id){
    if(!$this->Users_model->isLoggedIn()){
        redirect('login'); 
    }
     

        //get data from database for post_id = $post_id
        //$image_list="";
                    
                        
        //$this->load->helper('form');
        //$this->load->helper('url');
        
       $data = $this->GetDataFromDB($post_id);
       $data['input_ins_or_upd'] = "insert";
       $data['scheduleDateTime'] = '';
       
      
       $data['edit_post_title'] = "Copy post";   
       $data['posting_nums'] = "";
       $data['edit_post_subtitle'] = "Create your creative content in the form of Text, image or link to be shared to your multiple connected Facebook pages";

       $this->load->view('post/edit_post_view', $data);
} 

public function cancel_edit_post($post_id){
    if($post_id > 0){
       $user = $this->session->userdata('user')['user_id'];
       $this->db->query("call CancelEdit($post_id, $user);");
    }
    redirect('posting/1');
}

public function halt($post_id){
    if($post_id > 0){
       $user = $this->session->userdata('user')['user_id'];
       $this->db->query("call pHalt($post_id, $user);");
    }
   // redirect('posting/1');
}

public function resume($post_id){
    if($post_id > 0){
       $user = $this->session->userdata('user')['user_id'];
       $this->db->query("call pResume($post_id, $user);");
    }
    //redirect('posting/1');
}

public function set_as_draft_post($post_id){
    $valid =   $this->db->query("SELECT CanSetAsDraft($post_id) as validan");
    $valid = $valid->result_array();

        if($valid[0]['validan'] == '0'){
            echo json_encode(array(
                'error' => false,
                'message' => 'Can not set post with id: ' . $post_id . ', as draft, because post is in sending process, or have been already sent!',
                'warning' => true
                )); 
        }
        else{ 
            $user = $this->session->userdata('user')['user_id'];
            $this->db->query("call SetAsDraft($post_id);");
            echo json_encode(array(
                'error' => false,
                'message' => 'Post with id: ' . $post_id . ', is set as draft!',
                'warning' => false
                )); 
        }
    //redirect('posting/1');
}

public function archive_post($post_id){
    $valid =   $this->db->query("SELECT CanArchive($post_id) as validan");
    $valid = $valid->result_array();

        if($valid[0]['validan'] == '0'){
            echo json_encode(array(
                'error' => false,
                'message' => 'Can not archive post with id: ' . $post_id . ', because post is in sending process!',
                'warning' => true
                )); 
        }
        else{ 
            $user = $this->session->userdata('user')['user_id'];
            $this->db->query("call ArchivePost($post_id, $user);");
            echo json_encode(array(
                'error' => false,
                'message' => 'Post with id: ' . $post_id . ', is archived!',
                'warning' => false
                )); 
        }
    //redirect('posting/1');
}

public function insert_post(){
        $this->load->helper('form');
        $this->load->helper('url');    
        $this->load->library('form_validation');
        
        
        if($this->Users_model->isLoggedIn()){
            $user = $this->session->userdata('user')['user_id'];

            $this->db->where('users.id=', $user);
            $this->db->select('timezone');
            $this->db->from('users');
            $query = $this->db->get();        
            $user_timezone=$query->result_array()[0]['timezone'];
            $this->db->select('App_time_zone'); 
            $query = $this->db->get('global_parameters');
            $app_TZ = $query->result_array()[0]['App_time_zone'];


            if($user_timezone == null){
                $user_timezone = $app_TZ;
            }
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
            $ins_or_upd = $this->input->post('ins_or_upd');
            $post_status = $this->input->post('post_status'); //draft-1 or queued-2 for insert
            $user_id = $this->session->userdata('user')['user_id'];

            $post_id=$this->input->post('postId'); 

            $post_type=$this->input->post('postType');
            //$post_status=$this->input->post('postStatus');
            $w_title=$this->input->post('postTitle'); 
            $message = $this->input->post('message');
            //$upload_img=$this->input->post('imageURL'); 
            $upload_images_list = $this->input->post('file_list');

            $upload_video = $this->input->post('videoFileName');
            $add_link=$this->input->post('link');
            
           $schedule_date_timeStr = $this->input->post('schedule_date_time');
          
           if($this->input->post('scheduledSame') == 'on'){
            $scheduledSame = 1;
           } else{
            $scheduledSame = 0;
           }

           $arrayPages = $this->input->post('arrayPages');
           $arrayGroups = $this->input->post('arrayGroups');
           
           $arrayPagesObj = json_decode($arrayPages);
           $arrayGroupsObj = json_decode($arrayGroups);

        //    echo json_encode(array(
        //     'id' => $arrayGroupsObj[0]->id,
        //     'name' => $arrayGroupsObj[0]->name,
        //     'pages' => $arrayGroupsObj[0]->pages
        //     ));


        // echo json_encode(array(
        //     'id' => $arrayGroupsObj[0]->id,
        //     'name' => $arrayGroupsObj[0]->name,
        //     'id[0]' => $arrayGroupsObj[0]->pages[0]->id,
        //     'fbPageName[0]' => $arrayGroupsObj[0]->pages[0]->fbPageName,
        //     'id[1]' => $arrayGroupsObj[0]->pages[1]->id,
        //     'fbPageName[1]' => $arrayGroupsObj[0]->pages[1]->fbPageName,
        //     'id[2]' => $arrayGroupsObj[0]->pages[2]->id,
        //     'fbPageName[2]' => $arrayGroupsObj[0]->pages[2]->fbPageName
        //     ));

       
       

            if($schedule_date_timeStr !== ''){
            //   $schedule_date =  new DateTime($schedule_date_timeStr, new DateTimeZone($app_TZ));
                $schedule_date_time=date("Y-m-d H:i:s",  strtotime($schedule_date_timeStr));
                $is_scheduled=1;
                $tempSchedule = new DateTime($schedule_date_timeStr, new DateTimeZone($user_timezone));
                $scheduleTimeUTC =  $tempSchedule->getTimestamp();
            }
            else {
                $schedule_date_time = NULL; 
                $is_scheduled=0;
                $scheduleTimeUTC = null;
            }
            
            //page(s) to publish post on
            $selected_page_id = $this->input->post('selected_page_id'); 

            $input_post_fb_preset_id=0;
            $queued_post=false; // hiding PAUSE,RESUME
            $fbaccountDetails='';

            // $data=array(
            //           'post_status' => $post_status,
            //           'user_id' => $user_id,
            //           'queued_post' => $queued_post,
            //           'input_post_type' => $post_type,
            //           'input_post_id' => $post_id,
            //           'input_post_title' => $w_title,
            //           'input_post_message' => $message,                
            //           'input_post_link' => $add_link,
            //           'input_post_picture' =>$upload_images_list,
            //           'input_post_video' => $upload_video,
            //           //'input_post_name' => $input_post_name,
            //           //'input_post_caption' => $input_post_caption,
            //           //'input_post_description' => $input_post_description,
            //           'input_post_fb_preset_id' => $input_post_fb_preset_id,
            //           'fbaccountDetails' =>  $fbaccountDetails,
            //           'fbaccountDetails_fb_id' => '104189817385560', //$fbaccountDetails_fb_id,
            //           'fbaccountDetails_firstname' => 'Page',//$fbaccountDetails_firstname,
            //           'fbaccountDetails_lastname' => 'Name', //$fbaccountDetails_lastname,
            //           //'user_groups' => $user_groups,
            //           //'user_pages' => $selected_page_id,
            //           'input_post_image_list' => $upload_images_list,
            //           'selected_page_id' => $selected_page_id,
            //           'isScheduled' => $is_scheduled,
            //           'scheduleDateTime' => $schedule_date_time
            //      );


            if ($this->form_validation->run() === FALSE){
                //$data['title'] = 'Users';
                //$data['users'] = false;
                //$this->load->view('post/edit_post_view', $data);
                echo json_encode(array(
                    'error' => true,
                    'message' => 'validacija',
                    'id' => $post_id
                    ));
           }else{
                    if($ins_or_upd =="insert") {
                        $res= $this->FB_model->insert_post($post_status, $user_id, $selected_page_id, $w_title, 
                        $post_type, $message, $upload_video, $add_link, $upload_images_list,
                        $is_scheduled, $schedule_date_time, $scheduledSame, $arrayPagesObj,$arrayGroupsObj,$scheduleTimeUTC );
                                    
                       // echo 'Inserted Post id: ' . $res;
                       
                       //$this->db->query("call PostEdit($post_id, $user);");
                        echo json_encode(array(
                            'error' => false,
                            'message' => 'OK',
                            'id' => $res
                            ));
                    } 
                    else{
                        try {
                        $res =  $this->FB_model->update_post($post_id, $post_status, $user_id, $selected_page_id, $w_title, 
                        $post_type, $message, $upload_video, $add_link, $upload_images_list,
                        $is_scheduled, $schedule_date_time, $scheduledSame, $arrayPagesObj,$arrayGroupsObj, $scheduleTimeUTC);
                       
                        $this->db->query("call PostEdit($post_id, $user);");
                        echo json_encode(array(
                            'error' => false,
                            'message' => 'OK',
                            'id' => $res
                            ));
                        } catch(Exception $e) { 
                            echo json_encode(array(
                                'error' => true,
                                'message' => $e->getMessage(),
                                'id' => $res
                                ));
                          }
                    }
                   // redirect ('');
           }       
        }
        else {
            //not logged in
            redirect ('login');
            
        }
    }

}