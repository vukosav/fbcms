<?php
    require_once FCPATH . '/vendor/autoload.php'; // change path as needed  
class FBCheck extends CI_Controller {


    public function __construct()
    {
            parent::__construct();
            $this->load->helper('url_helper');
            $this->load->library('FacebookPersistentDataInterface');
            $this->load->model('Users_model');
    }

    public function index(){
        
        if (!isset($_SESSION))
        {
            session_start();
        }    
        if($this->Users_model->isLoggedIn()){ 
            $user_id = $this->session->userdata('user')['user_id']; 
            $fb = new \Facebook\Facebook([
                'app_id' => FB_APP_ID,
                'app_secret' => FB_APP_SECRET,
                'default_graph_version' => FB_API_VERSION,
            'persistent_data_handler' => new FacebookPersistentDataInterface(),
            
            ]); 
            $helper = $fb->getRedirectLoginHelper(); 
            $permissions = ['email', 'user_likes', 'manage_pages', 'publish_pages' , 'read_insights', 'read_page_mailboxes', 'user_posts']; // optional
            $loginUrl = $helper->getLoginUrl(base_url() . 'LoginCallback', $permissions);
            $alert = 0;
            $alert_type = '';
            $fb_large_message = '';
            $fb_message = '';
            $fb_check_user_add_update_error = $this->session->userdata('fb_check_user_add_update_error');
            $fb_different_login_warning = $this->session->userdata('fb_different_login_warning');
            $fb_no_new_pages_info = $this->session->userdata('fb_no_new_pages_info');
            $fb_graph_error = $this->session->userdata('fb_graph_error');
            $fb_sdk_error =  $this->session->userdata('fb_sdk_error'); 
            $fb_removed_pages_info = $this->session->userdata('fb_removed_pages_info'); 
            if($fb_check_user_add_update_error!=null ||  $fb_different_login_warning!=null ||
               $fb_no_new_pages_info!=null ||  $fb_graph_error!=null || $fb_sdk_error!=null 
               || $fb_removed_pages_info!=null){
                $alert = 1;
            }
            if($fb_check_user_add_update_error!=null ||   $fb_graph_error!=null || $fb_sdk_error!=null){
                $alert_type = 'danger';
                if($fb_check_user_add_update_error!=null){
                    $fb_large_message = 'Unexpected error';
                    $fb_message = $fb_check_user_add_update_error ;
                }
                else{
                    if($fb_graph_error!=null){
                        $fb_large_message = 'Facebook Graph API error';
                        $fb_message = $fb_graph_error ;
                    }
                    if($fb_sdk_error!=null){
                        $fb_large_message = 'Facebook SDK error';
                        $fb_message = $fb_sdk_error ;
                    }
                }
                
            }
            elseif($fb_different_login_warning!=null){
                $alert_type = 'warning';
                
                    $fb_large_message = 'Wrong facebook login';
                    $fb_message = $fb_different_login_warning;                  
                
            }
            elseif($fb_no_new_pages_info!=null || $fb_removed_pages_info!=null){
                $alert_type = 'info';

                if($fb_removed_pages_info!=null && $fb_removed_pages_info!=null){
                    $fb_large_message = 'No new facebook pages and Removed Facebook pages';
                    $fb_message = $fb_no_new_pages_info . '<br>' . $fb_removed_pages_info;
                }
                else if ($fb_no_new_pages_info==null){
                    $fb_large_message = 'Removed Facebook pages';
                    $fb_message = $fb_removed_pages_info;
                }else {
                    $fb_large_message = 'No new facebook pages';
                    $fb_message = $fb_no_new_pages_info;
                }

             
            }


            $data = array('loginUrl' => $loginUrl,
            'fb_large_message'=>$fb_large_message,
            'fb_message'=>$fb_message,
            'alert'=>$alert,
            'alert_type'=>$alert_type
            );

            $data['title'] = 'FB check page';
            
            $this->session->set_userdata('fb_check_user_add_update_error',null);
            $this->session->set_userdata('fb_different_login_warning',null);
            $this->session->set_userdata('fb_no_new_pages_info',null);
            $this->session->set_userdata('fb_graph_error',null);
            $this->session->set_userdata('fb_sdk_error',null); 
            $this->session->set_userdata('fb_removed_pages_info',null);
            $this->load->view('users/fbcheck', $data);
          
        } else {
            (redirect('/login'));
        }         
    }
}