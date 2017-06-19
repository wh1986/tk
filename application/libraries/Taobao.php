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
}

