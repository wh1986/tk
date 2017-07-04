<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sites extends Ajax_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model('Sites_model');
    }

    public function alitest()
    {
        $this->load->library('taobao');

        $appkey = $this->input->post('appkey');
        $secret = $this->input->post('secret');


        $tpwd = $this->taobao->tpwd(
            $appkey, $secret, "http://mytaoke.cn/1.png", "http://item.taobao.com/item.htm?id=6827472963", "alitest");
        if($tpwd->model) {
            response_exit(0, 'OK');
        } else {
            if($tpwd->msg) {
                response_exit(-1, "测试失败, 原因:$tpwd->msg");
            } else {
                response_exit(-1, "测试失败");
            }
        }
    }

    public function config()
    {
        $this->check_session();

        $data = [
            'user_id'       => $this->user_id,
            'web_name'      => $this->input->post('name'),
            'domain_name'   => $this->input->post('domain_name'),
            'ali_appkey'    => $this->input->post('appkey'),
            'ali_secret'    => $this->input->post('secret'),
            'session'       => $this->input->post('session'),
            'refresh_token' => $this->input->post('token'),
            'roottxt'       => $this->input->post('roottxt'),
            'domain_ali'    => $this->input->post('domain_ali')
        ];

        $roottxt = $this->input->post('roottxt');

        if(preg_match("/^[a-za-z0-9_]+$/", $roottxt)) {
            $path = BASEPATH . "../../tkshop/roots/" . $this->input->post('domain_ali') . ".txt";
            $cmd = "echo $roottxt > $path";
            system($cmd);
            // echo $cmd;
        }

        echo json_encode($this->Sites_model->update_config($data));
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
        $site_id = (int)$this->input->post('site_id');

        $data = [
            'user_id'          => $this->user_id,
            'advertising_spot' => $this->input->post('promo'),
            'pid'              => $this->input->post('pid'),
            'rate_of_yield'    => $this->input->post('ratio'),
            'domain_name'      => $this->input->post('domain'),
            'domain_name_personal' => ''
        ];

        if($site_id > 0) {
            echo json_encode($this->Sites_model->modify($site_id, $this->user_id, $data));
        } else {
            if($data['domain_name'] == "cms.xmfdate.com") {
                response_exit(-1, "该域名已经被使用");
            }
            echo json_encode($this->Sites_model->add($data));
        }
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

