<?php

class FBCheck extends CI_Controller {


    public function __construct()
    {
            parent::__construct();
            $this->load->helper('url_helper');
            $this->load->library('FacebookPersistentDataInterface');
            $this->load->model('Users_model');
    }

    public function index(){
        
        if (!isset($_SESSION))
        {
            session_start();
        }   
        require_once FCPATH . '/vendor/autoload.php'; // change path as needed  
        
        if($this->Users_model->isLoggedIn()){

            $user_id = $this->session->userdata('user')['user_id'];

           
        
            $fb = new \Facebook\Facebook([
            'app_id' => '503878473471513',
                        
            'app_secret' => '28cbbb9f440b1b016e9ce54376ada17e',
                            
            'default_graph_version' => 'v3.2',
            'persistent_data_handler' => new FacebookPersistentDataInterface(),
            
            ]);

         // Use one of the helper classes to get a Facebook\Authentication\AccessToken entity.
            $helper = $fb->getRedirectLoginHelper();
            //   $helper = $fb->getJavaScriptHelper();
            //   $helper = $fb->getCanvasHelper();
            //   $helper = $fb->getPageTabHelper();
            //pages_messaging, pages_messaging_subscriptions
            $permissions = ['email', 'user_likes', 'manage_pages', 'publish_pages' , 'read_insights', 'read_page_mailboxes', 'user_posts']; // optional
            $loginUrl = $helper->getLoginUrl(base_url() . 'LoginCallback', $permissions);

            $data = array('loginUrl' => $loginUrl);
            $data['title'] = 'FB chack page';    
            $this->load->view('users/fbcheck', $data);
            
            //   TO REVOKE  PERMISSIONS, with user AT
                            /* PHP SDK v5.0.0 */
                    /* make the API call */
                    /*try {
                        // Returns a `Facebook\FacebookResponse` object
                        $response = $fb->delete(
                        '/104189817385560/permissions',['instagram_basic','email', 'user_likes', 'manage_pages', 'publish_pages' , 'read_insights', 'read_page_mailboxes', 'user_posts'],
                        'EAAHKRllr1hkBAK9CRL4G3pzu1uHL1tyKkZAXhzenUKwQSCEdHwcoQcB3xxleH4ZB3DhX5tQDHZCQc7c06g477o3uZA7ZBED9t3JCrE3TINebalxO1eOKL3ZBjmsBZBjddZAVVK5pImyhs18CkFMxXZAiDLjt99819aXeg3pKwpKsd1g3asp6XMyDP'
                        );
                    } catch(Facebook\Exceptions\FacebookResponseException $e) {
                        echo 'Graph returned an error: ' . $e->getMessage();
                        exit;
                    } catch(Facebook\Exceptions\FacebookSDKException $e) {
                        echo 'Facebook SDK returned an error: ' . $e->getMessage();
                        exit;
                    }
                    $graphNode = $response->getGraphNode();
                    /* handle the result */

                    //echo $graphNode;
                    //}
        } else {
            (redirect('/login'));
        }         
    }
}