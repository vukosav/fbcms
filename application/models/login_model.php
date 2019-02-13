<?php

class Login_model extends CI_Model{
    
    public function __construct()
    {
            //$this->load->database();
    }
    
    public function isLoggedIn(){
		if(isset($this->session->userdata('user')['logged_in']))
			return true;

		return false;
    }
}
