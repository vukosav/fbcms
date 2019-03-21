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
        if(!empty($pagename)){
            $conditions['search']['pagename'] = $pagename;
        }
        if(!empty($group)){
            $conditions['search']['group'] = $group;
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
        //$this->output->enable_profiler();
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
}