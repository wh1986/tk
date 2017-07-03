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

    public function test()
    {
        $this->load->library('taobao');
        // echo $this->taobao->tbkprivilege2('7000010104319037930bf6e73884b69c4cb8281828e970349a1d284179073df1449dfb2491703823', '541337340416', 'mm_26277828_21380752_71900057');
        echo json_encode($this->taobao->tbkprivilege2('7000010104319037930bf6e73884b69c4cb8281828e970349a1d284179073df1449dfb2491703823', '1005197942', 'mm_26277828_21380752_71900057'));
    }
}

