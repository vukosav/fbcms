<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH . '/vendor/autoload.php';
use Facebook\PersistentData\PersistentDataInterface; 

class FacebookPersistentDataInterface implements PersistentDataInterface { 

//** * @ var string Prefix to use for session variables. / 
	
	protected $ci;
	protected $sessionPrefix = 'FBRLH_';

	public function __construct(){
		
		//require_once FCPATH . '/vendor/autoload.php';
		
		$this->ci =& get_instance();
		
		
	}

 	public function get($key) {

		$this->ci->load->library('session');
		//return session()->get($this->sessionPrefix . $key); 
		return $this->ci->session->userdata($this->sessionPrefix.$key);
    } 
        		
	public function set($key, $value) { 
		$this->ci->load->library('session');
		//session()->set($this->sessionPrefix . $key, $value); 
		$this->ci->session->set_userdata($this->sessionPrefix.$key, $value);
	}

}

?>