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

class Ajax_Controller extends CI_Controller {
    protected $user_id = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function check_session()
    {
        $this->user_id = $this->session->userdata('user_id');
        if(!$this->user_id) {
            response_exit(-2, "您未登录，请先登录!");
        }
    }
}

class Api_Controller extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        header("Access-Control-Allow-Origin:*");
    }
}

