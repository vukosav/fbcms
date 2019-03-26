<?php
//require_once './core/MY_controller.php';
class Admin extends MY_controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('Admin_model');
            // $this->load->helper('url_helper');
            // $this->load->library('Ajax_pagination');
            // $this->perPage = 4;
    }

    public function index(){
        if(!isset($this->session->userdata('user')['role'])){
            return redirect('/');
        }
        if($this->session->userdata('user')['role']== 2){
            return redirect('/');
        }

        //get the posts data
        $data['admin'] = $this->Admin_model->getRows();
        
        $data['title'] = 'Admin';

        //load the view
        //$this->output->enable_profiler();
        $this->load->view('admin/admin_view', $data);
    }

    public function SetConfig(){
        if(!isset($this->session->userdata('user')['role'])){
            return redirect('/');
        }
        if($this->session->userdata('user')['role']== 2){
            return redirect('/');
        }

        // $this->load->helper(array('form', 'url'));    
        // $this->load->library('form_validation');
        
        // $this->form_validation->set_rules(
        //     'email', 'E-mail',
        //     array(
        //             'required'      => 'You have not provided %s.',
        //             'is_unique'     => 'This %s already exists.'
        //     )
        // );
        
        $data = array(
            'App_time_zone' => $this->input->post('apptimezone'),
            'user_or_page' => $this->input->post('usrORpos'),
            'period_in_sec_fb' => $this->input->post('period')
        );
        // if ($this->form_validation->run() === FALSE){
        //     $data['title'] = 'Admin';
        //     //$data['users'] = false;
        //     // $this->output->enable_profiler();
        //     // print_r($this->session->userdata);
        //     $this->load->view('admin/admin_view', $data);
        // }else{
            $this->Admin_model->set($data);
            $data['title'] = 'Admin';
            redirect('/');
        // }
    }
}