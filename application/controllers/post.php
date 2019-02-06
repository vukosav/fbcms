<?php

class Post extends CI_Controller {

    //  public function __construct()
    // {
    //     parent::__construct();
    //     $this->load->model('dashboard_model');
    //     $this->load->helper('url_helper');
    // }

    public function __construct()
    {
            parent::__construct();
            $this->load->model('post_model');
            $this->load->helper('url_helper');
    }

    public function index(){
        $q_post['queued'] = $this->post_model->get_queued();
        $q_post['title'] = 'Queued posts';
        $this->load->view('post/post_queued_view', $q_post);
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

    function search_keyword()
    {
        $data = null;
        $this->input->post('working_title')? $data['title'] = $this->input->post('working_title'):false;
        $this->input->post('user')? $data['created_by'] = $this->input->post('user'):false;
        $this->input->post('date_from')? $data['created_date'] = $this->input->post('date_from'):false;
        $this->input->post('date_to')? $data['created_date'] = $this->input->post('date_to'):false;
        $this->input->post('all')? $data['IsActive'] = $this->input->post('all'):false;
        //$this->input->post('user')? $data['ActionStatus'] = $this->input->post('all'):false;
        // $data = array(
        //     'title' => $this->input->post('working_title'),
        //     //'group' => $this->input->post('group'),
        //     // 'fbpage' => $this->input->post('fbpage'),
        //     // 'date_from' => $this->input->post('date_from'),
        //     // 'date_to' => $this->input->post('date_to'),
        //     'created_by	' => $this->input->post('user')
        // );

        $q_post['queued'] = $this->post_model->get_queued($data);
        $q_post['title'] = 'Queued posts';
        $this->output->enable_profiler();
        $this->load->view('post/post_queued_view', $q_post);

    }

}