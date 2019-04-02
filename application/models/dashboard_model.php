<?php

class Dashboard_model extends CI_Model{
    
    // public function __construct()
    // {
    //         // $this->load->database();
    // }
    
    function getRows($params = array()){
        $this->db->select('page_dashboard_statistic.pageLikes, (page_dashboard_statistic.pageLikes - page_dashboard_statistic.pageLikes72) as diffLikes, page_dashboard_statistic.current_posts24, page_dashboard_statistic.current_posts72, pages.fbPageName as pname, users.username as addedby, GroupsForPages(pages.id) AS groups');
        $this->db->from('page_dashboard_statistic');
        $this->db->join('pages', 'pages.id = page_dashboard_statistic.page_id');
        $this->db->join('users', 'users.id = pages.userId');        
        $this->db->join('pages_groups', 'pages_groups.pageId = pages.id', 'left outer');    
        $this->db->where('pages.isActive = 1');
        //filter data by user
        if(!empty($params['search']['group'])){
            $this->db->where('pages_groups.groupId = ',$params['search']['group']);
        }
        if($this->session->userdata('user')['role'] == 2){
            $this->db->where('pages.userId = ',$this->session->userdata('user')['user_id']);
        }
        //filter data by user
        if(!empty($params['search']['pwithoutPL24'])){
            $this->db->where('page_dashboard_statistic.current_posts24',0);
        }
        // //filter data by user
        if(!empty($params['search']['pwithoutPL72'])){
            $this->db->where('page_dashboard_statistic.current_posts72',0);
        }
        //filter data by searched keywords
        if(!empty($params['search']['pagename'])){
            $this->db->like('pages.fbPageName',$params['search']['pagename']);
        }

        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        //get records
        $this->db->group_by('pages.id');
        $this->db->order_by('pages.fbPageName asc');
        $query = $this->db->get();
        //return fetched data
        return ($query->num_rows() > 0)?$query->result_array():array();
    }
    
    /**
     * @usage
     * Single: page statistic
     * All: page statistic
     * Custom: page statistic
     */
    public function get($id = null){
        if($id === null){
            $query = $this->db->get('page__statistic');
        }elseif(is_array($id)){
            $query = $this->db->get_where('page_statistic', ['id' => $id]);
        }else{
            $query = $this->db->get('page_statistic', $id);
        }
        return $query->result_array();
    }

        /**
     * @usage
     * All: global statistic
     */
    public function get_gstatistic(){

        $this->db->select('sum(current_pLast72) as p72, 
        sum(current_rLast72) as r72, 
        sum(current_cLast72) as c72, 
        sum(current_sLast72) as s72,
        sum(current_pLast72) - sum(prev_pLast72) as postDiff, 
        sum(current_rLast72) - sum(prev_rLast72) as reactDiff, 
        (sum(current_cLast72) - sum(prev_cLast72)) as commentDiff, 
        (sum(current_sLast72) - sum(prev_sLast72)) as sharesDiff');
        $this->db->from('global_statistic');
        if($this->session->userdata('user')['role'] == 2){
            $this->db->where('user_id = ',$this->session->userdata('user')['user_id']);
        }
        //$userid?$this->db->where('user_id = ', $userid):false;
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
}
