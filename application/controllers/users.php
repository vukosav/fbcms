<?php

class Users extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('users_model');
            $this->load->helper('url_helper');
    }

    public function index(){
        $status['IsActive'] = true;
        $data['users'] = $this->users_model->get_users();
        $data['title'] = 'Users';
        $this->output->enable_profiler();
        $this->load->view('users/users_view', $data);
        // $this->load->helper('url');
        
        // $data['IsActive'] = true;
        // $this->input->post('working_title')? $data['title like '] = $this->input->post('working_title')."%":false;
        // $this->input->post('user')? $data['created_by'] = $this->input->post('user'):false;
        // $this->input->post('date_from')? $data['created_date >='] = $this->input->post('date_from')." 00:00:00":false;
        // $this->input->post('date_to')? $data['created_date <='] = $this->input->post('date_to')." 23:59:59":false;
        // $this->input->post('archived')? $data['IsActive'] = $this->input->post('archived'):false;
        // $this->input->post('inProgres')? $data['ActionStatus'] = $this->input->post('inProgres'):false;
        // $this->input->post('paused')? $data['ActionStatus'] = $this->input->post('paused'):false;
        

        // $q_post['queued'] = $this->post_model->get_queued($data);
        // $q_post['title'] = 'Queued posts';
        // $this->output->enable_profiler();
        // $this->load->view('post/post_queued_view', $q_post);
    }

    public function addusr(){

        
        // $q_post['title'] = 'Queued posts';
        // $this->output->enable_profiler();
        // $this->load->view('post/post_queued_view', $q_post);

        // $s_post['sent'] = $this->post_model->get_sent();
        $s_post['title'] = 'Add new user';
        $this->load->view('users/singup',$s_post);
    }
    
    public function createusr(){
        
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules(
            'username', 'Username',
            'trim|required|min_length[5]|max_length[12]|is_unique[users.username]',
            array(
                    'required'      => 'You have not provided %s.',
                    'is_unique'     => 'This %s already exists.'
            )
        );
        $this->form_validation->set_rules(
            'email', 'E-mail',
            'trim|required|is_unique[users.email]',
            array(
                    'required'      => 'You have not provided %s.',
                    'is_unique'     => 'This %s already exists.'
            )
        );
        
        $this->form_validation->set_rules(
            'password', 'Password',
            'trim|required|min_length[6]',
            array(
                    'required'      => 'You have not provided %s.'
            )
        );
        
        $this->form_validation->set_rules(
            'conpassword', 'Confirm Password',
            'trim|required|matches[password]',
            array(
                    'required'      => 'You have not provided %s.'
            )
        );

        $salt = substr(md5(uniqid(rand(), true)), 0, 32);
        // $password = $this->hash_password($this->password,$salt);
        // $this->db->set('password', $password);
        // $this->db->set('salt', $salt);




        $data = array(
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'name' => $this->input->post('fullname'),
            'dateCreated' => date('Y-m-d h:i:s', time()),
            'password' => $this->hash_password($this->input->post('password'), $salt),
            'roleid' => $this->input->post('role'),
            'IsActive' => true,
            'createdBy' => 1,
            'salt' => $salt
        );
      
        if ($this->form_validation->run() === FALSE){
            $data['title'] = 'Users';
            $data['users'] = false;
            // $this->load->view('templates/header', $data);
            // $this->load->view('news/create');
            // $this->load->view('templates/footer');
            // $this->load->view('users/users_view', $data);
            $this->load->view('users/singup', $data);
        }else{

            // $this->input->post('role')? $data['roleid'] = $this->input->post('role'):false;

            $q_post['queued'] = $this->users_model->insert($data);
            $data['title'] = 'Users';
            $this->output->enable_profiler();
            redirect('/users/index');
        }

       
        // $this->load->view('users/users_view', $data);
    }

    public function hash_password($password,$salt) {
        return hash('sha256', $password . $salt);
    }

    public function delete ($id){
        $this->users_model->delete($id);
        redirect('/users/index');
    }
}
