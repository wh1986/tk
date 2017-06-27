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

