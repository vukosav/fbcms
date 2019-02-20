<?php

class MY_controller extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('users_model');
            $this->load->helper('url_helper');
            $this->load->model('other_model');
            $this->load->library('Ajax_pagination');
            $this->perPage = 4;
            $this->load->helper('cookie');
            // if (!$this->session->userdata('user')['logged_in'])
            // { 
            //     redirect('login');
            // }
    }
}