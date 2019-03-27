<?php
require_once FCPATH . '/vendor/autoload.php'; 
class TestTimeZone extends CI_Controller {
   
    public function __construct()
    {
            parent::__construct();
            
            $this->load->helper('url_helper');
             $this->load->model('FB_model');
    }


private function send_message(){
    // Olivia Hobbit
    // 541140996398061
    // EAAHKRllr1hkBAGxw7dFZCvTXzeYpkDud1p0wHWw4XqjOerSMijmu7DpTjkpqdhhwgrbImVRR2XEcR3bZAbq4ds67uRG9reffFXLEK8muEEbVK1RBDHFfnpRBHhu7Tj2DPnVW3nQDToTT0zXJR238fqqUo5PKwXzHjlz0hVN3fW35XKWQgCrBlInJDFgScZD
  
  
    // Olivia  Star
    // 777736072599375
    // EAAHKRllr1hkBAKv5vJmFrR3K0QI8UHFxGVv1RDmQ8oAsV79Pme2zeG8RfHXoEMAoBQ7uO5otjLwacE0h1N6iCUyHQSNGtyEOfEYphjlg6hlm1tWhkF7bs5VgWfVxaxysFivPk5KorkB0BmRKYmIlOl8uaZB6wwB80HQhtmr3I9DReGGAcQysrC4XdOZCsZD
  

    // Olivia Young
    // 971438483243979
    // EAAHKRllr1hkBAB8ZAWcPLN44Y2kmfHlAZClOWSHraaVekTRluCI4XB8pPCwkRoy61EDX6vKI7FZCZC8ksSiWD6MZCPrcTwa60awpMZAJI8RyF5nnTK9PcdrA00eY86p8ZCHOSV4MeDuV4Qwe6T8JqIZAi1rZC7WyyetTfZBecOMlFe2lqjjO3YQzbZAZABSB4DIOFnoZD



    // 2259650144248017
    // EAAHKRllr1hkBALdGYnkR9Tfmwlntc2qDwhsZCXR8jvOVK5pKJg9THX9phAZBZBObAi0VhcA0xLptFG5seE8iaUNFK4ktVmjzeyuYpu5O1LoTOKZBZCeNmRzB5JYqZCgwkf9uyp85YEOPxZAVGxg0MZAPsxrZARtypiDyZCQLKq3jZCpIkGENzZCR7sEFoZAeSVIlZCo4wZD
    // Olivia's Community


    $fbPageId = '541140996398061';
    $fbPageAT= 'EAAHKRllr1hkBAGxw7dFZCvTXzeYpkDud1p0wHWw4XqjOerSMijmu7DpTjkpqdhhwgrbImVRR2XEcR3bZAbq4ds67uRG9reffFXLEK8muEEbVK1RBDHFfnpRBHhu7Tj2DPnVW3nQDToTT0zXJR238fqqUo5PKwXzHjlz0hVN3fW35XKWQgCrBlInJDFgScZD'; 
    $page_timezone = 'Europe/London'; 
    $input_post_message= '';
     

      //$this->db->select('App_time_zone'); 
     // $query = $this->db->get('global_parameters');
     // $app_TZ = $query->result_array()[0]['App_time_zone'];



    //   if($is_scheduled == 1){
    //       $timezone = $page_timezone;
    //       if($timezone == null || $timezone == ''){
    //           $timezone = $app_TZ;
    //       }
    //       if($scheduledSame == 1){
    //           $timezone = $app_TZ;
    //       }

     $schedule_date =  new DateTime($post_data[0]["scheduledTime"]);
     $schedule_date->setTimezone(new DateTimeZone($timezone));
     $schedule_dt = strtotime( $schedule_date->format('Y-m-d H:i:s')/*$post_data[0]["scheduledTime"]*/);
    //   }else{
    //      $schedule_dt=null;
    //   }
    
    
    
    $res =  array(
            'error' => false,
            'message' => '',
            'f_post_id' => ''
        );
    try {
         



                $posting_array=array( 
                        'message' => $input_post_message,
                        'scheduled_publish_time'  => $schedule_dt, 
                        'published' => 'false'
                );
            
            
        $response = $fb->post('/' . $fbPageId . '/feed',$posting_array/*array ( 'message' => $input_post_message,)*/, $fbPageAT);
        $res['message'] = "Your post has been sent to facebook.";
        $graphNode = $response->getGraphNode();
        $fb_post_id = $graphNode['id'];
        $res['f_post_id'] = $fb_post_id;
       
         
   
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        $res['error'] = true;
        $res['message'] = $e->getMessage();
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
            $res['error'] = true;
            $res['message'] = $e->getMessage();
    }
    
    return $res;
    }
 
 
       
} 