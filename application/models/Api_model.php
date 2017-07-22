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
            $data['cnt'] = 1;
            $this->db->insert('user_api_invoke', $data);
        }
    }

    public function get_invoke_info($user_id, $api_name)
    {
        $today = date('Y-m-d');

        $this->db->select('user_api.*, user_api_invoke.cnt');
        $this->db->from('user_api');
        $this->db->join('user_api_invoke', 
            "user_api.user_id=user_api_invoke.user_id and user_api.api_name=user_api_invoke.api_name");
        $data = [
            'user_api.user_id'     => $user_id,
            'user_api.api_name'    => $api_name,
            'user_api_invoke.date_invoke' => $today
        ];
        $this->db->where($data);

        return $this->db->get()->row();
    }
}

