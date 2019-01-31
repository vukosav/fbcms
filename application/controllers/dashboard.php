<?php

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('dashboard_model');
        $this->load->helper('url_helper');
    }

    public function index(){
        $result = $this->dashboard_model->get('page_statistic');
        print_r($result);
        $this->load->view('dashboard/dashboard_view');
    }
    // public function get(){
    //     $result = $this->db->get_news(3);
    //     print_r($result->result());
    //     // print_r($this->database->db['default']);
    // }
    public function get($slug = NULL){
        print_r($this->news_model->get_news($slug));
      

    }
}

