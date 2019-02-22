<?php

class Pages extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('pages_model');
            $this->load->helper('url_helper');
            $this->load->model('other_model');
            $this->load->library('Ajax_pagination');
            $this->perPage = 50;
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
        $wtitle = $this->input->post('wtitle');
        $createdBy = $this->input->post('createdBy');
        $fbpage = $this->input->post('fbpage');
        $date_from = $this->input->post('date_from')?  $this->input->post('date_from') .' 00:00:00':false;
        $date_to = $this->input->post('date_to')? $this->input->post('date_to') .' 23:59:59':false;
        $archived = $this->input->post('archived');
        $paused = $this->input->post('paused');
        $errors = $this->input->post('errors');
        $inProgres = $this->input->post('inProgres',FALSE);
        // $post_status = $this->input->post('post_status');
        if(!empty($createdBy)){
            $conditions['search']['createdBy'] = $createdBy;
        }
        if(!empty($wtitle)){
            $conditions['search']['wtitle'] = $wtitle;
        }
        // if(!empty($group)){
        //     $conditions['search']['group'] = $group;
        // }
        if(!empty($fbpage)){
            $conditions['search']['fbpage'] = $fbpage;
        }
        if(!empty($date_from)){
            $conditions['search']['date_from'] = $date_from;
        }
        if(!empty($date_to)){
            $conditions['search']['date_to'] = $date_to;
        }
        if(!empty($archived)){
            $conditions['search']['archived'] = $archived;
        }
        // if(!empty($paused)){
        //     $conditions['search']['paused'] = $paused;
        // }
        // if(!empty($errors)){
        //     $conditions['search']['errors'] = $errors;
        // }
        // if(!empty($inProgres)){
        //     $conditions['search']['inProgres'] = $inProgres;
        // }
        // if(!empty($post_status)){
        //     $conditions['search']['post_status'] = $post_status;
        // }
print_r($this->db->last_query());
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
        $data['posts'] = $this->pages_model->getRows($conditions);
        
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
        $data['usr'] = $this->other_model->get_users();
        //load pages for filter
        $data['fbpg'] = $this->other_model->get_fbpage();

        //load the view
        $this->output->enable_profiler();
        $this->load->view('pages/pages_view', $data);
        //print_r($data['pages']);

    }
}