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
        $this->load->model('sites_model');

        $datas = [
            'title' => '网站设置',
            'page'  => 'sites_settings.html',
            'js'    => 'sites/sites_settings.js',
        ];
        $config = $this->sites_model->get_config_by_userid($this->user_id);
        if(!$config) {
            $datas['name']   = '';
            $datas['domain'] = '';
            $datas['appkey'] = '';
            $datas['secret'] = '';
        } else {
            $datas['name']   = $config->web_name;
            $datas['domain'] = $config->domain_name;
            $datas['appkey'] = $config->ali_appkey;
            $datas['secret'] = $config->ali_secret;
        }

        $this->add_user_info($datas);

        $this->load->view('dashboard.html', $datas);
    }
}

