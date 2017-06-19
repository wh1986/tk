<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sites extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model('Sites_model');
    }

    public function listview()
    {
        $rows = $this->Sites_model->table_rows(
            '',
            $this->input->get('search'),
            $this->input->get('offset'),
            $this->input->get('limit'),
            $this->input->get('sort'),
            $this->input->get('order')
        );

        $resp["total"] = $this->Sites_model->table_count(
            '',
            $this->input->get('search')
        );
        $resp["rows"] = $rows;

        // echo $this->db->last_query();
        echo json_encode($resp);
    }

    public function add()
    {
        // 检查参数

        //
        $data = [
            'advertising_spot' => $this->input->post('promo'),
            'pid'              => $this->input->post('pid'),
            'rate_of_yield'    => $this->input->post('ratio'),
            'domain_name'      => $this->input->post('domain'),
        ];

        echo json_encode($this->Sites_model->add($data));
    }

    public function del()
    {
        echo json_encode($this->Sites_model->del($this->input->post('site_id')));
    }
}

