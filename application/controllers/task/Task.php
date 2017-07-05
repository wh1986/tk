<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task extends CI_Controller {
    protected function update_taobao_info()
    {
        $this->load->model('product_model');
        $this->load->library('taobao');

        $offset   = 0;
        $limit    = 40;
        $finished = 0;

        while ($finished == 0) {
            $this->db->select('GoodsID');
            $this->db->where('Quan_time >= ', date('Y-m-d H:i:s'));
            $this->db->limit($limit, $offset);
            $rows = $this->db->get('Product')->result();
            if($rows && sizeof($rows) < $limit) {
                $finished = 1;
            } 
            $offset = $offset + sizeof($rows);

            $ids = "";
            foreach($rows as $r) {
                $ids = $ids . $r->GoodsID . ',';
            }

            if($ids == "") {
                break;
            }

            $taobao = $this->taobao->detail("24523839", "5994c8f1486a815251c5667839c48caf", $ids);
            if($taobao->results && $taobao->results->n_tbk_item) {
                $items = $taobao->results->n_tbk_item;
                $this->db->trans_begin();
                foreach($items as $item) {
                    $r = new stdclass();
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

                        $this->product_model->update($item->num_iid, $r);
                    }
                }
                $this->db->trans_commit();
            }
        }
    }

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
            $this->db->trans_begin();
            foreach($rows as $r) {
                unset($r->ID);
                unset($r->Jihua_shenhe);
                unset($r->Que_siteid);
                unset($r->Commission);

                $r->utime = date('Y-m-d H:i:s');
                $this->product_model->add($r);
            }
            $this->db->trans_commit();

            $page = $page + 1;
            $products = $this->dataoke->total('xfaijvcgvq', $page);
        }

        $this->update_taobao_info();

        set_time_limit(10);

        echo "OK";
    }
}

