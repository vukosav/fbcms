<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 require_once FCPATH . '/vendor/autoload.php'; // change path as needed  
class Login extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('Users_model');
            $this->load->helper('url_helper');
            $this->load->helper('cookie');
            $this->load->library('FacebookPersistentDataInterface');
            $this->load->model('FB_model');
    }

    public function login() {

		// If user is logged in redirect to home page
		if($this->Users_model->isLoggedIn())
			redirect('/');

		// Check if cookie session is exists
                        // if($uscode = $this->input->cookie($this->config->item('sess_cookie_name')."_usid", TRUE)){
                        // 	if($this->Users_model->loginFromCookie($uscode)){
                        // 		redirect("/");
                        // 	}
                        // }


        // set validation rules
        $this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email or Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		if ($this->form_validation->run() == false) {
            // validation not ok, send validation errors to the view
            $data['title'] = 'Login';
            $data['users'] = false;
			$this->load->view('users/login_view', $data);
		} else {
			// set variables from the form
			$username = $this->input->post('email',TRUE);
			$password = $this->input->post('password',TRUE);
                                            //$rememberMe = $this->input->post('remember',TRUE) == "on" ? TRUE : FALSE;

			if ($this->Users_model->checkUserLogin($username, $password)) { 
                $user_id = $this->session->userdata('user')['user_id'];
            
                $this->FB_tokens_check($user_id);
                redirect('fbcheck');


			} else {
				// login failed
                //echo ($this->Users_model->getErrors(),"danger");
                $data['title'] = 'Login';
                $data['errors'] = $this->Users_model->errors;
                $this->load->view('users/login_view', $data);
				
			}
		}
		
		// send error to the view
		//$this->twig->display('public/login',$twigData);
    }
    
    public function logout() {
        if(!$this->Users_model->isLoggedIn())
			redirect('login');
		$this->Users_model->loggedOut();
		redirect('login');
	}

    
    public function hash_password($password,$salt) {
        return hash('sha256', $password . $salt);
    }


    public function FB_tokens_check($user_id){ 
          
        $ret_uat= $this->FB_model->get_user_token($user_id);

        $input_token=$ret_uat[0]['fb_access_token']; 

        if($input_token != null && isset($input_token) && $input_token!='') {

            $graphNode = $this->debug_token($input_token); 

            if($graphNode!=-1){

                $converted_res = ($graphNode['is_valid']) ? 'true' : 'false';
                $expires_at = ($graphNode['expires_at']);

                $userFBData = array();
                
                $userFBData['user_AT_is_valid'] = $converted_res;
            
                $userFBData['user_AT_exp_date'] = false;
                if(strtotime($expires_at->format("Y-m-d H:i:s")) != 0){
                    $diff =  strtotime($expires_at->format("Y-m-d H:i:s")) - time();
                    if(($diff/(3600*24)) < 7){
                        $userFBData['user_AT_exp_date'] = true; //$expires_at->format("Y-m-d H:i:s");
                    }
                }
            }
               
                $ret_pat= $this->FB_model->get_pages_tokens($user_id);
                $userPages = array();
                $count_page_invalid = 0;
                $count_page_expires = 0;
                for ($i = 0; $i < count($ret_pat); $i++) {
                
                    $page_name=$ret_pat[$i]['fbPageName'];  
                    $input_token=$ret_pat[$i]['fbPageAT'];

                    $graphNode = $this->debug_token($input_token ); 
                    if($graphNode!=-1){

                        $converted_is_valid = ($graphNode['is_valid']) ? 'true' : 'false';
                        if($converted_is_valid === 'false'){
                            $count_page_invalid = $count_page_invalid+1;
                        }  
                        $expires_at = ($graphNode['expires_at']); 
                        if(strtotime($expires_at->format("Y-m-d H:i:s")) != 0){
                            $diff =  strtotime($expires_at->format("Y-m-d H:i:s")) - time();
                            if(($diff/(3600*24)) < 7){
                                $count_page_expires =  $count_page_expires + 1;
                            }
                        }
                        $pageFBData = array();
                        $pageFBData['xcr'] = $ret_pat[$i]['id'];//$page_name;
                        $pageFBData['page_id'] = $page_name;
                        //$pageFBData['page_fb_AT'] = $input_token;
                        $pageFBData['page_AT_is_valid'] = $converted_is_valid;
                        $pageFBData['page_AT_exp_date'] = $expires_at->format("Y-m-d H:i:s");
                        $userPages[$page_name] = $pageFBData;
                    }
                
                } 
                $userFBData['pages'] = $userPages;
                $userFBData['count_page_invalid'] = $count_page_invalid;
                $userFBData['count_page_expires'] = $count_page_expires;
                    
                $this->session->set_userdata('FB_UAT',$userFBData);
            }
            
        }
    }

    public function debug_token($input_token){
        if (!isset($_SESSION)) { session_start(); }   
             
        $fb = new \Facebook\Facebook([
                'app_id' => FB_APP_ID,
                'app_secret' => FB_APP_SECRET,
                'default_graph_version' => FB_API_VERSION
        ]);

        $access_token = FB_APP_ID .'|' . FB_APP_SECRET; 
              
        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get(
                //olivia olivia token'
            '/debug_token?input_token='. $input_token, 
            //app_id|app_secret
            $access_token
        );
           $graphNode = $response->getGraphNode();
           return $graphNode;
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            //echo 'Graph returned an error: ' . $e->getMessage();
            $this->session->set_userdata('fb_graph_error','Facebook Graph api returned an error: ' .$e->getMessage());
            return -1;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            //echo 'Facebook SDK returned an error: ' . $e->getMessage();
            $this->session->set_userdata('fb_sdk_error','Facebook SDK returned an error: ' . $e->getMessage());
            return -1;
        }
        
    }  

}