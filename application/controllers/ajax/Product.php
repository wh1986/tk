<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    public function table()
    {
        $this->load->model('product_model');

        $rows = $this->product_model->table_rows(
            $this->input->get('search'),
            $this->input->get('offset'),
            $this->input->get('limit'),
            $this->input->get('sort'),
            $this->input->get('order')
        );

        $resp["total"] = $this->product_model->table_count(
            $this->input->get('search')
        );
        $resp["rows"] = $rows;

        echo json_encode($resp);
    }
}
