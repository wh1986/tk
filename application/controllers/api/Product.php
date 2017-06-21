<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {
    public function search()
    {

    }

    public function info()
    {
        $this->load->model('product_model');
        $this->load->model('sites_model');
        $this->load->library('taobao');

        $domain = "test";
        $pid = "default pid";

        // 根据域名获取pid
        $site = $this->sites_model->get_by_domain($domain);
        if($site) {
            $pid = $site->pid;
        }

        // 获取商品信息
        $ProductId = $this->input->post("ProductId");
        if(!$ProductId) {
            response_exit(-1, 'please input product id');
        }

        $product = $this->product_model->get_product($ProductId);
        if(!$product) {
            response_exit(-1, 'no such product');
        }

        // 获取淘口令
        $product_url = $this->taobao->genernate_product_url(
                                    $product_id, $pid, $coupon_id);
        $tpwd = $this->taobao->tpwd(
            "24358350", "0115701fb9b4a2f3d6f7b1a4a4f6d7dc", 
            $product->pic, $product_url, $product->Title);

        $data = [
            'ProductId' => $ProductId,
        ];

        response_exit(0, 'OK', $data);
    }

}

