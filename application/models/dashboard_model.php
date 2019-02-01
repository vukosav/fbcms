<?php

class Dashboard_model extends CI_Model{
    
    public function __construct()
    {
            // $this->load->database();
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
        return $query->result_array();
    }
}
