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

    public function modify_pwd($user_id, $pwd_old, $pwd_new)
    {
        $this->db->where('user_id', $user_id)
            ->where('user_password', md5($pwd_old));
        $this->db->update('user_account', ['user_password' => md5($pwd_new)]);

        return $this->insert_return();
    }
}

