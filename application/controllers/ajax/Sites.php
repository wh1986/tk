<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sites extends Ajax_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model('Sites_model');
    }

    public function listview()
    {
        $this->check_session();

        $rows = $this->Sites_model->table_rows(
            $this->user_id,
            $this->input->get('search'),
            $this->input->get('offset'),
            $this->input->get('limit'),
            $this->input->get('sort'),
            $this->input->get('order')
        );

        $resp["total"] = $this->Sites_model->table_count(
            $this->user_id,
            $this->input->get('search')
        );
        $resp["rows"] = $rows;

        // echo $this->db->last_query();
        echo json_encode($resp);
    }

    public function add()
    {
        $this->check_session();
        // 检查参数

        $data = [
            'user_id'          => $this->user_id,
            'advertising_spot' => $this->input->post('promo'),
            'pid'              => $this->input->post('pid'),
            'rate_of_yield'    => $this->input->post('ratio'),
            'domain_name'      => $this->input->post('domain'),
        ];

        // var_dump($data);

        echo json_encode($this->Sites_model->add($data));
    }

    public function del()
    {
        $this->check_session();

        echo json_encode($this->Sites_model->del(
            $this->user_id,
            $this->input->post('site_id')
        ));
    }
}

