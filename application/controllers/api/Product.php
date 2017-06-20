<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {
    public function search()
    {

    }

    protected function get_taobao_cmd($GoodsID, $PID)
    {
        ;
    }

    public function info()
    {
        $this->load->model('product_model');

        $ProductId = $this->input->post("ProductId");
        if(!$ProductId) {
            response_exit(-1, 'please input product id');
        }

        $product = $this->product_model->get_product($ProductId);
        if(!$product) {
            response_exit(-1, 'no such product');
        }

        $data = [
            'ProductId' => $ProductId,
        ];

        response_exit(0, 'OK', $data);
    }

}

