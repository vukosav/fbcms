<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GoLiveController extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            // $this->load->model('Users_model');
            // $this->load->helper('url_helper');
            // $this->load->model('Other_model');
            // $this->load->library('Ajax_pagination');
            // $this->perPage = 4;
            // $this->load->helper('cookie');
    }

    
 
   

    public function GoLive (){
         $_SESSION['live_true'] = true;
    }
    
   public function StopLive(){
        $_SESSION['live_true'] = false;
   }

    
}