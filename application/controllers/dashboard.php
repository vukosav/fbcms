<?php
//require_once './core/MY_controller.php';
class Dashboard extends MY_controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('Dashboard_model');
            // $this->load->helper('url_helper');
            // $this->load->library('Ajax_pagination');
            // $this->perPage = 4;
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
        if(!empty($group)){
            $conditions['search']['group'] = $group;
        }
        if($pwithoutPL24 == 'true'){
            $conditions['search']['pwithoutPL24'] = 'nn';
        }
        if($pwithoutPL72 == 'true'){
            $conditions['search']['pwithoutPL72'] = 'nn';
        }

        //total rows count
        $totalRec = count($this->Dashboard_model->getRows($conditions));
        
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
        $data['p_statistics'] = $this->Dashboard_model->getRows($conditions);
        
        //load the view
      //  $this->output->enable_profiler();
        $this->load->view('dashboard/ajax-pagination-data', $data, false);
    }

    public function index(){
        $data = array();
        
        //total rows count
        $totalRec = count($this->Dashboard_model->getRows());

        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'dashboard/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['p_statistics'] = $this->Dashboard_model->getRows(array('limit'=>$this->perPage));
        
        $data['title'] = 'Dashboard';

        if($this->session->userdata('user')['role'] == 1){
        $gstat = $this->Dashboard_model->get_gstatistic();
        }else{
            $gstat = $this->Dashboard_model->get_gstatistic($this->session->userdata('user')['user_id']);
        }
        $data['global'] = $gstat[0];

        //load groups for filter
        if($this->session->userdata('user')['role'] == 1){
            $data['group'] = $this->Other_model->get_group();
        }else{
            $data['group'] = $this->Other_model->get_group($this->session->userdata('user')['user_id']);
        }

        //load the view
        //$this->output->enable_profiler();
        $this->load->view('dashboard/dashboard_view', $data);
    }
}