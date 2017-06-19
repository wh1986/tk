<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dataoke {
    protected function api($type, $appkey, $v, $page)
    {
        $url = "http://api.dataoke.com/index.php?r=Port/index&type=$type&appkey=$appkey&v=$v&page=$page";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $output = curl_exec($ch);

        curl_close($ch);

        return json_decode($output);
    }

    public function top100($appkey)
    {
        return $this->api('top100', $appkey, 2, 1);
    }

    public function paoliang($appkey)
    {
        return $this->api('paoliang', $appkey, 2, 1);
    }

    public function total($appkey, $page)
    {
        return $this->api('total', $appkey, 2, $page);
    }
}
