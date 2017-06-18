<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sites extends CI_Controller {
    public function index()
    {
        $datas = [
            'title' => '网站管理',
            'page'  => 'sites_listview.html',
            'js'    => 'sites/sites_listview.js',
        ];

        $this->load->view('dashboard.html', $datas);
    }
}

