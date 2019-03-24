<?php
class Cron_stats72 extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            
            $this->load->helper('url_helper');
            $this->load->model('FB_model');
            $app_id = '503878473471513';
            $app_secret = '28cbbb9f440b1b016e9ce54376ada17e';
            $default_graph_version = 'v3.2';
    }

    public function start(){
        //kreiramo novi cron job
        $cron_job_error = "_ ";
        $cron_job_status = 1; // sve je ok, za gresku je 2
        //$this->db->query("call NewCroneJob(@cr_job_id);");
        //$cron_job_owner = $this->db->query("SELECT @cr_job_id;")->row('@cr_job_id');
        //cron job je kreiran
        //pripremljeni su job_thread-ovi i njima je owner_job upravo obvaj novokreirani cron_job
        
        // uzimamo ih iz db
        $data = $this->db->query("SELECT PS.id, PS.fbPostId, P.fbPageAT
                FROM  posts_pages  PS 
                JOIN  pages P ON PS.pageId = P.id 
                WHERE  PS.fbPostId is not null and PS.postingStatus='3' 
                ORDER BY PS.id DESC");  
        $data = $data->result_array();

        //for every posting on FB
        foreach($data as $fb_posting){

            $post_id = $fb_posting['fbPostId'];
            $page_at = $fb_posting['fbPageAT'];
           // echo '<br>$post_id: ' . $post_id;
           // echo '<br>$page_at: ' . $page_at;

            
            //chesk if there exists tabel segment T0-72 for fbPostID in table statistics72h
            $this->db->select('stats_id');
            $this->db->where('fbPostId=', $post_id);
            $query=$this->db->get('statistics72h');
            $fbpost_stats_exists=$query->num_rows();

            if($fbpost_stats_exists==0) {
                //insert positions t0-t72 for updating fbpost statistics
                for($i=0;$i<=72;$i++){

                    $this->db->set('stats_id', $i);
                    $this->db->set('fbPostId', $post_id);
                    $this->db->set('stats_dt', date("Y-m-d H:i:s"));
                    $this->db->set('reactions', 0);
                    $this->db->set('comments', 0);
                    $this->db->set('shares', 0);                
                    $this->db->insert('statistics72h');
                }
            }

            //get statistics for fbpostid

            if (!isset($_SESSION)) { session_start();}  

            require_once FCPATH . '/vendor/autoload.php'; // change path as needed  

            $fb = new \Facebook\Facebook([
            'app_id' => $app_id,
            'app_secret' => $app_secret,
            'default_graph_version' => $default_graph_version
            ]);

             //post likes
            /*try {
                // Returns a `Facebook\FacebookResponse` object
                $response = $fb->get(
                '/' . $post_id . '/likes?limit=0&summary=true',  
                $page_at
                
                );
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
               // exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                //exit;
            }
        
            $graphEdge = $response->getGraphEdge();
            $num_of_post_likes = $graphEdge->getTotalCount();
            //echo '<br>$num_of_post_likes: ' . $num_of_post_likes;
            */
            
            //post shares
            $num_of_post_shares = 0; 
            try {
                // Returns a `Facebook\FacebookResponse` object
                $response = $fb->get(
                '/' . $post_id . '?fields=shares',  
                $page_at                
                );
                $graphNode = $response->getGraphNode(); 
                if ($graphNode->getField('shares') != null)  {
                    if($graphNode->getField('shares')->getField('count') != null)
                      {
                        $num_of_post_shares =  $graphNode->getField('shares')->getField('count');
                          //$num_of_post_shares = $graphNode["shares"]["count"];
                      }
                      else{
                        $num_of_post_shares = 0;
                      } 
                }
                else {
                    $num_of_post_shares = 0;
                }
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                //echo 'Graph returned an error: ' . $e->getMessage();
                $num_of_post_shares = -111; 
                //exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
               //echo 'Facebook SDK returned an error: ' . $e->getMessage();
               $num_of_post_shares = -333;  //for problems

                //exit;
            }

            
                
            
            //  echo '<br>$num_of_post_shares: ' . $num_of_post_shares;

            //post comments
            try {
                // Returns a `Facebook\FacebookResponse` object
                $response = $fb->get(
                    '/' . $post_id . '/comments?limit=0&summary=true',  
                $page_at     
                
                );
                $graphEdge = $response->getGraphEdge();
                $num_of_post_comments= $graphEdge->getTotalCount();
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
               // echo 'Graph returned an error: ' . $e->getMessage();
                //exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
               // echo 'Facebook SDK returned an error: ' . $e->getMessage();
                //exit;
            }
           
           // echo '<br>$num_of_post_comments: ' . $num_of_post_comments;

       

            //post reactions
            try {
                // Returns a `Facebook\FacebookResponse` object
                $response = $fb->get(
                    '/' . $post_id . '/reactions?limit=0&summary=true',  
                    $page_at       
                );
                $graphEdge = $response->getGraphEdge();
                $num_of_post_reactions=$graphEdge->getTotalCount();
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
               // echo 'Graph returned an error: ' . $e->getMessage();
                //exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                //echo 'Facebook SDK returned an error: ' . $e->getMessage();
                //exit;
            }
            // $graphEdge = $response->getGraphEdge();
            // $num_of_post_reactions=$graphEdge->getTotalCount();

            // echo '<br>$num_of_post_reactions: ' . $num_of_post_reactions;
        

            //update statistics72h table

            //shift stats values form previous jobs
            //stats_id {0, 1, ... 72} => {1, 2, ... 73}
            /*$this->db->set('stats_id', 'stats_id+1');
            $this->db->where('fbPostId=', $post_id);
            $this->db->update('statistics72h'); // gives UPDATE `statistics72h` SET `stats_id` = 'stats_id+1' WHERE `fbPostId` = $post_id
            */
            $this->db->query("UPDATE  statistics72h 
                SET stats_id=stats_id+1 
                WHERE  fbPostId = '" . $post_id . "'");
              
             
            //set stats values for curren job gathered statistics
            $this->db->where('fbPostId=', $post_id);  
            $this->db->where('stats_id=', 73);        
            $this->db->set('stats_id', 0);
            $this->db->set('stats_dt', date("Y-m-d H:i:s"));
            $this->db->set('reactions', $num_of_post_reactions);
            $this->db->set('comments', $num_of_post_comments);
            $this->db->set('shares', $num_of_post_shares);                
            $this->db->update('statistics72h');

        }

        // call sp
        $this->db->query("call GenerateGlobalStatistics();"); 
    }

    private function all_pages_likes_stats(){

        // uzimamo ih iz db
        $data = $this->db->query("SELECT id, fbPageId, fbPageAT
                FROM  pages  
                WHERE  isActive is not null");  
        $data = $data->result_array();

        //for every page
        foreach($data as $pages){

            $page_id = $pages['id'];
            $fb_page_id = $pages['fbPageId'];
            $fb_page_at = $pages['fbPageAT'];
           
            
            //chesk if there exists row in table page_statistics for tihs page
            $this->db->select('pageLikes', 'lastUpdateLikes');
            $this->db->where('page_id=', $page_id);
            $query=$this->db->get('page_statistic');
            $fbpage_stats_exists=$query->num_rows();

            if($fbpage_stats_exists==0) {
                //insert row for updating fbpage statistics
                    $this->db->set('page_id', $page_id);
                    $this->db->set('pageLikes', 0);
                   // $this->db->set('pageLikes24', 0);
                   // $this->db->set('pageLikes48', 0);
                   // $this->db->set('pageLikes72', 0);
                    $this->db->set('lastUpdateLikes', date("Y-m-d H:i:s"));
                    $this->db->insert('page_statistic');
                
            }
            else {

                //update page likes statistics daily
                if(true) //difftiem(lastUpdateLikes) >= 24h)
                {
                        //PAGE LIKES

                        //page likes
                        //pageid, pageAT        
                        //olivia young
                        //$page_id='2259650144248017';
                        //$page_at='EAAHKRllr1hkBABPQmA6jKglQpuLGnWpa40IjeLaC4n2YQx6LsEeFmCcH0VzpzM9FLR76GHMV6DZAKh4jYeLQFexFHMBJjUAlzGTRvMlKZAn19WY6n91HbA8lvaaBvE4WjRZAGkRvyHKZCfBfuo0JLmFGg5ZBCs162cZB7oK7ZCaXx4AVYAN1pvecOZAf1mTPMxIZD';
                        //olivia star
                        // $fb_page_id='777736072599375';
                        //$fb_page_at='EAAHKRllr1hkBACvZB1qIiUqBm6bpPIBSmeQpWfhQR0UoDoIugE5b3OPOIVZB3CBSA9e6FdIb7JkXJKXkyMmwzWEnmtPZAFhQ36RM5clgZBtTtIZBLvBVfxnvPNV3nfzqbkTiYL5IPtEtFE5Sa9c9lED5f5HXciBZCcWUiaIDrZBAHiJLaEdAZCfWkAGidZBnpDH4ZD';
                        $page_likes_count=0;
                        try {
                            // Returns a `Facebook\FacebookResponse` object
                            $response = $fb->get(
                            '/' . $fb_page_id . '?fields=fan_count,general_info,category,engagement,can_post',//pageid
                            $fb_page_at
                        
                            );

                            $graphNode = $response->getGraphNode();
                            $page_likes_count = $graphNode;
                        } catch(Facebook\Exceptions\FacebookResponseException $e) {
                            //echo 'Graph returned an error: ' . $e->getMessage();
                            //exit;
                            $page_likes_count = -1;
                        } catch(Facebook\Exceptions\FacebookSDKException $e) {
                            //echo 'Facebook SDK returned an error: ' . $e->getMessage();
                            //exit;
                            $page_likes_count = -2;
                        }

                        //  if($page_likes_count==0){
                        //     $graphNode = $response->getGraphNode();
                        //     //echo '<br>Page likes count: ' . $graphNode;
                        //     $page_likes_count = $graphNode;
                        //  }
                         
                         //update stats
                         //if there was an error - page_likes_count<0
                         //just don't do anything, display last valid stats
                         //leave the time update as it is
                         $this->db->set('page_id', $page_id);
                         $this->db->set('pageLikes', $page_likes_count);
                        // $this->db->set('pageLikes24', 0);
                        // $this->db->set('pageLikes48', 0);
                        // $this->db->set('pageLikes72', 0);
                         $this->db->set('lastUpdateLikes', date("Y-m-d H:i:s"));
                         $this->db->insert('page_statistic');
                    }

                    else {

                        //skip the ste , less han 24h from last update
                    }






            }
    }

    //call  sp

    $this->db->query("call GeneratePageDashboardStatistic();"); 
}


}
