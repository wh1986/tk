<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends Api_Controller {
    public function config()
    {
        $this->load->model('sites_model');

        $domain = $this->input->get('domain');
        $config = $this->sites_model->get_config($domain);


        if($config) {
            $resp = [
                'web_name' => $config->web_name,
                'web_logo' => $config->web_logo
            ];
            response_exit(0, "OK", $resp);
        } else {
            response_exit(-1, "no such domain config info");
        }
    }

    public function qrysession()
    {
        $this->load->model('sites_model');

        $user_id = $this->input->get('user_id');
        $config = $this->sites_model->get_config_by_userid($user_id);
        if($config) {
            $resp = [
                'session' => $config->session,
                'refresh_token' => $config->refresh_token,
                'endtime' => $config->end_time,
            ];
            response_exit(0, "OK", $resp);
        } else {
            response_exit(-1, "no such user session info");
        }
    }

    public function savesession()
    {
        $this->load->model('sites_model');
        $data = [
            'user_id'          => $this->input->post('userid'),
            'session'          => $this->input->post('session'),
            'refresh_token'    => $this->input->post('refresh_token'),
            'session_upd_time' => $this->input->post('stime'),
            'end_time'         => $this->input->post('etime'),
        ];

        echo json_encode($this->sites_model->update_session($data));
    }

    public function domain()
    {
        $pid = $this->input->get('pid');
        if(!$pid) {
            response_exit(-1, "please input pid");
        }

        $this->load->model('sites_model');

        $results = $this->sites_model->get_by_pid($pid);
        if(sizeof($results) == 0) {
            response_exit(-2, "no such pid website config, please check");
        }

        $domains = [];
        foreach($results as $r) {
            array_push($domains, $r->domain_name);
        }

        response_exit(0, "OK", $domains);

    }
}

