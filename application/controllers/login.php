<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

        $graphNode = $this->debug_token($input_token); 
        $converted_res = ($graphNode['is_valid']) ? 'true' : 'false';
        $expires_at = ($graphNode['expires_at']);
        $userFBData = array();
        
        $userFBData['user_AT_is_valid'] = $converted_res;
        $userFBData['user_AT_exp_date'] = $expires_at;
        
        $ret_pat= $this->FB_model->get_pages_tokens($user_id);
        $userPages = array();
        for ($i = 0; $i < count($ret_pat); $i++) {
            
            $page_name=$ret_pat[$i]['fbPageName'];  
            $input_token=$ret_pat[$i]['fbPageAT'];
            $graphNode = $this->debug_token($input_token ); 
            $converted_is_valid = ($graphNode['is_valid']) ? 'true' : 'false';  
            $expires_at = ($graphNode['expires_at']);  
            
            $pageFBData = array();
            $pageFBData['page_id'] = $ret_pat[$i]['id'];
            $pageFBData['page_named'] = $page_name;
            //$pageFBData['page_fb_AT'] = $input_token;
            $pageFBData['page_AT_is_valid'] = $converted_is_valid;
            $pageFBData['page_AT_exp_date'] = $expires_at;
            $userPages[$page_name] = $pageFBData;
        } 
        $userFBData['pages'] = $userPages;
        $this->session->set_userdata('FB_UAT',$userFBData);
    }

    public function debug_token($input_token){
        if (!isset($_SESSION)) { session_start(); }   
        require_once FCPATH . '/vendor/autoload.php'; // change path as needed        
        $app_id ='503878473471513';
        $app_secret = '28cbbb9f440b1b016e9ce54376ada17e';
        $fb = new \Facebook\Facebook([
        'app_id' => $app_id,
        'app_secret' => $app_secret,
        'default_graph_version' => 'v3.2',
        // 'persistent_data_handler' => new FacebookPersistentDataInterface(),
        ]);
        
        $access_token = $app_id .'|' . $app_secret; 
              
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
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        
    }  

}