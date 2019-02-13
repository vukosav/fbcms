<?php

class Login extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('login_model');
    }

    public function index(){
        $this->login();
    }

    public function login() {
        	// If user is logged in redirect to home page
		if($this->User_Model->isLoggedIn())
        redirect('/');
    }

}
