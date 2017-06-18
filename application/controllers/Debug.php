<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Debug extends CI_Controller {
    public function index()
    {
        $this->load->library('dataoke');

        $top100 = $this->dataoke->top100('xfaijvcgvq');

        echo json_encode($top100);
    }
}

