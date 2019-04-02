<?php

class Pages extends MY_controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('Pages_model');
            // $this->load->helper('url_helper');
            // $this->load->model('Other_model');
            // $this->load->library('Ajax_pagination');
            // $this->perPage = 2;
    }

    function ajaxPaginationData(){
        $conditions = array();
        
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        //set conditions for search
        $pagename = $this->input->post('pagename');
        $group = $this->input->post('group');
        $automaticgroup = $this->input->post('automaticgroup');
        if(!empty($pagename)){
            $conditions['search']['pagename'] = $pagename;
        }
        if(!empty($group)){
            $conditions['search']['group'] = $group;
        }
        if(!empty($automaticgroup)){
            $conditions['search']['automaticgroup'] = $automaticgroup;
        }

        //total rows count
        $totalRec = count($this->Pages_model->getRows($conditions));
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'pages/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        
        //get posts data
        $data['pages'] = $this->Pages_model->getRows($conditions);
        
        //print_r($this->db->last_query());
        //load the view
        // $this->output->enable_profiler();
        $this->load->view('pages/ajax-pagination-data', $data, false);
    }

    public function index(){

        $data = array();
        
        //total rows count
        $totalRec = count($this->Pages_model->getRows());

        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'pages/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['pages'] = $this->Pages_model->getRows(array('limit'=>$this->perPage));
        
        $data['title'] = 'Pages';

        //load users for filter
        if($this->session->userdata('user')['role'] == 1){
            $data['group'] = $this->Other_model->get_group();
        }else{
            $data['group'] = $this->Other_model->get_group($this->session->userdata('user')['user_id']);
        }
        

        //load the view
        //$this->output->enable_profiler();
        $this->load->view('pages/pages_view', $data);
        //print_r($data['pages']);

    }
    public function delete ($id){
        $this->Pages_model->delete($id);
        redirect('/pages/index');
    }

    public function edit($id){
        $data['pages'] = $this->Pages_model->get_pages($id);
        $data['added_groups'] = $this->Pages_model->get_added_groups($id);
        $data['free_groups'] = $this->Pages_model->get_free_groups($id);

        $data['title'] = 'Edit Pages';
        // print_r($data);
        $this->load->view('pages/edit_page', $data);
        //$this->output->enable_profiler();
    }
    public function SetTimeZone(){
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
            'timezone' => $this->input->post('timezone')
        );
        $id = $this->input->post('id');
        // if ($this->form_validation->run() === FALSE){
        //     $data['title'] = 'Admin';
        //     //$data['users'] = false;
        //     // $this->output->enable_profiler();
        //     // print_r($this->session->userdata);
        //     $this->load->view('admin/admin_view', $data);
        // }else{
            $this->Pages_model->update($data, $id);
            //$data['title'] = 'Admin';
            redirect('/pages/index');
        // }
    }
}