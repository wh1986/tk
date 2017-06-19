<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends Taoke_Model {
    public function search($cid, $keyword)
    {

    }

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

    /**
     * @Brief  获取表格Ajax请求所需的记录
     *
     * @Param $user
     * @Param $query
     * @Param $offset
     * @Param $limit
     * @Param $sort
     * @Param $order
     *
     * @Returns
     */
    public function table_rows($query, $offset, $limit, $sort, $order)
    {
        $this->load->database();
        $this->db->select("*");
        $this->db->from("Product");
        if($query) {
            $this->db->group_start()
                        ->or_like('D_title', $query)
                        ->or_like('GoodsID', $query)
                    ->group_end();
        }
        $this->db->where('Quan_time >', date('Y-m-d H:i:s'));
        $this->db->limit($limit, $offset);
        if($sort) {
            $this->db->order_by($sort, $order);
        }

        return $this->db->get()->result_array();
    }

    /**
     * @Brief 获取表格Ajax请求需要的记录行数
     *
     * @Param $user
     * @Param $query
     *
     * @Returns
     */
    public function table_count($query)
    {
        $this->load->database();
        $this->db->select("count(*) as cnt");
        $this->db->from("Product");

        if($query) {
            $this->db->group_start()
                        ->or_like('D_title', $query)
                        ->or_like('GoodsID', $query)
                    ->group_end();
        }

        return $this->db->get()->row()->cnt;
    }
}
