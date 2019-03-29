<?php
require_once FCPATH . '/vendor/autoload.php'; 
class TestTimeZone extends CI_Controller {
   
    public function __construct()
    {
            parent::__construct();
            
            $this->load->helper('url_helper');
             $this->load->model('FB_model');
    }


public function send_message(){
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
    $timezone = 'Europe/London'; 
    
     

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

   // $schedule_date =  date("Y-m-d H:i:s");//new DateTime($post_data[0]["scheduledTime"]);
     //$schedule_date = time();
    // $schedule_date = new DateTime(null, new DateTimeZone('America/New_York'));
    // $schedule_date->setTimezone(new DateTimeZone($timezone));
    // $schedule_dt = strtotime( $schedule_date->format('Y-m-d H:i:s')/*$post_data[0]["scheduledTime"]*/);
    //   }else{
    //      $schedule_dt=null;
    //   }
    
    
    
    $res =  array(
            'error' => false,
            'message' => '',
            'f_post_id' => ''
        );
    try {
       
        $fb = new \Facebook\Facebook([  'app_id' => FB_APP_ID,  'app_secret' => FB_APP_SECRET,  'default_graph_version' => FB_API_VERSION ]);


        //date_default_timezone_set('Europe/London');

        $test_date_string = '2019-03-29 09:42:34';



        $NYtime= new DateTime($test_date_string, new DateTimeZone('Africa/Addis_Ababa')); 
        echo $test_date_string . ' strtime : ' . strtotime($NYtime->format("Y-m-d H:i:s")) . ' Addis_Ababa  | ' . $NYtime->getTimestamp() ;
        $posting_arrayNY=array( 'message' => 'Addis_Ababa 2019-03-29 06:42:34', 'scheduled_publish_time'  => $NYtime->getTimestamp(),  'published' => 'false' );
        $response = $fb->post('/' . $fbPageId . '/feed',$posting_arrayNY, $fbPageAT);
        echo '</br>';
        echo '</br>';
        echo '</br>';

        
        $PGdt =  new DateTime($test_date_string, new DateTimeZone('Europe/Podgorica')); 

       echo '</br>';
       echo '</br>';
       echo '</br>';
        // echo $PGdt->format("Y-m-d H:i:s") . ' strtime : ' . strtotime( $PGdt->format("Y-m-d H:i:s")) . ' Podgorica ' .  $PGdt->getTimestamp() ;
        // $posting_arrayPG=array( 'message' => 'PG u 21 po PG vremenu', 'scheduled_publish_time'  => $PGdt->getTimestamp(),  'published' => 'false' );
        // $response = $fb->post('/' . $fbPageId . '/feed',$posting_arrayPG, $fbPageAT);
        echo '</br>';
        echo '</br>';
        echo '</br>';
        echo '</br>'; 
         
   
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        $res['error'] = true;
        $res['message'] = $e->getMessage();
        echo $e->getMessage();
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
            $res['error'] = true;
            $res['message'] = $e->getMessage();
            echo $e->getMessage();
    }
    
    return $res;
    }
 
 
       
} 