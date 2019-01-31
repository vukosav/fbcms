<?php

class Dashboard_model extends CI_Model{
    
    // public function __construct(){
    //     $this->load->database();
    // }
    /**
     * @usage
     * Single:
     * All:
     * Custom:
     */
    // public function get_news($id = null){
    //     if($id === null){
    //         $query = $this->db->get('page_statistic');
    //     }elseif(is_array($id)){
    //         $query = $this->db->get_where('page_statistic', ['id' => $id]);
    //     }else{
    //         $query = $this->db->get('page_statistic', $id);
    //     }
    //     return $query->result_array();
    // }

    public function get_news($slug = FALSE){
        if ($slug === FALSE){
            $query = $this->db->get('news');
            return $query->result_array();
        }
    }

    public function insert(){

    }

    public function update(){

    }

    public function delete(){

    }
}
