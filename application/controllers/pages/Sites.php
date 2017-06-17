<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sites extends CI_Controller {
    public function new1()
    {
        $datas = [
            'title' => '创建代理网站',
            'page'  => 'sites_new.html',
            'js'    => 'sites/sites_new.js',
            'promos' => [
                ['value'=> 'p01', 'text' => '推广位01'],
                ['value'=> 'p02', 'text' => '推广位02'],
                ['value'=> 'p03', 'text' => '推广位03'],
                ['value'=> 'p04', 'text' => '推广位04'],
                ['value'=> 'p05', 'text' => '推广位05'],
                ['value'=> 'p06', 'text' => '推广位06'],
                ['value'=> 'p07', 'text' => '推广位07'],
                ['value'=> 'p08', 'text' => '推广位08'],
                ['value'=> 'p09', 'text' => '推广位09'],
                ['value'=> 'p10', 'text' => '推广位10'],
                ['value'=> 'p11', 'text' => '推广位11'],
                ['value'=> 'p12', 'text' => '推广位12'],
                ['value'=> 'p13', 'text' => '推广位13'],
                ['value'=> 'p14', 'text' => '推广位14'],
            ],
        ];
        
        $this->load->view('dashboard.html', $datas);
    }

    public function listview()
    {
        $datas = [
            'title' => '网站列表',
            'page'  => 'sites_listview.html',
            'js'    => 'sites/sites_listview.js',
        ];
        
        $this->load->view('dashboard.html', $datas);
    }
}

