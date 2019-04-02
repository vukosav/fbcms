<?php
 require_once FCPATH . '/vendor/autoload.php'; // change path as needed      
class LoginCallback extends CI_Controller {

       public function __construct()
    {
            parent::__construct();
            $this->load->helper('url_helper');
            $this->load->library('FacebookPersistentDataInterface');
            $this->load->model('Pages_model');
            $this->load->model('FB_model');
            $this->load->model('Users_model');
    }

    public function index(){
        
      if (!isset($_SESSION)) { session_start(); }   
      if(!$this->Users_model->isLoggedIn()){
        redirect ('/login');
      }
     
        $user_id = $this->session->userdata('user')['user_id'];

        $fb = new \Facebook\Facebook([
        'app_id' => FB_APP_ID,
        'app_secret' => FB_APP_SECRET,
        'default_graph_version' => FB_API_VERSION ,
          'persistent_data_handler' => new FacebookPersistentDataInterface(),
      ]);

    $helper = $fb->getRedirectLoginHelper();

    $accessToken = $helper->getAccessToken();


    $graphNode = $this->debug_token($accessToken); 
      
      //if token validation had no errors, update user data
     if($graphNode!=null){

          $is_valid_at = ($graphNode['is_valid']) ? 'true' : 'false';
      
          if(strtotime($graphNode['expires_at']->format("Y-m-d H:i:s")) != 0){
            $expires_at = date("Y-m-d H:i:s",$graphNode['expires_at']);
          }
          else {
            $expires_at = null;
          }
      }
      else {
        $is_valid_at='true';
        $expires_at = null;
      }


    if (isset($accessToken)) {
      $_SESSION['facebook_access_token'] = (string) $accessToken;
    }
    
    try {
      $this->session->set_userdata('fb_check_user_add_update_error',null);
      $this->session->set_userdata('fb_different_login_warning',null);
      $this->session->set_userdata('fb_no_new_pages_info',null);
      $this->session->set_userdata('fb_graph_error',null);
      $this->session->set_userdata('fb_sdk_error',null);
      $this->session->set_userdata('fb_removed_pages_info',null);
      

      $response = $fb->get('/me?fields=id,name', $accessToken);
      $user = $response->getGraphUser();
      $fb_name= $user->getName();
      $fb_user_id=$user->getId();


      $ret=$this->FB_model->insert_fb_user($user_id,$fb_user_id, $fb_name, $accessToken, $expires_at, $is_valid_at); 
          if($ret!=0 && $ret!=1)  { 
            $this->session->set_userdata('fb_check_user_add_update_error', "Something went wrong. Please try again.");
            redirect('/fbcheck');
          }
          if($ret==0){
              // User tried to add FB pages with fb user different than registered 
              // redirect na fbcheck with warning
              $this->session->set_userdata('fb_different_login_warning',
                    'You are trying to add pages for fb user ' . $fb_name . 
                    ' different than one you have registered with. ' .
                    ' Please try to log in with registered fb user.');
              redirect('/fbcheck');
          }
        
          if($ret==1){ 
              $params = array('fields'=> 'id,name,likes, picture, access_token', );
              $response = $fb->sendRequest('GET','/me/accounts', $params, $accessToken);
              
              $pages = $response->getDecodedBody();
                  
              $num_of_pages =  count($pages['data']);
              for ($i = 0; $i < $num_of_pages; $i++) {
                  $fbPage_at=$pages['data'][$i]['access_token'];
                  $fbpage_id=$pages['data'][$i]['id'];
                  $fbPage_name=$pages['data'][$i]['name'];

                  $graphNode = $this->debug_token($fbPage_at);
                  //if token validation had no errors, update page data
                  if($graphNode!=null){

                      $is_valid_at = ($graphNode['is_valid']) ? 'true' : 'false';
           
                      if(strtotime($graphNode['expires_at']->format("Y-m-d H:i:s")) != 0){
                        $expires_at = date("Y-m-d H:i:s", $graphNode['expires_at']);
                      }
                      else {
                        $expires_at = null;
                      }
  
                      $this->FB_model->update_page($fbpage_id
                      , $fbPage_name
                      , $fbPage_at
                      , $user_id
                      , $is_valid_at
                      , $expires_at);
                  }
            }
          
            $removed_pages =  $this->FB_model->list_removed_pages($pages,$user_id);
           
            $new_pages = $this->FB_model->list_new_pages($pages,$user_id);

            if(count($removed_pages)>0){
              $message = '';
              for($i=0; $i < count($removed_pages); $i++){
                $message = $message . $removed_pages[$i]['fbPageName'] . ', ';
              }
              $this->session->set_userdata('fb_removed_pages_info', 'You have deautorized these Facebook pages: ' . $message . ' and they are no longer available for use in the system.');  
            }

            if ($new_pages!=null){ 
              $data = array('fbpages' => $new_pages
              , 'title' => 'Add New Facebook Pages'
              , 'user_id'  => $user_id
              , 'fb_user_id'  => $fb_user_id
              , 'fb_name' => $fb_name);
            $this->session->set_userdata('FB_UAT',null);
             $this->load->view('users/fbpages', $data); 
            }
            else{
                ///no new pages on fb for user, redirest to fbcheck with info message
                $this->session->set_userdata('fb_no_new_pages_info',"There are no new pages on your FB account that could be added.");  
                $this->session->set_userdata('FB_UAT',null);
                redirect('/fbcheck');
            }
    }  
    }  catch(Facebook\Exceptions\FacebookResponseException $e) {
      // When Graph returns an error
      $this->session->set_userdata('fb_graph_error','Facebook Graph api returned an error: ' .$e->getMessage());
      redirect('/fbcheck');

    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      // When validation fails or other local issues
      $this->session->set_userdata('fb_sdk_error','Facebook SDK returned an error: ' . $e->getMessage());
      redirect('/fbcheck');
    }
  }


  public function debug_token($input_token){
        if (!isset($_SESSION)) { session_start(); }   
        $fb = new \Facebook\Facebook([
                'app_id' => FB_APP_ID,
                'app_secret' => FB_APP_SECRET,
                'default_graph_version' => FB_API_VERSION
        ]);
        $access_token = FB_APP_ID .'|' . FB_APP_SECRET; 
        try {
            $response = $fb->get('/debug_token?input_token='. $input_token, $access_token);
            $graphNode = $response->getGraphNode();
            return $graphNode;
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            $this->session->set_userdata('fb_token_validation_graph_error','Facebook Graph api returned an error: ' .$e->getMessage());
            return null;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
          $this->session->set_userdata('fb_token_validation_sdk_error','Facebook SDK returned an error: ' . $e->getMessage());
          return null;
        }
  }

  public function insert_pages(){
       
      $this->load->helper(array('form', 'url'));
      $numofpages=$this->input->post('numofpages');
    
      if($this->Users_model->isLoggedIn()){

          $user_id = $this->session->userdata('user')['user_id'];
          $numofpages=$this->input->post('numofpages'); 
                  
          if($numofpages>0){
              $res=0;
              for ($i = 1; $i <= $numofpages; $i++) {
                  if($this->input->post('chk'. $i)) {
                        $strval= $this->input->post('fbp'. $i);
                        $posN = strpos( $strval, 'fbpn=');
                        if ($posN !== false) {
                            $fbpage_id=substr ($strval , 6 , $posN-6);
                            $posAT = strpos( $strval, '_fbpAT=_'); 
                            $fbPageAccessToken = substr($strval, $posAT+8) ;
                            $fbPage_name=substr ($strval ,$posN+5, $posAT-$posN-5);
                            $res=3;
                            
                            $graphNode = $this->debug_token($fbPageAccessToken); 
                            $is_valid_at = ($graphNode['is_valid']) ? 'true' : 'false';

                            if(strtotime($graphNode['expires_at']->format("Y-m-d H:i:s")) != 0){
                              $expires_at = date("Y-m-d H:i:s",$graphNode['expires_at']);
                            }
                            else {
                              $expires_at = null;
                            }
                            $res= $res + $this->FB_model->insert_page($fbpage_id
                                                                    , $fbPage_name
                                                                    , $fbPageAccessToken
                                                                    , $user_id
                                                                    ,  $is_valid_at
                                                                    , $expires_at);
                        }
                  }
              }  
            
            if($res>0){
              redirect('/pages');
             }
            else 
            { redirect('/'); }
          }
      }  
  }

}
?>