<?php
    require_once FCPATH . '/vendor/autoload.php'; // change path as needed  
class Add_Pages extends CI_Controller {

    public function __construct()  {
         parent::__construct();
         $this->load->helper('url_helper');
         $this->load->library('FacebookPersistentDataInterface');
         $this->load->model('FB_model');
         $this->load->model('Users_model');
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
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get(
                //olivia olivia token'
            '/debug_token?input_token='. $input_token, 
            //app_id|app_secret
            $access_token
        );
           $graphNode = $response->getGraphNode();
           return $graphNode;
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        
    }  
    public function index(){

        if($this->Users_model->isLoggedIn()){

            $user_id = $this->session->userdata('user')['user_id'];
            if (isset($_SESSION['facebook_access_token'])){ 
                $accessToken=$_SESSION['facebook_access_token']; 
                $fb = new \Facebook\Facebook([
                    'app_id' => FB_APP_ID,
                    'app_secret' => FB_APP_SECRET,
                    'default_graph_version' => FB_API_VERSION,
                    'persistent_data_handler' => new FacebookPersistentDataInterface(),
                ]);

                try { 
                        $response = $fb->get('/me?fields=id,name', $accessToken);
                        $user = $response->getGraphUser();
                        $fb_name= $user->getName();
                        $fb_user_id=$user->getId();

                        $graphNode = $this->debug_token($accessToken); 
                        $is_valid_at = ($graphNode['is_valid']) ? 'true' : 'false';
                        $expires_at = ($graphNode['expires_at']); 
                        $ret=$this->FB_model->insert_fb_user($user_id
                                                            ,$fb_user_id
                                                            , $fb_name
                                                            , $accessToken
                                                            , $expires_at
                                                            , $is_valid_at); 
               
                        if($ret==0){
                            echo '<br>You are trying to add pages for fb user different than one you have registered with';
                            echo '<br>Please try to log in with registered fb user!';
                            redirect('/fbcheck');
                        }
                    elseif($ret==1){ 
                            
                                 $params = array('fields'=> 'id,name,likes,access_token,picture,cover', );
                                 $response = $fb->sendRequest('GET','/me/accounts', $params, $accessToken);
                                 $pages = $response->getDecodedBody();
                                 for ($i = 0; $i < count( $pages); $i++) {
                                     $fbPage_at=$pages['data'][$i]['access_token'];
                                     $fbpage_id=$pages['data'][$i]['id'];
                                     $graphNode = $this->debug_token($fbPage_at); 
                                     $is_valid_at = ($graphNode['is_valid']) ? 'true' : 'false';
                                     $expires_at = ($graphNode['expires_at']); 

                                     $this->db->where("userId",$user_id);
                                     $this->db->where("fbPageId",$fbpage_id);
                                     $this->db->set("fbPageAT",$fbPage_at);
                                     $this->db->set("fbat_valid",$is_valid_at);
                                     $this->db->set("fbat_expires",$expires_at->format("Y-m-d H:i:s"));
                                     $this->db->set("last_fbupdate",date("Y-m-d H:i:s"));
                                     $this->db->update('pages');
                                } 

                                $new_pages = $this->FB_model->list_new_pages($pages,$user_id);
                                if ($new_pages!=null){ 
                                     $data = array('fbpages' => $new_pages
                                                        , 'title' => 'Add New Facebook Pages'
                                                        , 'user_id'  => $user_id
                                                        , 'fb_user_id'  => $fb_user_id
                                                        , 'fb_name' => $fb_name);
                                    $this->load->view('users/fbpages', $data);
                                }
                                else{
                                   redirect('/pages');
                                }
                            
                                            
                  }  else {
                    //todo - redirect ...
                    redirect ('/');
                   }
                    } catch(\Facebook\Exceptions\FacebookResponseException $e) {
                        // When Graph returns an error
                        echo 'Graph returned an error: ' . $e->getMessage();
                        exit;
                    } catch(\Facebook\Exceptions\FacebookSDKException $e) {
                        // When validation fails or other local issues
                        echo 'Facebook SDK returned an error: ' . $e->getMessage();
                        exit;
                    }
                };

        } else {  redirect ('/login'); }

    } 


    public function insert_pages(){
       
        $this->load->helper(array('form', 'url'));
        $numofpages=$this->input->post('numofpages');
        
        if($this->Users_model->isLoggedIn()){

            $user_id = $this->session->userdata('user')['user_id'];
            
            $numofpages=$this->input->post('numofpages'); 
            //echo $numofpages . ' new pages. Added pages:';
             
             if($numofpages>0){
                 $res=0;

                for ($i = 1; $i <= $numofpages; $i++) {

                    if($this->input->post('chk'. $i)) {
                            $strval= $this->input->post('fbp'. $i);
                            
                            $posN = strpos( $strval, 'fbpn=');
                           // echo '<br>posN:' . $posN;
                            
                             
                            if ($posN !== false) {
                                $fbpage_id=substr ($strval , 6 , $posN-6);
                               // echo '<br>Page id:' . $fbpage_id;
                           
                                $posAT = strpos( $strval, '_fbpAT=_'); 
                                //echo '<br>posAT:' . $posAT; 

                               $fbPageAccessToken = substr($strval, $posAT+8) ;
                               //echo '<br>Page AT:' . $fbPageAccessToken;

                                $fbPage_name=substr ($strval ,$posN+5, $posAT-$posN-5);
                                //echo '<br>Page name:' . $fbPage_name; 
                                
                                $res=3;
                                 //debug page token
                                 $graphNode = $this->debug_token($fbPageAccessToken); 
                                 $is_valid_at = ($graphNode['is_valid']) ? 'true' : 'false';
                                 $expires_at = ($graphNode['expires_at']);
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