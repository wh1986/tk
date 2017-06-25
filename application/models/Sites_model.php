<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sites_model extends Taoke_Model {

    public function get_by_domain($domain)
    {
        return $this->db->where('domain_name', $domain)
            ->limit(1)
            ->get('websites')->row();
    }

    public function modify($site_id, $user_id, $data)
    {
        $is_exist = $this->db->select('count(*) as cnt')
            ->from('websites')
            ->where('website_id != ', $site_id)
            ->where('pid', $data['pid'])
            ->or_group_start()
                ->where('website_id != ', $site_id)
                ->where('user_id', $data['user_id'])
                ->where('advertising_spot', $data['advertising_spot'])
            ->group_end()
            ->or_group_start()
                ->where('website_id != ', $site_id)
                ->where('domain_name', $data['domain_name'])
            ->group_end()
            ->get()->row()->cnt;

        if($is_exist) {
            return $this->std_return(-1, "操作失败, 已经存在该记录");
        }

        $this->db->where('user_id', $user_id);
        $this->db->where('website_id', $site_id);

        $this->db->update('websites', $data);

        return $this->insert_return();
    }

    public function add($data)
    {
        $is_exist = $this->db->select('count(*) as cnt')
            ->from('websites')
            ->where('pid', $data['pid'])
            ->or_group_start()
                ->where('user_id', $data['user_id'])
                ->where('advertising_spot', $data['advertising_spot'])
            ->group_end()
            ->or_where('domain_name', $data['domain_name'])
            ->get()->row()->cnt;

        if($is_exist) {
            return $this->std_return(-1, "操作失败, 已经存在该记录");
        }

        $this->db->insert('websites', $data);

        return $this->insert_return();
    }

    public function del($user_id, $site_id)
    {
        $this->db->delete('websites', ['user_id' => $user_id, 'website_id' => $site_id]);

        return $this->insert_return();
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
    public function table_rows($user, $query, $offset, $limit, $sort, $order)
    {
        $this->load->database();
        $this->db->select("*");
        $this->db->from("websites");
        $this->db->where('user_id', $user);
        if($query) {
            $this->db->group_start()
                        ->or_like('advertising_spot', $query)
                        ->or_like('domain_name', $query)
                        ->or_like('pid', $query)
                    ->group_end();
        }
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
    public function table_count($user, $query)
    {
        $this->load->database();
        $this->db->select("count(*) as cnt");
        $this->db->from("websites");

        $this->db->where('user_id', $user);
        if($query) {
            $this->db->group_start()
                        ->or_like('advertising_spot', $query)
                        ->or_like('domain_name', $query)
                        ->or_like('pid', $query)
                    ->group_end();
        }


        return $this->db->get()->row()->cnt;
    }
}

