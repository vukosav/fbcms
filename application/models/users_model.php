<?php

class Users_model extends CI_Model{
    
    public function __construct()
    {
            //$this->load->database();
    }

    public function isLoggedIn(){
		if(isset($this->session->userdata('user')['logged_in']))
			return true;

		return false;
    }
    
    public function checkUserLogin($username, $password) {
		$this->db->from('users');
		$this->db->where('username', $username);
		$this->db->or_where('email', $username);
		$queryResult = $this->db->get();

        // Check password
        $makeHash = hash('sha256', $password . $queryResult->row('salt'));

        // Check check password
        if($makeHash !== $queryResult->row('password')){
            $this->errors = ("Incorrect username/password.");
            return FALSE;
        }

        if(!$this->userLogin($queryResult)){
            return false;
        }

		// if($rememberMe){
		// 	$sessionCode = $this->saveUserSession($makeHash,(int)$queryResult->row('id'));
		// 	$cookie = array(
		//         'name'   => '_usid',
		//         'value'  => $sessionCode,
		//         'expire' => '900000',
		//         'path'   => '/',
		//         'prefix' => $this->config->item('sess_cookie_name'),
		//         'secure' => FALSE
		// 	);
		// 	$this->input->set_cookie($cookie);
		// }
		return true;
    }
    
    public function userLogin($user){

        // Is user account active
        if((int)$user->row('IsActive') == 0){
           $this->errors = ("Your account is not activated. please contact the site administrator in order to activate your account.");
            return false;
        }

        $userData = array();

        $newUserData = array();

        date_default_timezone_set('UTC');

        $now = new DateTime();

        $newUserData['last_login'] = date('Y-m-d h:i:s', time());

        //$this->setId($user->row('id'));
        //$this->update($newUserData);

        $userData['user_id'] = $user->row('id');
        $userData['username'] = (string)$user->row('username');
        $userData['name'] = (string)$user->row('name');
        $userData['email'] = (string)$user->row('email');
        $userData['logged_in'] = TRUE;
        $userData['role'] = $user->row('roleId');

        $this->setUserSession($userData);

        return true;
    }

    private function setUserSession($data){
		// set session user data
		$this->session->set_userdata('user',$data);
	}
    
    public function loggedOut(){
		$this->db->where("user_id",$this->session->userdata('user')['user_id']);
        $this->session->sess_destroy();
		return $this->db->delete('users_session');
    }
    
    /**
     * @usage
     * Single:
     * All:
     * Custom:
     */
    public function get_users($id = null){
        if($id === null){
            $this->db->where('users.IsActive = ', 1);
            $this->db->select('users.*, roles.name as rname, uu.username as addedby');
            $this->db->from('users');
            $this->db->join('roles', 'roles.id = users.roleId');
            $this->db->join('users as uu', 'uu.id = users.createdBy', 'left outer');
            // $this->db->where('IsActive', 1);
            $query = $this->db->get();
        }elseif(is_array($id)){
            $this->db->where('users.IsActive = ', 1);
            $this->db->where($id);
            $this->db->select('users.*, roles.name as rname, uu.username as addedby');
            $this->db->from('users');
            $this->db->join('roles', 'roles.id = users.roleId');
            $this->db->join('users as uu', 'uu.id = users.createdBy', 'left outer');
            $query = $this->db->get();
            // $query = $this->db->get();
        }else{
            $this->db->where('users.IsActive = ', 1);
            $this->db->select('users.*, roles.name as rname, uu.username as addedby');
            $this->db->from('users');
            $this->db->join('roles', 'roles.id = users.roleId');
            $this->db->join('users as uu', 'uu.id = users.createdBy', 'left outer');
            $this->db->where('users.id = ', $id);
            $query = $this->db->get();
        }
        return $query->result_array();
    }
    
    function getRows($params = array()){
        $this->db->where('users.IsActive = ', 1);
        $this->db->select('users.*, users.username, roles.name as rname, uu.username as addedby');
        $this->db->from('users');
        $this->db->join('roles', 'roles.id = users.roleId');
        $this->db->join('users as uu', 'uu.id = users.createdBy', 'left outer');
        //filter data by searched keywords
        if(!empty($params['search']['role'])){
            $this->db->where('users.roleId',$params['search']['role']);
        }
        //filter data by searched keywords
        if(!empty($params['search']['username'])){
            $this->db->like('users.username',$params['search']['username']);
        }
        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        //get records
        $query = $this->db->get();
        //return fetched data
        return ($query->num_rows() > 0)?$query->result_array():array();
    }

    //-------------CRUD--------------------------
    /**
     * @usage
     */
    public function insert($data){
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    /**
    * @usage
    */
    // public function update($data, $post_id){
    //     $this->db->where(['post_id', $post_id]);
    //     $this->db->update('post', $data);
    //     return $this->db->affected_rows();
    // }

    /**
    * @usage
    */
    public function delete($id){
        $this->db->set('IsActive', false);
        $this->db->where('id', $id);
        $this->db->update('users');
        //$this->db->delete('users', $id);
        return $this->db->affected_rows();
    }
    //-------------END CRUS--------------------


}
