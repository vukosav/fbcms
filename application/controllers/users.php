<?php

class Users extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('users_model');
            $this->load->helper('url_helper');
    }

    public function index(){
        $status['IsActive'] = true;
        $data['users'] = $this->users_model->get_users();
        $data['title'] = 'Users';
        $this->output->enable_profiler();
        $this->load->view('users/users_view', $data);
        // $this->load->helper('url');
        
        // $data['IsActive'] = true;
        // $this->input->post('working_title')? $data['title like '] = $this->input->post('working_title')."%":false;
        // $this->input->post('user')? $data['created_by'] = $this->input->post('user'):false;
        // $this->input->post('date_from')? $data['created_date >='] = $this->input->post('date_from')." 00:00:00":false;
        // $this->input->post('date_to')? $data['created_date <='] = $this->input->post('date_to')." 23:59:59":false;
        // $this->input->post('archived')? $data['IsActive'] = $this->input->post('archived'):false;
        // $this->input->post('inProgres')? $data['ActionStatus'] = $this->input->post('inProgres'):false;
        // $this->input->post('paused')? $data['ActionStatus'] = $this->input->post('paused'):false;
        

        // $q_post['queued'] = $this->post_model->get_queued($data);
        // $q_post['title'] = 'Queued posts';
        // $this->output->enable_profiler();
        // $this->load->view('post/post_queued_view', $q_post);
    }

    public function addusr(){

        
        // $q_post['title'] = 'Queued posts';
        // $this->output->enable_profiler();
        // $this->load->view('post/post_queued_view', $q_post);

        // $s_post['sent'] = $this->post_model->get_sent();
        $s_post['title'] = 'Add new user';
        $this->load->view('users/singup',$s_post);
    }
    
    public function createusr(){
        $this->load->helper('url');

        $this->input->post('email')? $data['email'] = $this->input->post('email'):false;
        $this->input->post('fullname')? $data['name'] = $this->input->post('fullname'):false;
        $data['dateCreated'] = date('Y-m-d h:i:s', time());
        $this->input->post('username')? $data['username'] = $this->input->post('username'):false;
        $this->input->post('password')? $data['password'] = $this->input->post('password'):false;
        $this->input->post('role')? $data['roleid'] = $this->input->post('role'):false;
        $data['IsActive'] = true;
        $data['createdBy']=1;
        $q_post['queued'] = $this->users_model->insert($data);
        $data['title'] = 'Users';
        $this->output->enable_profiler();
        redirect('/users/index');
        // $this->load->view('users/users_view', $data);
    }
}
