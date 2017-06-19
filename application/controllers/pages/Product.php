<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends Taoke_Controller {
    public function index()
    {
        $datas = [
            'title' => '产品管理',
            'page'  => 'product.html',
            'js'    => 'product/product.js',
        ];

        $this->add_user_info($datas);

        $this->load->view('dashboard.html', $datas);
    }
}

