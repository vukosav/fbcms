<?php

class Dashboard extends CI_Controller {

    //  public function __construct()
    // {
    //     parent::__construct();
    //     $this->load->model('dashboard_model');
    //     $this->load->helper('url_helper');
    // }

    public function __construct()
    {
            parent::__construct();
            $this->load->model('dashboard_model');
            $this->load->helper('url_helper');
    }

    public function index(){
        $pstat['p_statistics'] = $this->dashboard_model->get();
        $gstat = $this->dashboard_model->get_gstatistic();
        $pstat['global'] = $gstat[0];
        $pstat['title'] = 'Dashboard';
        // $pstat['userdata']  =   $this->session->userdata('name');
        $this->load->view('dashboard/dashboard_view', $pstat);

    }
}