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

    public function tbkprivilege2($session, $ProductId, $pid) 
    {
        $url = 'http://wx.cnexce.com/api/privilege';

        $aid = 'c755834dd3666fc32178e8f75ffa448e';
        $token = '9df6fc3aa35f3fd6';

        $post = "aid=$aid&token=$token&sid=$session&pid=$pid&cid=$ProductId";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec ($ch);

        curl_close($ch);

        return json_decode($output);
    }

    public function tbkprivilege($appkey, $secret, $sessionKey, $ProductId, $pid, $platform = 2) 
    {
        $array = explode('_', $pid);
        $adzone_id = $array[3];
        $site_id = $array[2];

        $c = new TopClient;
        $c->appkey = $appkey;
        $c->secretKey = $secret;
        $req = new TbkPrivilegeGetRequest;
        $req->setItemId($ProductId);
        $req->setAdzoneId($adzone_id);
        $req->setPlatform($platform);
        $req->setSiteId($site_id);

        $resp = $c->execute($req, $sessionKey);

        return $resp;
    } 

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

