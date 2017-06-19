<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {
    function array_remove($data, $key){
        if(!array_key_exists($key, $data)){
            return $data;
        }
        $keys = array_keys($data);
        $index = array_search($key, $keys);
        if($index !== FALSE){
            array_splice($data, $index, 1);
        }

        return $data;
    }

    public function index()
    {
        $datas = [
            'title' => '产品管理',
            'page'  => 'product.html',
            'js'    => 'product/product.js',
        ];

        $this->load->view('dashboard.html', $datas);
    }

    public function sync()
    {
        $this->load->library('dataoke');
        $this->load->model('product_model');

        $page = 1;
        $products = $this->dataoke->total('xfaijvcgvq', $page);
        while ($products && $page < 1000) {
            $rows = $products->result;
            echo "Fetch page:$page size:" . sizeof($rows) . " <br />";
            foreach($rows as $r) {
                unset($r->ID);
                unset($r->Jihua_shenhe);
                unset($r->Que_siteid);
                unset($r->Commission);
                $this->product_model->add($r);
            }

            $page = $page + 1;
            $products = $this->dataoke->total('xfaijvcgvq', $page);

        }

        echo "OK";
    }
}

