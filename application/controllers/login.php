<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('Users_model');
            $this->load->helper('url_helper');
            $this->load->helper('cookie');
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
                                // user login ok
                                // if($this->session->userdata('next_after_login')){
                                // 	$uri = $this->session->userdata('next_after_login');
                                // 	$this->session->unset_userdata('next_after_login');
                                // 	redirect($uri);
                                // 	exit();
                                // }else{
                                // 	redirect('/');
                                // 	exit();
                                // }
               // print_r($this->session->userdata()); 
               // echo "<h1>bla bla bla</h1>";
                redirect('fbcheck');
                //$this->load->view('dashboard', $data);
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
}