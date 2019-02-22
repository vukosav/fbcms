<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {

	private $settings;
	private $currentUser = array();
	private $allowedTypes = array();
	private $uploadMaxSize = 1000;
	private $userFolder = 1000;

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {

		parent::__construct();
		$this->load->database();
		$this->load->library(array('session'));

		define('UPLOADS_MAX_SIZE_IMAGE','1000');
		define('UPLOADS_MAX_SIZE_VIDEO','30000000');
		define('AUTO_RESIZE',TRUE);
		define('ENABLE_WATERMARK',TRUE);
		

		/*$this->load->model('User_Model');
		$this->load->model('Settings_Model');
		
		// If user is not logged in redirect to login page
		if(!$this->User_Model->isLoggedIn()){
			redirect('/login');
		}
		
		$this->currentUser = $this->User_Model->currentUser();
			
		// If the user account has expired show expiry page
		if($this->currentUser['expired'] == 1){
			redirect('account_expiry');
			exit();
		}

		$this->load->library('twig');
		$this->load->model('FbAccount_Model');
		
		$this->settings = $this->Settings_Model->get();

		$this->config->set_item('language', $this->currentUser['lang']);

		$this->lang->load(array("general"));

		$this->twig->addGlobal('fbaccount', $this->FbAccount_Model);
		$this->twig->addGlobal('user', $this->User_Model);
		$this->twig->addGlobal('app_settings', $this->settings);

		// Set User Timezone
		date_default_timezone_set($this->currentUser['timezone']);

		$this->userFolder = UPLOADS_FOLDER . "/" . $this->currentUser['username'];*/
		$this->userFolder = "files/jelena";
	}

	public function upload_video(){

		// Check if the user can upload videos
		//$this->User_Model->setId($this->currentUser['user_id']);
		/*if(!$this->User_Model->canUploadVideos()){
			$this->load->helper('json_helper');
			display_json(array(
				'error' => $this->lang->s('Uploading videos is not allowed on your account')
			));
			return;
		}*/

		$this->uploadMaxSize = UPLOADS_MAX_SIZE_VIDEO;
		$this->allowedTypes = array(
			'video/x-msvideo',
			'video/mp4',
			'video/mpeg',
			'video/3gpp',
			'video/quicktime',
			'video/ogg',
			'video/webm'			
		);

		$this->elfinderConnector();
		return;
	}

	public function upload_image(){

		// Check if the user can upload images
	/*	$this->User_Model->setId($this->currentUser['user_id']);
		if(!$this->User_Model->canUploadImages()){
			$this->load->helper('json_helper');
			display_json(array(
				'error' => $this->lang->s('Uploading images is not allowed on your account')
			));
			return;
		}*/

		$this->uploadMaxSize = UPLOADS_MAX_SIZE_IMAGE;
		$this->allowedTypes = array(
			'image/jpeg',
			'image/png',
			'image/gif'
		);
		$this->elfinderConnector();
		return;
	}

	private function elfinderConnector(){

		// Check if the user can upload videos
		/*if(strtolower($this->input->get('cmd',TRUE)) == 'ls'){
			$this->User_Model->setId($this->currentUser['user_id']);
				if($this->User_Model->isExceededMaxUpload($this->userFolder)){
					$this->load->helper('json_helper');
					display_json(array(
						'error' => $this->lang->s('You reached the maximum upload size allowed on your account')
					));
					return;
				}
		}*/

		$this->load->helper(array('form','elfinder_access'));

		// check user upload folder
		if (!file_exists($this->userFolder)) {
		    mkdir($this->userFolder, 0777, true);
		    chmod($this->userFolder, 0777);
		}

		if (!file_exists($this->userFolder . '/index.html')) {
			$handle = fopen($this->userFolder . '/index.html','w+'); 
			fwrite($handle,"<h1>404 Not Found</h1>\nThe page that you have requested could not be found."); 
			fclose($handle); 
		}

		$binds = array();
		$plugins = array();

		$binds[] = 'Plugin.Sanitizer.onUpLoadPreSave';
		$plugins['Sanitizer'] = array(
	            'enable' => true,
	            'targets'  => array('\\','/',':','*','?','"','<','>','|',' '), // target chars
	            'replace'  => '_'    // replace to this
		);

		if(AUTO_RESIZE){
			$binds[] = 'Plugin.AutoResize.onUpLoadPreSave';
			$plugins['AutoResize'] = array(
		        'enable' => true,
		        'maxWidth'  => 1080,
		        'maxHeight'  => 1080,
		        'quality' => 100
		    );
		}

		if(ENABLE_WATERMARK){
			$this->load->helper("general_helper");
			$binds[] = 'Plugin.Watermark.onUpLoadPreSave';
			$plugins['Watermark'] = array(
		        'source' => FCPATH.'theme/default/images/watermark.png',
		        'marginRight' => 2,
				'marginBottom' => 2,
				'transparency' => 50
	        );
		}


		$opts = array(
			'debug' => false,
			'bind' => array(
		        'mkdir.pre mkfile.pre rename.pre' => array('Plugin.Sanitizer.cmdPreprocess'),
		        'upload.presave' => $binds
		    ),
		    'plugin' => $plugins,
			'roots' => array(
				array(
					'driver'        => 'LocalFileSystem',
					'path'          => $this->userFolder,
					'URL'           => assets($this->userFolder),
					'uploadDeny'    => array('all'),
					'uploadAllow'   => $this->allowedTypes,
					'uploadOrder'   => array('deny', 'allow'),
					'accessControl' => 'elfinder_access',
					'uploadMaxConn' => 3,
					'uploadMaxSize' => $this->uploadMaxSize."K",
					'duplicateSuffix' => '_%s_',
					'attributes' 	=> array(
			            array(
			                'pattern' => '/\.(html|php|py|pl|sh|xml)$/i',
			                'read'   => false,
			                'write'  => false,
			                'locked' => true,
			                'hidden' => true
			            )
			        )
				)
			)
		);

		$this->load->library('Elfinder_lib',$opts);
	}
}
