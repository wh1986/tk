<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Debug extends CI_Controller {
    public function index()
    {
        $this->load->library('dataoke');

        $top100 = $this->dataoke->top100('xfaijvcgvq');

        echo json_encode($top100);
    }

    public function taobao()
    {
        $this->load->library('taobao');

        echo json_encode($this->taobao->detail("24358350", "0115701fb9b4a2f3d6f7b1a4a4f6d7dc", "538507879234"));
    }
}

