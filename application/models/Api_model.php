<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends Taoke_Model {
    public function add_invoke_cnt($user_id, $api_name) 
    {
        $today = date('Y-m-d');
        $data = [
            'user_id'     => $user_id,
            'api_name'    => $api_name,
            'date_invoke' => $today
        ];
        $this->db->where($data);

        if(sizeof($this->db->get('user_api_invoke')->result_array()) > 0){
            $this->db->where($data);
            $this->db->set('cnt', 'cnt+1', FALSE);
            $this->db->set('time_last', date('Y-m-d H:i:s'));
            $this->db->update('user_api_invoke');
        } else {
            $this->db->insert('user_api_invoke', $data);
        }
    }

    public function get_invoke_info($user_id, $api_name)
    {
        $today = date('Y-m-d');

        // $sql = 
    }
}

