<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends Api_Controller {
    public function GetCategories()
    {
        $this->load->model('product_model');

        $data = $this->product_model->GetCategories();
        foreach($data as &$r) {
            $r['icon'] = 'http://cms.mytaoke.cn/static/icons/' . $r['icon'];
        }

        response_exit(0, 'OK', $data);
    }

    protected function product_to_json($p)
    {
        return [
            'ProductId'    => $p->GoodsID,
            'Title'        => $p->Title,
            "OrgPrice"     => $p->Org_Price,
            "Price"        => $p->Price,
            "SalesNum"     => $p->Sales_num,
            "QuanPrice"    => $p->Quan_price,
            "PicUrl"       => $p->Pic,
            "small_images" => $p->small_images,
            "user_type"    => $p->user_type,
            "provcity"     => $p->provcity,
            "Introduce"    => $p->Introduce,
        ];
    }

    public function search()
    {
        $this->load->model('product_model');

        $cid     = $this->input->get('cid');
        $keyword = urldecode($this->input->get('keyword'));
        $limit   = (int)$this->input->get('limit');
        $offset  = (int)$this->input->get('offset');
        $order   = (int)$this->input->get('order');
        $sort    = (int)$this->input->get('sort');
        $seller_id = $this->input->get('SellerID');

        if($limit == 0 || $limit > 20) { $limit = 20; }

        $products = $this->product_model->search($cid, $keyword, $seller_id, $limit, $offset, $order, $sort);
        $resp['retcode'] = 0;
        $resp['msg']     = 'OK';
        $resp['cnt']     = sizeof($products);
        $resp['data'] = [];

        foreach($products as $p) {
            array_push($resp['data'], $this->product_to_json($p));
        }

        echo json_encode($resp);
    }

    public function info()
    {
        $this->load->model('product_model');
        $this->load->model('sites_model');
        $this->load->library('taobao');

        $domain = "test";
        $pid    = "defaultpid";

        // 根据域名获取pid
        $site = $this->sites_model->get_by_domain($domain);
        if($site) {
            $pid = $site->pid;
        }

        // 获取商品信息
        $ProductId = $this->input->post("ProductId");
        if(!$ProductId) {
            $ProductId = $this->input->get("ProductId");
        }
        if(!$ProductId) {
            response_exit(-1, 'please input product id');
        }

        $product = $this->product_model->get_product($ProductId);
        if(!$product) {
            response_exit(-1, 'no such product');
        }

        // 获取淘口令
        $product_url = $this->taobao->genernate_product_url(
                                    $ProductId, $pid, $product->Quan_id);

        $title = $product->D_title . "\n原价" . $product->Org_Price .
            "元\n抢券立省" . $product->Quan_price . "元";
        $tpwd = $this->taobao->tpwd(
            "24358350", "0115701fb9b4a2f3d6f7b1a4a4f6d7dc",
            $product->Pic, $product_url, $title);

        $data = $this->product_to_json($product);
        $data['ModelTxt'] = "复制框内整段文字，打开手机淘宝即可「领取优惠券」并购买$tpwd->model";

        response_exit(0, 'OK', $data);
    }

}

