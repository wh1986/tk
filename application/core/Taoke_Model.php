<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Taoke_Model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function std_return($code, $msg)
    {
        return ['retcode' => $code, 'msg' => $msg];
    }

    public function insert_return()
    {
        if($this->db->affected_rows()) {
            return $this->std_return(0, 'OK');
        } else {
            return $this->std_return(-1, '操作失败');
        }
    }
}

