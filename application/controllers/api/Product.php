<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends Api_Controller {
    public function GetCategories()
    {
        $this->load->model('product_model');

        $data = $this->product_model->GetCategories();
        foreach($data as &$r) {
            $r['icon'] = 'http://cms.xmfdate.com/static/icons/' . $r['icon'];
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
            "SellerID"     => $p->SellerID,
            "Cid"          => $p->Cid,
        ];
    }

    public function search()
    {
        // $this->api_model->add_invoke_cnt(1, "xmf.product.search");
        $this->load->model('product_model');

        $cid     = $this->input->get('cid');
        $keyword = urldecode($this->input->get('keyword'));
        $limit   = (int)$this->input->get('limit');
        $offset  = (int)$this->input->get('offset');
        $order   = (int)$this->input->get('order');
        $sort    = (int)$this->input->get('sort');
        $seller_id = $this->input->get('SellerID');
        $price_min = (double)$this->input->get('price_min');
        $price_max = (double)$this->input->get('price_max');

        if($limit == 0 || $limit > 20) { $limit = 20; }

        $products = $this->product_model->search($cid, $keyword, $seller_id, $price_min, $price_max, $limit, $offset, $order, $sort);
        $resp['retcode'] = 0;
        $resp['msg']     = 'OK';
        $resp['cnt']     = sizeof($products);
        $resp['data'] = [];

        foreach($products as $p) {
            array_push($resp['data'], $this->product_to_json($p));
        }

        echo json_encode($resp);
    }

    public function privilege()
    {
        $this->load->library('taobao');
        $this->load->model('sites_model');
        $this->load->model('user_model');

        $api_name = "xmf.product.privilege";

        $user_id = $this->input->get('xmfappkey');
        $secrect = $this->input->get('xmfsecrect');
        $gid = $this->input->get("gid");
        $pid = $this->input->get("pid");

        if($user_id == "") {
            response_exit(-1, "Please input appkey");
        }

        if($secrect == "") {
            response_exit(-1, "Please input secrect");
        }

        if($gid == "") {
            response_exit(-1, "Please input gid");
        }

        if($pid == "") {
            response_exit(-1, "Please input pid");
        }

        if(!$this->user_model->check_secrect($user_id, $secrect)) {
            response_exit(-1, "invalid appkey or secrect");
        }

        $this->api_model->add_invoke_cnt($user_id, $api_name);

        $invoke_info = $this->api_model->get_invoke_info($user_id, $api_name);
        if(!$invoke_info) {
            response_exit(-1, "you are not allowed invoke this api");
        }

        if($invoke_info->cnt > $invoke_info->cnt_per_day) {
            response_exit(-1, "you are not allowed invoke this api today");
        }

        if(strtotime($invoke_info->time_end) < time()) {
            response_exit(-1, "you are not allowed invoke this api anymore");
        }

        $config = $this->sites_model->get_config_by_userid($user_id);
        if(!$config) {
            response_exit(-1, "No such appkey config info");
        }

        if(!$config->session) {
            response_exit(-1, "Session is empty!");
        }

        $response = $this->taobao->tbkprivilege(
                $this->config->item('TAOBAO_PRIVILEGE_APPKEY'),
                $this->config->item('TAOBAO_PRIVILEGE_SERECT'),
                $config->session,
                $gid, 
                $pid);

        response_exit(0, "OK", $response);
    }

    public function _get_privilege($config, $product, $pid, &$data)
    {
        if($config->session){
            $privilege = $this->taobao->tbkprivilege(
                $this->config->item('TAOBAO_PRIVILEGE_APPKEY'),
                $this->config->item('TAOBAO_PRIVILEGE_SERECT'),
                $config->session, 
                $product->GoodsID, 
                $pid);
            if($privilege && $privilege->result&& $privilege->result->data && $privilege->result->data->coupon_click_url) {
                $data['coupon_click_url'] = $privilege->result->data->coupon_click_url;
                $data['max_commission_rate'] = $privilege->result->data->max_commission_rate;

                $tpwd = $this->_get_taopwd($config, $product, $data['coupon_click_url']);
                if(!$tpwd || !$tpwd->model) {
                    $data['taobaomodel'] = $tpwd->model;
                }
            }
        }
    }

    public function _get_taopwd($config, $product, $url) 
    {
        $D_title = $product->D_title;
        if(mb_strlen($D_title) > 10) {
            $D_title = mb_substr($D_title, 0, 10) . "...";
        }

        $title = $D_title . "\n原价" . $product->Org_Price .
            "元,抢券立省" . $product->Quan_price . "元";
        $tpwd = $this->taobao->tpwd($config->ali_appkey, $config->ali_secret,
                        $product->Pic, $url, $title);
        // var_dump($tpwd);
        return $tpwd;

    }

    protected function _get_info($domain, $product)
    {
        $pid = "defaultpid";
        $ProductId = $product->GoodsID;

        // 根据域名获取pid
        $site = $this->sites_model->get_by_domain($domain);
        if($site) {
            $pid = $site->pid;
        } else {
            return null;
        }

        $data_db = [
            'GoodsID' => $ProductId,
            'Quan_id' => $product->Quan_id,
            'pid'     => $pid
        ];
            // var_dump($data_db);

        $tpwd_db = $this->product_model->get_taobao_pwd($ProductId, $pid, $product->Quan_id);
        if($tpwd_db && $tpwd_db->taobaomodel) {
            $data_db['taobaomodel'] = $tpwd_db->taobaomodel;
            $this->product_model->add_visit_count($ProductId, $pid);

            // 申请高佣
            if(!$tpwd_db->coupon_click_url) {
                $config = $this->sites_model->get_config($domain);
                if(!$config) { return null; }

                $this->_get_privilege($config, $product, $pid, $data_db);
                $this->product_model->update_taobao_pwd($data_db);
            }
        } else {
            // 根据域名获取appkey 
            $config = $this->sites_model->get_config($domain);
            if(!$config) { return null; }

            $this->_get_privilege($config, $product, $pid, $data_db);

            if(!array_key_exists('taobaomodel', $data_db)) {
                // 获取淘口令
                $product_url = $this->taobao->genernate_product_url($ProductId, $pid, $product->Quan_id);

                $tpwd = $this->_get_taopwd($config, $product, $product_url);
                if(!$tpwd || !$tpwd->model) {
                    return null;
                }
                $data_db['taobaomodel'] = $tpwd->model;
            }

            $this->product_model->update_taobao_pwd($data_db);
        }

        $data = $this->product_to_json($product);
        $data['ModelTxt'] = "复制框内整段文字，打开手机淘宝即可「领取优惠券」并购买" . $data_db['taobaomodel'];
        $data['domain'] = $domain;

        return $data;
    }

    public function info()
    {
        $this->load->model('product_model');
        $this->load->model('sites_model');
        $this->load->library('taobao');

        // 获取商品信息
        $ProductId = $this->input->get("ProductId");
        if(!$ProductId) {
            response_exit(-1, 'please input product id');
        }

        $product = $this->product_model->get_product($ProductId);
        if(!$product) {
            response_exit(-1, 'no such product');
        }

        $domain = $this->input->get_request_header('Origin');
        if(!$domain) {
            $domain = $this->input->get('domain');
        } else {
            $domain = str_replace("http://", "", $domain);
            $domain = str_replace("https://", "", $domain);
        }

        $domain_r = explode(".", $domain);
        $domain_cnt = sizeof($domain_r);
        if( $domain_cnt > 3) {
            $domain = $domain_r[$domain_cnt - 3] . '.' . $domain_r[$domain_cnt - 2] . '.' . $domain_r[$domain_cnt - 1];
        }

        $data = null;

        if($domain) {
            $data = $this->_get_info($domain, $product);
        }

        if(!$data) {
            $domain = "gaoshiqing.xmfdate.com";
            $data = $this->_get_info($domain, $product);
        }

        $data['domain'] = $domain;

        response_exit(0, 'OK', $data);
    }

}

