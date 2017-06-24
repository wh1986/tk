<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Ajax_Controller {
    public function login()
    {
        $this->load->model('user_model');

        $name = $this->input->post('name');
        $pwd  = $this->input->post('pwd');

        $user = $this->user_model->login($name, $pwd);

        $resp = ['retcode' => 0, 'msg' => 'OK'];
        if(!$user) {
            $resp = ['retcode' => -1, 'msg' => '用户名密码错误'];
        } else {
            $this->session->set_userdata('user_id', $user->user_id);
            $this->session->set_userdata('user_name', $user->user_name);
            $this->session->set_userdata('user_mail', $user->user_mail);
            $this->session->set_userdata('user_phone', $user->user_phone);
        }

        echo json_encode($resp);
    }

    public function logout()
    {
        $this->session->unset_userdata('user_id');
        header("location:/pages/login");
    }

    public function modify_pwd()
    {
        $this->check_session();

        $this->load->model('user_model');

        $pwd_old = $this->input->post('pwd_old');
        $pwd_new = $this->input->post('pwd_new');

        $result = $this->user_model->modify_pwd($this->user_id, $pwd_old, $pwd_new);
        echo json_encode($result);
    }
}

