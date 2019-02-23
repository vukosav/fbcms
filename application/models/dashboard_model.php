<?php

class Dashboard_model extends CI_Model{
    
    public function __construct()
    {
            // $this->load->database();
    }
    
    function getRows($params = array()){
        $this->db->select('page_statistic.pageLikes, page_statistic.p24, page_statistic.p72, pages.fbPageName as pname, users.username as addedby');
        $this->db->from('page_statistic');
        $this->db->join('pages', 'pages.id = page_statistic.page_id');
        $this->db->join('users', 'users.id = pages.userId');        

        //filter data by user
        // if(!empty($params['search']['group'])){
        //     $this->db->where('users.id = ',$params['search']['group']);
        // }
        //filter data by user
        if(!empty($params['search']['pwithoutPL24'])){
            $this->db->where('page_statistic.p24',0);
        }
        // //filter data by user
        if(!empty($params['search']['pwithoutPL72'])){
            $this->db->where('page_statistic.p72',0);
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
            $query = $this->db->get('page_statistic');
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
        $query = $this->db->get('global_statistic');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
}
