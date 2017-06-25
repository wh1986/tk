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

    public function settings()
    {
        $datas = [
            'title' => '网站设置',
            'page'  => 'sites_settings.html',
            'js'    => 'sites/sites_settings.js',
        ];

        $this->add_user_info($datas);

        $this->load->view('dashboard.html', $datas);
    }
}

