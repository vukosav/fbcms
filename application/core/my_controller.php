<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_controller extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('Users_model');
            $this->load->helper('url_helper');
            $this->load->model('Other_model');
            $this->load->library('Ajax_pagination');
            $this->perPage = 40;
            $this->load->helper('cookie');
            if (!$this->session->userdata('user')['logged_in'])
            { 
                redirect('login');
            }
    }
}