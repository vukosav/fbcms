<?php

class Pages extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('pages_model');
            $this->load->helper('url_helper');
            $this->load->model('other_model');
            $this->load->library('Ajax_pagination');
            $this->perPage = 2;
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
        $totalRec = count($this->pages_model->getRows($conditions));
        
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
        $data['pages'] = $this->pages_model->getRows($conditions);
        
        //print_r($this->db->last_query());
        //load the view
        //$this->output->enable_profiler();
        $this->load->view('pages/ajax-pagination-data', $data, false);
    }

    public function index(){

        $data = array();
        
        //total rows count
        $totalRec = count($this->pages_model->getRows());

        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'pages/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['pages'] = $this->pages_model->getRows(array('limit'=>$this->perPage));
        
        $data['title'] = 'Pages';

        //load users for filter
        $data['group'] = $this->other_model->get_group();

        //load the view
        $this->output->enable_profiler();
        $this->load->view('pages/pages_view', $data);
        //print_r($data['pages']);

    }
    public function delete ($id){
        $this->pages_model->delete($id);
        redirect('/pages/index');
    }

    public function edit($id){
        $data['pages'] = $this->pages_model->get_pages($id);
        $data['added_groups'] = $this->pages_model->get_added_groups($id);
        $data['free_groups'] = $this->pages_model->get_free_groups($id);

        $data['title'] = 'Edit Pages';
        // print_r($data);
        $this->load->view('pages/edit_page', $data);
        $this->output->enable_profiler();
    }
}