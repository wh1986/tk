<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('response_exit'))
{
    function response_exit($code, $msg, $data=null)
    {
        $resp = [
            'retcode' => $code,
            'msg'     => $msg,
            'data'    => $data
        ];

        echo json_encode($resp);
        exit;
    }
}


