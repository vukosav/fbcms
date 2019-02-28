<?php

class Groups extends MY_controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('Groups_model');
            $this->load->model('Pages_model');
            // $this->load->model('Other_model');
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
        $grname = $this->input->post('grname');
        $createdBy = $this->input->post('createdBy');
        $sortBy = $this->input->post('sortBy');
        if(!empty($grname)){
            $conditions['search']['grname'] = $grname;
        }
        if(!empty($createdBy)){
            $conditions['search']['createdBy'] = $createdBy;
        }
        if(!empty($sortBy)){
            $conditions['search']['sortBy'] = $sortBy;
        }
        
        //total rows count
        $totalRec = count($this->Groups_model->getRows($conditions));
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'groups/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        
        //get posts data
        $data['groups'] = $this->Groups_model->getRows($conditions);
        
        //load the view
      //  $this->output->enable_profiler();
        $this->load->view('groups/ajax-pagination-data', $data, false);
    }

    public function index(){
        $data = array();
        
        //total rows count
        $totalRec = count($this->Groups_model->getRows());

        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'groups/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['groups'] = $this->Groups_model->getRows(array('limit'=>$this->perPage));
        
        $data['title'] = 'Manual Groups';

        //load users for filter
        $data['usr'] = $this->Other_model->get_users();

        //load the view
        //$this->output->enable_profiler();
        $this->load->view('groups/manual_group_view', $data);

        // $status['IsActive'] = true;
        // $data['groups'] = $this->Groups_model->get_groups();
        // $data['title'] = 'Manual Groups';
        // $this->output->enable_profiler();
        // $this->load->view('groups/manual_group', $data);

    }

    public function delete ($id){
        $this->Groups_model->delete($id);
        redirect('/Groups/index');
    }

    // public function addgroup(){

    //     $s_post['title'] = 'Add new group';
    //     $this->load->view('groups/add_group',$s_post);
    // }
    
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
            'userId' => $this->session->userdata('user')['user_id']
        );
      
        if ($this->form_validation->run() === FALSE){
            $data['title'] = 'Add new group';
            $data['groups'] = false;
            $this->load->view('groups/index', $data);
        }else{
            $q_post['queued'] = $this->Groups_model->insert($data);
            $data['title'] = 'Groups';
            //$this->output->enable_profiler();
            redirect('/Groups/index');
        }
    }

    public function edit($id){
        $data['groups'] = $this->Groups_model->get_groups($id);
        $aa = $data['groups'];
        $aa = array_shift($aa);
        if($aa['userId'] !== $this->session->userdata('user')['user_id']){
            redirect('/Groups/index');
        }

        $data['added_pages'] = $this->Pages_model->get_added_pages($id);
        $data['free_pages'] = $this->Pages_model->get_free_pages($id);

        $data['title'] = 'Edit Groups';
        // print_r($data);
        $this->load->view('groups/edit_group', $data);
        //$this->output->enable_profiler();
    }
    public function insertPagesGroups() {
        //$this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $grupid =  $this->uri->segment(2);
        $pageid =  $this->uri->segment(3);
        // foreach($pid as $p){
        $data = array(
            'pageId' => $pageid,
            'groupId' => $grupid,
            'dateCreate' => date('Y-m-d h:i:s', time()),
            'userId' => $this->session->userdata('user')['user_id']
        );
        $this->Groups_model->insertPG($data);
        // }
        $url = $_SERVER['HTTP_REFERER'];
        redirect($url);
        //redirect('editgrup/'.$gid);
        // print_r($data);
    }

    public function deletePagesGroups() {
        $this->load->helper(array('form', 'url'));
        $id =  $this->uri->segment(2);
        $this->Groups_model->deletePG($id);
        $url = $_SERVER['HTTP_REFERER'];
        redirect($url);
        //redirect('editgrup/'.$this->uri->segment(2));
    }

}
