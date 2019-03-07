<?php

class Add_Pages extends CI_Controller {

    public function __construct()  {
         parent::__construct();
         $this->load->helper('url_helper');
         $this->load->library('FacebookPersistentDataInterface');
         $this->load->model('FB_model');
         $this->load->model('Users_model');
    }

    public function index(){

        if($this->Users_model->isLoggedIn()){

            $user_id = $this->session->userdata('user')['user_id'];

          
            if (isset($_SESSION['facebook_access_token'])){

                $accessToken=$_SESSION['facebook_access_token'];
               // $expdate= $_SESSION['expdate_access_token']; 

               // echo 'accessToken ' . $accessToken;
               // echo '<br>expdate ' . $expdate;

                //collect info about fb user
                $fb = new \Facebook\Facebook([
                    'app_id' => '503878473471513',
                    'app_secret' => '28cbbb9f440b1b016e9ce54376ada17e',
                    'default_graph_version' => 'v3.2',
                    'persistent_data_handler' => new FacebookPersistentDataInterface(),
                ]);

                try {
                        // Get the \Facebook\GraphNodes\GraphUser object for the current user.
                        // If you provided a 'default_access_token', the '{access-token}' is optional.
                        $response = $fb->get('/me?fields=id,name', $accessToken);
                    } catch(\Facebook\Exceptions\FacebookResponseException $e) {
                        // When Graph returns an error
                        echo 'Graph returned an error: ' . $e->getMessage();
                        exit;
                    } catch(\Facebook\Exceptions\FacebookSDKException $e) {
                        // When validation fails or other local issues
                        echo 'Facebook SDK returned an error: ' . $e->getMessage();
                        exit;
                    }

                    $user = $response->getGraphUser();
                    
                    $fb_name= $user->getName();
                    $fb_user_id=$user->getId();

                    //insert fb user if it's not already registered
                    
                
                    
                                
                    $this->FB_model->insert_fb_user($user_id,$fb_user_id, $fb_name, $accessToken);

                            
                $fb = new \Facebook\Facebook([
                    'app_id' => '503878473471513',
                    'app_secret' => '28cbbb9f440b1b016e9ce54376ada17e',
                    'default_graph_version' => 'v3.2',
                    'persistent_data_handler' => new FacebookPersistentDataInterface(),
                ]);

                // Get the pages for FB user
                try {
                    
                    // If you provided a 'default_access_token', the '{access-token}' is optional.
                    $params = array(
                        'fields'=> 'id,name,likes,access_token,picture,cover',
                    );
                    $response = $fb->sendRequest('GET','/me/accounts', $params, $accessToken);
                } catch(\Facebook\Exceptions\FacebookResponseException $e) {
                    // When Graph returns an error
                    echo 'Graph returned an error: ' . $e->getMessage();
                    exit;
                } catch(\Facebook\Exceptions\FacebookSDKException $e) {
                    // When validation fails or other local issues
                    echo 'Facebook SDK returned an error: ' . $e->getMessage();
                    exit;
                }
                
            
                $pages = $response->getDecodedBody();
                //echo '<br> 1. niz pages: ';
                //var_dump($pages);
            
                $new_pages = $this->FB_model->list_new_pages($pages,$user_id);
                // $new_pages=$fb_pages['data'];
                //   echo '<br><br> 2. niz new pages: ';
                // var_dump($new_pages);

                if ($new_pages!=null){

                    $data = array('fbpages' => $new_pages, 'title' => 'Add New Facebook Pages', 'user_id'  => $user_id, 'fb_user_id'  => $fb_user_id, 'fb_name' => $fb_name); 
                
                // var_dump($data);
                $this->load->view('users/fbpages', $data);
                }
                else {
                    //todo - redirect ...
                    echo 'no new pages';
                }

            };

        } else {
            
            redirect ('/login');
        }

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
                                $res= $res + $this->FB_model->insert_page($fbpage_id, $fbPage_name, $fbPageAccessToken, $user_id);
                                
                            }

                    }
                 
                }  
                
                if($res>0){

                  redirect('pages');
                 }
                else 
                echo 'no new pages';
            }
        }
    }





}
?>