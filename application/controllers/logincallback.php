<?php
 require_once FCPATH . '/vendor/autoload.php'; // change path as needed      
class LoginCallback extends CI_Controller {

       public function __construct()
    {
            parent::__construct();
            $this->load->helper('url_helper');
            $this->load->library('FacebookPersistentDataInterface');
            $this->load->model('Pages_model');
    }

    public function index(){
        
      if (!isset($_SESSION)) { session_start(); }   
        require_once FCPATH . '/vendor/autoload.php'; // change path as needed        
       
      $fb = new \Facebook\Facebook([
        'app_id' => FB_APP_ID,
        'app_secret' => FB_APP_SECRET,
        'default_graph_version' => FB_API_VERSION,
          'persistent_data_handler' => new FacebookPersistentDataInterface(),
      ]);

    $helper = $fb->getRedirectLoginHelper();
    
    try {
      $accessToken = $helper->getAccessToken();
     // echo $accessToken;
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      // When Graph returns an error
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      // When validation fails or other local issues
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }
    
    if (isset($accessToken)) {
      // Logged in!
     
      $_SESSION['facebook_access_token'] = (string) $accessToken;

      $expdate=$accessToken->getExpiresAt();
      $_SESSION['expdate_access_token'] = (string) $expdate;
      
      // Now you can redirect to another page and use the
      // access token from $_SESSION['facebook_access_token']

      //echo 'EXPDATE: ' . $_SESSION['expdate_access_token'];
      //echo 'AT :' . $_SESSION['facebook_access_token'];
      redirect('add_pages');
    }
     
    /*  $fb = new \Facebook\Facebook([
        'app_id' => '503878473471513',
        'app_secret' => '28cbbb9f440b1b016e9ce54376ada17e',
        'default_graph_version' => 'v3.2',
        'persistent_data_handler' => new FacebookPersistentDataInterface(),
    ]);

   /* try {
        // Get the \Facebook\GraphNodes\GraphUser object for the current user.
        // If you provided a 'default_access_token', the '{access-token}' is optional.
        $response = $fb->get('/me?fields=id,email,name', $accessToken);
    } catch(\Facebook\Exceptions\FacebookResponseException $e) {
        // When Graph returns an error
   //     echo 'Graph returned an error: ' . $e->getMessage();
        exit;
     } catch(\Facebook\Exceptions\FacebookSDKException $e) {
        // When validation fails or other local issues
  //      echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }

    $user = $response->getGraphUser();
   echo '<br>Logged in as: ' . $user->getName();
    echo '<br> Email is: ' . $user->getEmail();

    $userObject = $response->getGraphObject();
    echo $userObject;
     */
 
 
 /*    try {
      // Get the pages
      // If you provided a 'default_access_token', the '{access-token}' is optional.
      $params = array(
          'fields'=> 'id,name,likes,access_token',
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

  /*
  echo '<br><br>' . $response->getBody() . '<br><br>';
  $objtest= json_decode($response->getBody());
  $last = count($objtest->data) - 1;
  echo $last;

  for ($i = 0; $i <= $last; $i++) {
      $page_i=$objtest->data[$i];
      echo $i . ': ' . $page_i->id . ' pageAccessToken:<br>'. $page_i->access_token;
  }
  */

 // $pages = $response->getDecodedBody();
/*  $last = count( $pages['data'])-1;
 
  for ($i = 0; $i <= $last; $i++) {
      echo '<br><br>' . count( $pages['data']) . '<br><br>';
      echo '<br><br>' . $pages['data'][$i]['id']. '<br><br>';
       echo '<br><br>' . $pages['data'][$i]['name']. '<br><br>';
      echo '<br><br>' . $pages['data'][$i]['access_token']. '<br><br>';
   }
 */  
 /* $i=0;
  $fbpage_id=$pages['data'][$i]['id'];
  $fbPage_name=$pages['data'][$i]['name'];*/
 // $user_id=1;

 // $res=$this->Pages_model->add_pages($pages, $user_id);

 //   echo 'rezultat inserta: ' . $res;

 
 //  $data = array('fbpages' => $pages); prenosila  cijeli $response->getDecodedBody();
 //$this->load->view('users/fbpages', $data);
 /*
    $data = array('user_id' => $user_id);
    $this->load->view('users/fbpages', $data);

      
    } elseif ($helper->getError()) {
      // The user denied the request
      echo 'no way hose';
      exit;
    }*/
  }
}


?>