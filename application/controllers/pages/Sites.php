<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sites extends Taoke_Controller {
    public function index()
    {
        $datas = [
            'title' => '网站管理',
            'page'  => 'sites_listview.html',
            'js'    => 'sites/sites_listview.js',
        ];

        $this->add_user_info($datas);

        $this->load->view('dashboard.html', $datas);
    }
}

