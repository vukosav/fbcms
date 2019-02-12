<?php

class Groups extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('groups_model');
            $this->load->model('pages_model');
            $this->load->helper('url_helper');
    }

    public function index(){
        $status['IsActive'] = true;
        $data['groups'] = $this->groups_model->get_groups();
        $data['title'] = 'Manual Groups';
        $this->output->enable_profiler();
        $this->load->view('groups/manual_group', $data);

    }

    public function delete ($id){
        $this->groups_model->delete($id);
        redirect('/groups/index');
    }

    public function addgroup(){

        $s_post['title'] = 'Add new group';
        $this->load->view('groups/add_group',$s_post);
    }
    
    public function creategroup(){
        
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules(
            'groupname', 'Group name',
            'trim|required|min_length[2]',
            array(
                    'required'      => 'You have not provided %s.'
            )
        );

        $data = array(
            'name' => $this->input->post('groupname'),
            'createDate' => date('Y-m-d h:i:s', time()),
            'IsActive' => true,
            'userId' => 1
        );
      
        if ($this->form_validation->run() === FALSE){
            $data['title'] = 'Add new group';
            $data['groups'] = false;
            $this->load->view('groups/add_group', $data);
        }else{
            $q_post['queued'] = $this->groups_model->insert($data);
            $data['title'] = 'Groups';
            $this->output->enable_profiler();
            redirect('/groups/index');
        }

    }

    public function edit($id){
        $status['IsActive'] = true;
        $data['groups'] = $this->groups_model->get_groups($id);
        $data['pages'] = $this->pages_model->get_pages();
        $data['title'] = 'Edit Groups';
        // print_r($data);
        $this->load->view('groups/edit_group', $data);
        $this->output->enable_profiler();
    }
    public function insertPagesGroups($gid,$pid) {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        foreach($pid as $p){
        $data = array(
            'pageId' => $p,
            'groupId' => $gid,
            'dateCreate' => date('Y-m-d h:i:s', time()),
            'userId' => 1
        );
        $this->groups_model->insertPG($data);
        }
    }

}
