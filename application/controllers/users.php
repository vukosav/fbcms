<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_controller {

    public function __construct()
    {
            parent::__construct();
            // $this->load->model('Users_model');
            // $this->load->helper('url_helper');
            // $this->load->model('Other_model');
            // $this->load->library('Ajax_pagination');
            // $this->perPage = 4;
            // $this->load->helper('cookie');
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
        $username = $this->input->post('username');
        $role = $this->input->post('role');
        if(!empty($username)){
            $conditions['search']['username'] = $username;
        }
        if(!empty($role)){
            $conditions['search']['role'] = $role;
        }

        //total rows count
        $totalRec = count($this->Users_model->getRows($conditions));
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'users/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        
        //get posts data
        $data['users'] = $this->Users_model->getRows($conditions);
        
        //load the view
      //  $this->output->enable_profiler();
        $this->load->view('users/ajax-pagination-data', $data, false);
    }

    public function index(){
        $this->no_Admin_permition();

        $data = array();
        
        //total rows count
        $totalRec = count($this->Users_model->getRows());

        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'users/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['users'] = $this->Users_model->getRows(array('limit'=>$this->perPage));
        
        $data['title'] = 'Users';

        //load users for filter
        $data['roles'] = $this->Other_model->get_role();

        //$data['userdata']  =   $this->session->userdata('name');
        
        //load the view
        //$this->output->enable_profiler();
        $this->load->view('users/users_view', $data);

    }

    public function addusr(){

        $this->no_Admin_permition();

        $s_post['title'] = 'Add new user';
        $this->load->view('users/create_users_view',$s_post);
    }
    
    public function createusr(){
        
        $this->no_Admin_permition();

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules(
            'username', 'Username',
            'trim|required|min_length[3]|is_unique[users.username]',
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
            $this->load->view('users/create_users_view', $data);
        }else{

            // $this->input->post('role')? $data['roleid'] = $this->input->post('role'):false;

            $q_post['queued'] = $this->Users_model->insert($data);
            $data['title'] = 'Users';
            //$this->output->enable_profiler();
            redirect('/users/index');
        }
    }

    public function hash_password($password,$salt) {
        return hash('sha256', $password . $salt);
    }

    public function delete ($id){
        $this->no_Admin_permition();
        $this->Users_model->delete($id);
        redirect('/users/index');
    }

    public function edit (){
        $this->no_Admin_permition();

        $this->load->helper(array('form', 'url'));
        $pwd = $this->Users_model->get_users($this->input->post('id'));
        $pwd = array_shift($pwd);
        if($pwd['username']!=$this->input->post('username')){
            $is_uniqueUn =  '|is_unique[users.username]';
        } else {
           $is_uniqueUn =  '';
        }
        if($pwd['email']!=$this->input->post('email')){
            $is_uniqueEm =  '|is_unique[users.email]';
        } else {
           $is_uniqueEm =  '';
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules(
            'username', 'Username',
            'trim|required|min_length[3]'.$is_uniqueUn,
            array(
                    'required'      => 'You have not provided %s.',
                    'is_unique'     => 'This %s already exists.'
            )
        );
        $this->form_validation->set_rules(
            'email', 'E-mail',
            'trim|required'.$is_uniqueEm,
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

        // $password = $this->hash_password($this->password,$salt);
        // $this->db->set('password', $password);
        // $this->db->set('salt', $salt);

        $data = array(
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'name' => $this->input->post('fullname'),
            'roleid' => $this->input->post('role')
        );
        if($pwd['password']!=$this->input->post('password')){
            $data['salt'] = substr(md5(uniqid(rand(), true)), 0, 32);
            $data['password'] = $this->hash_password($this->input->post('password'),  $data['salt']);
        } 
      
        if ($this->form_validation->run() === FALSE){
            $data['title'] = 'Users';
            $data['users'] = false;
            // $this->load->view('templates/header', $data);
            // $this->load->view('news/create');
            // $this->load->view('templates/footer');
            // $this->load->view('users/users_view', $data);
            //$this->output->enable_profiler();
            $this->load->view('users/edit_users_view', $data);
        }else{

            $this->Users_model->update($data, $this->input->post('id'));
            $data['title'] = 'Users';
            //$this->output->enable_profiler();
            redirect('/users/index');
        }
    }
    
    public function show ($id){
        $this->no_Admin_permition();
        $data['users'] = $this->Users_model->get_users($id);
        $data['users'] = array_shift($data['users']);
        $data['title'] = 'Edit user';
        $this->load->view('users/edit_users_view', $data);
    }

    public function editprofile (){      
        
        $this->load->helper(array('form', 'url'));    
        
        if($this->session->userdata('user')['username']!=$this->input->post('username')){
            $is_uniqueUn =  '|is_unique[users.username]';
        } else {
           $is_uniqueUn =  '';
        }
        if($this->session->userdata('user')['email']!=$this->input->post('email')){
            $is_uniqueEm =  '|is_unique[users.email]';
        } else {
           $is_uniqueEm =  '';
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules(
            'username', 'Username',
            'trim|required|min_length[2]'.$is_uniqueUn,
            array(
                    'required'      => 'You have not provided %s.',
                    'is_unique'     => 'This %s already exists.'
            )
        );
        $this->form_validation->set_rules(
            'email', 'E-mail',
            'trim|required'.$is_uniqueEm,
            array(
                    'required'      => 'You have not provided %s.',
                    'is_unique'     => 'This %s already exists.'
            )
        );
        //$file_name = $_FILES['test']['picture'];
        
        $data = array(
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'name' => $this->input->post('fullname'),
            'timezone' => $this->input->post('timezone')
            //'user_image' => isset($file_name)? $file_name:FALSE
        );
        
        $tz['tz'] = $this->Users_model->get_tz();
        $tz['tz'] = array_shift($tz['tz']);

        if ($this->form_validation->run() === FALSE){
            $data['title'] = 'Edit profile';
            $data['users'] = false;
            $data['tz'] = $tz['tz'];
            // $this->output->enable_profiler();
            // print_r($this->session->userdata);
            $this->load->view('users/edit_profile_view', $data);
        }else{
            $newSessionData = array(
                'user_id'   => $this->session->userdata('user')['user_id'],
                'username'  => $this->input->post('username'),
                'name'      => $this->input->post('fullname'),
                'email'     => $this->input->post('email'),
                'logged_in' => TRUE,
                'role'      => $this->session->userdata('user')['role']
            );
            $this->Users_model->update($data, $this->session->userdata('user')['user_id']);
            $data['title'] = 'Edit profile';
            $this->session->set_userdata('user', $newSessionData);
            redirect('/');
            //print_r($data);
        }
    }
    public function no_Admin_permition(){
        if(!isset($this->session->userdata('user')['role'])){
            return redirect('/');
        }
        if($this->session->userdata('user')['role']== 2){
            return redirect('/');
        }
    return true;
    }

    public function ressetpassword (){
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

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

        $data['salt'] = substr(md5(uniqid(rand(), true)), 0, 32);
        $data['password'] = $this->hash_password($this->input->post('password'),  $data['salt']);

        if ($this->form_validation->run() === FALSE){
            $data['title'] = 'Edit profile';
            $data['users'] = false;
            // $this->output->enable_profiler();
            // print_r($this->session->userdata);
            //echo $this->get_list();
            $this->load->view('users/edit_profile_view', $data);
        }else{
            $this->Users_model->update($data, $this->session->userdata('user')['user_id']);
            $data['title'] = 'Edit profile';
            redirect('/');
        }
    }
}