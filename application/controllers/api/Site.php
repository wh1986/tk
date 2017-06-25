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
}

