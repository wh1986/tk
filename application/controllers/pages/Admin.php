<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    public function index()
    {
        $datas = [
            'title' => '首页',
            'title_hide' => true,
            'page' => 'admin.html'
        ];
        $this->load->view('dashboard.html', $datas);
    }
}

