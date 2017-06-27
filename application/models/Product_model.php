<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends Taoke_Model {
    public function add_visit_count($ProductId) 
    {

    }

    public function GetCategories()
    {
        return $this->db->get('ProductCategory')->result_array();
    }

    public function search($cid, $keyword, $seller_id, $limit, $offset, $order, $sort)
    {
        if($cid) {
            $this->db->where('cid', $cid);
        }

        if($seller_id) {
            $this->db->where('SellerID', $seller_id);
        }
        $this->db->where('Quan_time >', date('Y-m-d H:i:s'));

        if($keyword){
            $this->db->like('Title', $keyword);
        }

        if($order) {
            $this->db->order_by($order, $sort);
        }

        $this->db->limit($limit, $offset);

        return $this->db->get('Product')->result();
    }

    public function exist($GoodsID)
    {
        $this->db->select('count(*) as cnt');
        $this->db->where('GoodsID', $GoodsID);
        $this->db->limit(1);
        return $this->db->get('Product')->row()->cnt > 0;
    }

    public function get_product($GoodsID)
    {
        $this->db->select('*')->from('Product')
            ->where('GoodsID', $GoodsID)
            ->limit(1);

        return $this->db->get()->row();
    }

    public function get_taobao_pwd($GoodsID, $PID, $QuanID)
    {
        $this->db->select('*')->from('ProductModel')
            ->where('ProductId', $GoodsID)
            ->where('pid', $PID)
            ->where('Quan_id', $QuanID)
            ->limit(1);
        return $this->db->get()->row();
    }

    public function add_taobao_pwd($GoodsID, $PID, $QuanID, $tpwd)
    {
        $data = [
            'ProductId'   => $GoodsID,
            'pid'         => $PID,
            'Quan_id'     => $QuanID,
            'taobaomodel' => $tpwd,
        ];

        return $this->db->insert('ProductModel', $data)
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
        $this->db->where('Quan_time >', date('Y-m-d H:i:s'));

        return $this->db->get()->row()->cnt;
    }
}

