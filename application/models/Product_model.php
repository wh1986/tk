<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends Taoke_Model {
    public function exist($GoodsID)
    {
        $this->db->select('count(*) as cnt');
        $this->db->where('GoodsID', $GoodsID);
        $this->db->limit(1);
        return $this->db->get('Product')->row()->cnt > 0;
    }

    public function add($row)
    {
        if($this->exist($row->GoodsID)){
            $this->db->where('GoodsID', $row->GoodsID);
            $this->db->update('Product', $row);
        } else {
            $this->db->insert('Product', $row);
        }
    }
}

