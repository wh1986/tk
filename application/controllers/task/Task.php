<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task extends CI_Controller {
    public function sync_product()
    {
        $this->load->library('dataoke');
        $this->load->library('taobao');
        $this->load->model('product_model');

        set_time_limit(0);

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

                $taobao = $this->taobao->detail("24358350", "0115701fb9b4a2f3d6f7b1a4a4f6d7dc", $r->GoodsID);
                if($taobao->results && $taobao->results->n_tbk_item) {
                    $item = $taobao->results->n_tbk_item;
                    var_dump($item->item_url . '');
                    echo "<br/>";
                    if($item){
                        $r->item_url       = $item->item_url . '';
                        $r->pict_url       = $item->pict_url . '';
                        $r->provcity       = $item->provcity . '';
                        $r->reserve_price  = $item->reserve_price . '';
                        $r->user_type      = $item->user_type . '';
                        $r->zk_final_price = $item->zk_final_price . '';

                        $cnt = sizeof($item->small_images->string);
                        $imgs = '';
                        for($i = 0; $i < $cnt; $i++) {
                            $imgs = $imgs . $item->small_images->string[$i] . ',';
                        }
                        $r->small_images = $imgs;
                    }
                }

                $r->utime = date('Y-m-d H:i:s');
                $this->product_model->add($r);
            }

            $page = $page + 1;
            $products = $this->dataoke->total('xfaijvcgvq', $page);
        }

        set_time_limit(10);

        echo "OK";
    }
}

