<?php
class Send_post extends CI_Controller {

    public function __construct(){
        
                parent::__construct();
                $this->load->helper('url_helper');
                $this->load->model('FB_model');
                //$this->load->model('Users_model');
}

public function index($post_id){ 
            
        //if($this->users_model->isLoggedIn()){
        //$user_id = $this->session->userdata('user')['user_id'];

    $res =  array(
        'error' => false,
        'message' => ''
    );
     if (!isset($_SESSION))
        {
            session_start();
        }  

        require_once FCPATH . '/vendor/autoload.php'; // change path as needed  

        $fb = new \Facebook\Facebook([
        'app_id' => '503878473471513',
        'app_secret' => '28cbbb9f440b1b016e9ce54376ada17e',
        'default_graph_version' => 'v3.2'
        ]);
      
        if($post_id>0) {
                //post to page, hardcoded page_id
            
                $post_data =  $this->FB_model->get_post_data($post_id);

                if(count( $post_data)==1) {
                    $input_post_type = $post_data[0]["post_type"];
                    $input_post_title=$post_data[0]["title"];

                // echo '$input_post_title ' . $input_post_title;
                    $input_post_message=$post_data[0]["content"];
                    
                //to do - ubaciti u bazu novu kolonu ???
                    $input_post_fb_preset_id=0;//iz baze kad se doda
            
                                    
                    if ($input_post_type=='video') {
                        $post_attachment_data = $this->FB_model->get_post_attachments($post_id,'video');
                        $input_post_video = $post_attachment_data[0]["attach_location"];

                    }
                    if ($input_post_type=='image') { 

                        $post_attachment_data = $this->FB_model->get_post_attachments($post_id,'image');

                        $num_of_images = count($post_attachment_data); 
                        $image_list=$post_attachment_data[0]["attach_location"];
                        if($num_of_images>0){
                            for ($i = 1; $i <= $num_of_images-1; $i++) {
                                $image_list = $image_list . ','  . $post_attachment_data[$i]["attach_location"];
                            }
                        }
                    
                    }      
                //to do: get pages and groups set for post; compare user_id in session and in table
                //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

                //$res = $this->fb_model->get_groups_for_user($user_id);
                //$user_groups = (is_array($res)) ? array_values($res) : null;

                $ress = $this->FB_model->get_pages_for_post_with_fbid_and_fbAT($post_id);
                $pages_for_post = (is_array($ress) && count($ress) > 0) ? array_values($ress) : null;
                
            
                //if(count($pages_for_post)>0)
               // var_dump($pages_for_post);

                //post_pages.pageId
                if($pages_for_post === null){
                    $res['error'] = true;
                    $res['message'] = "There are no pages to be published to!";
                    echo json_encode($res);
                    exit;

                }
                $fbPageId= $pages_for_post[0]['fbPageId'];
                $fbPageAT= $pages_for_post[0]['fbPageAT'];

                //send post type message
                if($input_post_type=='message'){
                
                    try {
                    
                    $response = $fb->post('/' . $fbPageId . '/feed',
                        array (
                            'message' => $input_post_message,
                    ),
                     $fbPageAT                    
                    );
                    } catch(Facebook\Exceptions\FacebookResponseException $e) {
                        $res['error'] = true;
                        $res['message'] = $e->getMessage();
                    //echo 'Graph returned an error: ' . $e->getMessage();
                    //exit;
                    } catch(Facebook\Exceptions\FacebookSDKException $e) {
                        $res['error'] = true;
                        $res['message'] = $e->getMessage();
                    //echo 'Facebook SDK returned an error: ' . $e->getMessage();
                    //exit;
                    }
                    
                    $graphNode = $response->getGraphNode();
                
                    //poruka
                    //echo '<br><br><br>Tets post object:' . $graphNode;
                    // echo '<br>Video id: ' . $graphNode['id'];
                    $res['message'] = "Your post has been sent to facebook.";

                }
                //send post type link
                if($input_post_type=='link') {
                    $post_attachment_data = $this->FB_model->get_post_attachments($post_id,'link');
                    $input_post_link=$post_attachment_data[0]["attach_location"];

                    try {
                    
                        $response = $fb->post('/' . $fbPageId . '/feed',
                            array (
                                 'message' => $input_post_message,
                                 'link' => $input_post_link,

                        ),
                         $fbPageAT                    
                        );
                        } catch(Facebook\Exceptions\FacebookResponseException $e) {
                       // echo 'Graph returned an error: ' . $e->getMessage();
                            $res['error'] = true;
                            $res['message'] = $e->getMessage();
                        //exit;
                        } catch(Facebook\Exceptions\FacebookSDKException $e) {
                        //echo 'Facebook SDK returned an error: ' . $e->getMessage();
                                $res['error'] = true;
                                $res['message'] = $e->getMessage();
                        //exit;
                        }
                        
                        $graphNode = $response->getGraphNode();
                    
                         //poruka
                        //echo '<br><br><br>Tets post object:' . $graphNode;
                        $res['message'] = "Your post has been sent to facebook.";
                
                }    

                //send post type image
                if ($input_post_type=='image') { 

                    $post_attachment_data = $this->FB_model->get_post_attachments($post_id,'image');

                    $num_of_images = count($post_attachment_data); 
                    

                    if($num_of_images>0){

                       // $attached_media=array(); 
                        $array_for_send= array('message' => $input_post_message);
                        for ($i = 0; $i < $num_of_images; $i++) {
                            
                        try {
                    
                            $response = $fb->post('/' . $fbPageId . '/photos',
                                array (
                                    //'title'  => 'Image test545646',
                                    'message' => $input_post_message,
                                    'published' => 'false',
                                    'source'  => $fb->fileToUpload('./uploads/' . $post_attachment_data[$i]["attach_location"]),
                            ),
                            $fbPageAT                    
                            );
                            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                                $res['error'] = true;
                                $res['message'] = $e->getMessage();
                           // echo 'Graph returned an error: ' . $e->getMessage();
                           // exit;
                            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                                $res['error'] = true;
                                $res['message'] = $e->getMessage();
                           // echo 'Facebook SDK returned an error: ' . $e->getMessage();
                           // exit;
                            }
                            
                            
                            $graphNode = $response->getGraphNode();
                        
                           //  echo '<br><br><br>Tets post image object:' . $graphNode;
                            //echo '<br><br><br>Tets post image object:' . $graphNode['id'];

                           // $attached_media[$i] =$graphNode['id'];
                            $array_for_send[ 'attached_media[' . $i  .']'] =  '{"media_fbid":"' . $graphNode['id'] . '"}';
                           
                        }
                       // var_dump($array_for_send);
                        
                        try {
                    
                            $response = $fb->post('/' . $fbPageId . '/feed',$array_for_send, $fbPageAT);
                            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                            echo 'Graph returned an error: ' . $e->getMessage();
                            exit;
                            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                            echo 'Facebook SDK returned an error: ' . $e->getMessage();
                            exit;
                            }
                            
                            $graphNode = $response->getGraphNode();
                        
                           //poruka
                           //  echo '<br><br><br>Tets post image object:' . $graphNode;
                           $res['message'] = "Your post has been sent to facebook.";
                            
                    }        
                
                }     


             //send post type video
             if ($input_post_type=='video') { 

                $post_attachment_data = $this->FB_model->get_post_attachments($post_id,'video');

                $num_of_images = count($post_attachment_data); 
                

                if($num_of_images>0){

                   // $attached_media=array(); 
                    $array_for_send= array('message' => $input_post_message);
                    for ($i = 0; $i < $num_of_images; $i++) {
                        
                    try {
                
                        $response = $fb->post('/' . $fbPageId . '/videos',
                            array (
                                'title'  => $input_post_title,
                                //'message' => $input_post_message,
                                'description' => $input_post_message,
                                //'published' => 'false',
                                'source'  => $fb->videoToUpload('./uploads/' . $post_attachment_data[$i]["attach_location"]),
                        ),
                        $fbPageAT                    
                        );
                        } catch(Facebook\Exceptions\FacebookResponseException $e) {
                            $res['error'] = true;
                            $res['message'] = $e->getMessage();
                       // echo 'Graph returned an error: ' . $e->getMessage();
                        //exit;
                        } catch(Facebook\Exceptions\FacebookSDKException $e) {
                            $res['error'] = true;
                            $res['message'] = $e->getMessage();
                       // echo 'Facebook SDK returned an error: ' . $e->getMessage();
                       // exit;
                        }
                        
                        $graphNode = $response->getGraphNode();
                    
                       //  echo '<br><br><br>Tets post image object:' . $graphNode;
                      // echo '<br><br><br>Tets post video object:' . $graphNode['id'];

                       // $attached_media[$i] =$graphNode['id'];
                        $array_for_send[ 'attached_media[' . $i  .']'] =  '{"media_fbid":"' . $graphNode['id'] . '"}';
                                              
                       //poruka
                       $res['message'] = "Your post has been sent to facebook.";
                    }
                    //var_dump($array_for_send);
                    /* try {
                
                        $response = $fb->post('/' . $fbPageId . '/videos', $array_for_send, $fbPageAT);
                        } catch(Facebook\Exceptions\FacebookServerException $e) {
                        echo 'Graph returned an server  error: ' . $e->getMessage();
                        exit;
                        } 
                        catch(Facebook\Exceptions\FacebookAuthenticationException $e) {
                            echo 'Graph returned an auth error: ' . $e->getMessage();
                            exit;
                            } 
                            catch(Facebook\Exceptions\FacebookAuthorizationException $e) {
                                echo 'Graph returned an autor error: ' . $e->getMessage();
                                exit;
                                } 
                                catch(Facebook\Exceptions\FacebookResponseException $e) {
                                    $previousException = $e->getPrevious();
                                    echo 'Graph returned an response error: ' . $e->getMessage() . "previus" .  $previousException;
                                    exit;
                                    } 
                        catch(Facebook\Exceptions\FacebookSDKException $e) {
                        echo 'Facebook SDK returned an error: ' . $e->getMessage();
                        exit;
                        }
                        
                        $graphNode = $response->getGraphNode();
                        echo '<br><br><br>Test post video object:' . $graphNode;
                    
                       */
                }        
            
            }     
               
        
        }
        else {
                    ////poruka
                    //echo 'error count nije 1';
                    $res['error'] = true;
                    $res['message'] = "There is no post in DB!";
        }
    } 
     else { 
                ////poruka
               // echo 'postid nema podatke';
               $res['error'] = true;
               $res['message'] = "Nothing has been sent, beacuse post parametar is not valid.";
    }

            echo json_encode($res);
}

            /*      try {
                    
                    $response = $fb->post('/777736072599375/feed',
                        array (
                        //  'title'  => 'Video test with published false',
                        'message' => 'Test 703',
                        //'scheduled_publish_time'  => 'Tomorrow', 
                        //'link' => 'https://www.youtube.com/watch?v=YUPA0C60YDE',
                        //'source'  => 'https://www.vijesti.me/media/20190209180224_b05bd466-0421-4ccf-9c57-e6e9b7028a5c.jpeg',
                        //'caption'= 'test photo upload', 
                        //'published' => 'false',
                        //'source'  => $fb->fileToUpload('./images/others_03.jpg'),
                        // 'source'  => $fb->videoToUpload('roblox.wmv'),
                        //'message' => 'Testing multi-photo and video post!',
                        //'attached_media[0]' => '{"media_fbid":"778389232534059"}',
                        // 'attached_media[1]' => '{"media_fbid":"778389372534045"}',
                        //'attached_media[2]' => '{"media_fbid":"778388522534130"}',
                        //  'attached_media[3]' => '{"media_fbid":"382050779301320"}',
                
                    ),
                    'EAAHKRllr1hkBAPr2ZCC5VEjmYkw3DLNLfPi2MZBcKIc3cpVxlzLUbAyRSEst3lod4ZBTNdbzYuaKrPkx3Cy6XLcL3jM4e6N3EvUIhTFV5369ogKdDLX8JMSYdVE1DhmJooLjpRT69LTzXnHpiBHXJWZAZCKhLbjFElCKX2pZBPyuVZCnnGuCSx2zRo2oHt6aHgZD'
                    );
                    } catch(Facebook\Exceptions\FacebookResponseException $e) {
                    echo 'Graph returned an error: ' . $e->getMessage();
                    exit;
                    } catch(Facebook\Exceptions\FacebookSDKException $e) {
                    echo 'Facebook SDK returned an error: ' . $e->getMessage();
                    exit;
                    }
                    
                    $graphNode = $response->getGraphNode();
                
                    echo '<br><br><br>Tets post object:' . $graphNode;
                    // echo '<br>Video id: ' . $graphNode['id'];



                }

            */
           

}
?>