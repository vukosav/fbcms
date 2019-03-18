<?php
class Test_fb_emulator extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            
            $this->load->library('Job_thread');
            // $this->load->helper('url_helper');
            //$this->load->controller('Job_thread');
            // $this->load->model('Users_model');
    }

    public function sent_to_fb($message){
        echo "<h2>" . $message . "</h2>";
       
    }

    
  
} 