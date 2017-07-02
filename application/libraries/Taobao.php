<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once('taobao/TopSdk.php');

class Taobao {
    public function detail($appkey, $secret, $ids)
    {
        $c = new TopClient;
        $c->appkey = $appkey;
        $c->secretKey = $secret;
        $req = new TbkItemInfoGetRequest;
        $req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url");
        $req->setPlatform("1");
        $req->setNumIids($ids);
        $resp = $c->execute($req);

        return $resp;
    }

    /*
    public function tbkprivilege($ProductId, $pid, $platform) 
    {
        $c = new TopClient;
        $c->appkey = $appkey;
        $c->secretKey = $secret;
        $req = new TbkPrivilegeGetRequest;
        $req->setItemId($ProductId);
        $req->setAdzoneId("123");
        $req->setPlatform($platform);
        $req->setSiteId("1");

        $resp = $c->execute($req, $sessionKey);

        return $resp;
    } 
    */

    public function genernate_product_url($product_id, $pid, $coupon_id)
    {
        return "https://uland.taobao.com/coupon/edetail?activityId=$coupon_id&pid=$pid&itemId=$product_id";
    }

    public function tpwd($appkey, $secret, $logo, $url, $text)
    {
        $c            = new TopClient;
        $c->appkey    = $appkey;
        $c->secretKey = $secret;

        $req = new WirelessShareTpwdCreateRequest;

        $tpwd_param = new GenPwdIsvParamDto;
        $tpwd_param->logo = $logo;
        $tpwd_param->url  = $url;
        $tpwd_param->text = $text;

        $req->setTpwdParam(json_encode($tpwd_param));
        $resp = $c->execute($req);

        return $resp;
    }
}

