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

    public function post_queued_view(){
        $this->load->helper('form');
        //$this->load->library('form_validation');

        $q_post['title'] = 'Queued posts';
        $q_post['queued'] = $this->post_model->find_que();
        //$q_post['queued'] = $this->post_model->get_queued($data);
        $this->load->view('post/index', $q_post);
    }

}