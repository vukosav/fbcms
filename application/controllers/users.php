<?php

class Users extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('users_model');
            $this->load->helper('url_helper');
            $this->load->model('other_model');
            $this->load->library('Ajax_pagination');
            $this->perPage = 4;
            $this->load->helper('cookie');
    }


    public function login() {

		// If user is logged in redirect to home page
		if($this->users_model->isLoggedIn())
			redirect('/');

		// Check if cookie session is exists
                        // if($uscode = $this->input->cookie($this->config->item('sess_cookie_name')."_usid", TRUE)){
                        // 	if($this->users_model->loginFromCookie($uscode)){
                        // 		redirect("/");
                        // 	}
                        // }

		// load form helper and validation library
                            // $this->load->helper('form');
                            // $this->load->library('form_validation');

        // set validation rules
        $this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email or Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		if ($this->form_validation->run() == false) {
            // validation not ok, send validation errors to the view
            $data['title'] = 'Users';
            $data['users'] = false;
			$this->load->view('users/login_view', $data);
		} else {
			// set variables from the form
			$username = $this->input->post('email',TRUE);
			$password = $this->input->post('password',TRUE);
                                            //$rememberMe = $this->input->post('remember',TRUE) == "on" ? TRUE : FALSE;

			if ($this->users_model->checkUserLogin($username, $password)) {
				// user login ok
				// if($this->session->userdata('next_after_login')){
				// 	$uri = $this->session->userdata('next_after_login');
				// 	$this->session->unset_userdata('next_after_login');
				// 	redirect($uri);
				// 	exit();
				// }else{
				// 	redirect("dashboard");
				// 	exit();
                // }
               // print_r($this->session->userdata()); 
                echo "<h1>bla bla bla</h1>";
                redirect('dashboard');
                //$this->load->view('dashboard', $data);
			} else {
				// login failed
				//$twigData['flash'][] = flash_bag($this->users_model->getErrors(),"danger");
				
			}
		}
		
		// send error to the view
		//$this->twig->display('public/login',$twigData);
    }
    
    public function logout() {
        if(!$this->users_model->isLoggedIn())
			redirect('login');
		$this->users_model->loggedOut();
		redirect('dashboard');
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
        $totalRec = count($this->users_model->getRows($conditions));
        
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
        $data['users'] = $this->users_model->getRows($conditions);
        
        //load the view
      //  $this->output->enable_profiler();
        $this->load->view('users/ajax-pagination-data', $data, false);
    }

    public function index(){
        $data = array();
        
        //total rows count
        $totalRec = count($this->users_model->getRows());

        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'users/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['users'] = $this->users_model->getRows(array('limit'=>$this->perPage));
        
        $data['title'] = 'Users';

        //load users for filter
        $data['roles'] = $this->other_model->get_role();

        //$data['userdata']  =   $this->session->userdata('name');
        
        //load the view
        $this->output->enable_profiler();
        $this->load->view('users/users_view', $data);

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