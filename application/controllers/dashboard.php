<?php

class Dashboard extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('dashboard_model');
            $this->load->helper('url_helper');
            $this->load->library('Ajax_pagination');
            $this->perPage = 4;
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
        $pwithoutPL24 = $this->input->post('pwithoutPL24');
        $pwithoutPL72 = $this->input->post('pwithoutPL72');
            
        if(!empty($pagename)){
            $conditions['search']['pagename'] = $pagename;
        }
        // if(!empty($group)){
        //     $conditions['search']['group'] = $group;
        // }
        if(!empty($pwithoutPL24)){
            $conditions['search']['pwithoutPL24'] = $pwithoutPL24;
        }
        // if(!empty($pwithoutPL72)){
        //     $conditions['search']['pwithoutPL72'] = $pwithoutPL72;
        // }

        //total rows count
        $totalRec = count($this->dashboard_model->getRows($conditions));
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'dashboard/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        
        //get posts data
        $data['p_statistics'] = $this->dashboard_model->getRows($conditions);
        
        //load the view
      //  $this->output->enable_profiler();
        $this->load->view('dashboard/ajax-pagination-data', $data, false);
    }

    public function index(){
        $data = array();
        
        //total rows count
        $totalRec = count($this->dashboard_model->getRows());

        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'dashboard/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['p_statistics'] = $this->dashboard_model->getRows(array('limit'=>$this->perPage));
        
        $data['title'] = 'Dashboard';

        $gstat = $this->dashboard_model->get_gstatistic();
        $data['global'] = $gstat[0];

        //load the view
        $this->output->enable_profiler();
        $this->load->view('dashboard/dashboard_view', $data);

        // $status['IsActive'] = true;
        // $data['groups'] = $this->groups_model->get_groups();
        // $data['title'] = 'Manual Groups';
        // $this->output->enable_profiler();
        // $this->load->view('groups/manual_group', $data);

    }
}