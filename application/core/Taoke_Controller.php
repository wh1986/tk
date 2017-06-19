<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Taoke_Controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $user_id = $this->session->userdata('user_id');
        if(!$user_id) {
            header('location:/pages/login');
            exit;
        }
    }

    public function add_user_info(&$data)
    {
        $data['user_id']    = $this->session->userdata('user_id');
        $data['user_name']  = $this->session->userdata('user_name');
        $data['user_phone'] = $this->session->userdata('user_phone');
        $data['user_mail']  = $this->session->userdata('user_mail');
    }
}

