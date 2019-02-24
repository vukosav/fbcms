<?php

class Post extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('post_model');
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
        // $group = $this->input->post('group');
        $fbpage = $this->input->post('fbpage');
        $date_from = $this->input->post('date_from')?  $this->input->post('date_from') .' 00:00:00':false;
        $date_to = $this->input->post('date_to')? $this->input->post('date_to') .' 23:59:59':false;
        $archived = $this->input->post('archived');
        $paused = $this->input->post('paused');
        $errors = $this->input->post('errors');
        $inProgres = $this->input->post('inProgres');
        $scheduled = $this->input->post('scheduled');
        $post_status = $this->input->post('post_status');


        $conditions['search']['post_status'] = $post_status;
       
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
        if($archived == 'true'){
            $conditions['search']['archived'] = 'nn';
        }
        if($paused == 'true'){
            $conditions['search']['paused'] = 'nn';
        }
        if($errors == 'true'){
            $conditions['search']['errors'] = 'nn';
        }
        if($inProgres == 'true'){
            $conditions['search']['inProgres'] = 'nn';
        } 
        if($scheduled == 'true'){
            $conditions['search']['scheduled'] = 'nn';
        } 
print_r( $conditions);
// print_r($this->db->last_query());
        //total rows count
        $totalRec = count($this->post_model->getRows($conditions, $post_status));
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'post/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        
        //get posts data
        $data['posts'] = $this->post_model->getRows($conditions, $post_status);
       
        print_r($this->db->last_query());
        //load the view
        //$this->output->enable_profiler();
        $this->load->view('post/ajax-pagination-data', $data, false);
    }

    public function index(){
        $data = array();
        $pos =  $this->uri->segment(2);       
        if($pos == 1){
            $data['title'] = 'Queued posts';
        }elseif($pos == 2){
            $data['title'] = 'Draft posts';
        }else{
            $data['title'] = 'Sent posts';
        }
      
        
        //total rows count
        $totalRec = count($this->post_model->getRows(array() ,$pos));

        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'post/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['posts'] = $this->post_model->getRows(array('limit'=>$this->perPage), $pos);
        
        //$data['title'] = 'Queued posts';

        //load users for filter
        $data['usr'] = $this->other_model->get_users();
        //load pages for filter
        $data['fbpg'] = $this->other_model->get_fbpage();

        $data['pos']= $pos;
        //load the view
        print_r($this->db->last_query());
        $this->output->enable_profiler();
        $this->load->view('post/post_view', $data);
        // print_r($data['posts']);
        //$data['IsActive'] = true;
        // $this->input->post('working_title')? $data['title like '] = $this->input->post('working_title')."%":false;
        // $this->input->post('user')? $data['created_by'] = $this->input->post('user'):false;
        // $this->input->post('date_from')? $data['created_date >='] = $this->input->post('date_from')." 00:00:00":false;
        // $this->input->post('date_to')? $data['created_date <='] = $this->input->post('date_to')." 23:59:59":false;
        // $this->input->post('archived')? $data['IsActive'] = $this->input->post('archived'):false;
        // $this->input->post('inProgres')? $data['ActionStatus'] = $this->input->post('inProgres'):false;
        // $this->input->post('paused')? $data['ActionStatus'] = $this->input->post('paused'):false;
        
        // $q_post['queued'] = $this->post_model->get_queued($data);
        // // $q_post['title'] = 'Queued posts';
        // $this->output->enable_profiler();
        // $this->load->view('post/post_view', $q_post);
    }

    public function draft(){
        $d_post['draft'] = $this->post_model->get_draft();
        $d_post['title'] = 'Draft posts';
        $this->load->view('post/post_draft_view', $d_post);
    }

    public function sent(){
        $s_post['sent'] = $this->post_model->get_sent();
        $s_post['title'] = 'Sent posts';
        $this->load->view('post/post_sent_view', $s_post);
    }

    public function addpost(){
        // $s_post['sent'] = $this->post_model->get_sent();
        $s_post['title'] = 'Add new posts';
        $this->load->view('post/post_add_post_view',$s_post);
    }

    //jelena start
    public function insert_post(){
        $this->load->helper(array('form', 'url'));

        $post_type='message'; //$this->input->post('post_type');
        
        $_SESSION['user_id']=1;//dok ne dobijemo logovanog usera
       
        if(isset($_SESSION['user_id'])){
            
            $user_id=$_SESSION['user_id'];
           
            /*$w_title=$this->input->post('w_title'); 
            $message = $this->input->post('message');
            $upload_img=$this->input->post('upload_img'); 
            $upload_video = $this->input->post('upload_video');
            $add_link=$this->input->post('add_link');*/
             
            $w_title=$this->input->post('name'); //ovo nije
            $message = $this->input->post('message');
            $upload_img=$this->input->post('imageURL'); //bjese nula
            $upload_video = $this->input->post('video');
            $add_link=$this->input->post('link');
             
           
           $res= $this->post_model->insert_post($user_id, $w_title, $message, $upload_img, $upload_video, $add_link);
                             
            echo 'Inserted Post id: ' . $res;
        }
        else {
            //redirect ('/login');
            echo 'no session user id';
        }
    }

//jelena end

}