<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends Taoke_Model {
    public function login($name, $pwd)
    {
        $this->db->select('*')
            ->from('user_account')
            ->where('user_name', $name)
            ->where('user_password', md5($pwd))
            ->limit(1);

        return $this->db->get()->row();
    }
}

