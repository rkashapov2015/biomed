<?php

namespace App\Component;

/**
 * Description of CurlyCurly
 *
 * @author rinat
 */
class CurlyCurly {

    public $url;

    public function __construct($url = '') {
        $this->url = $url;
    }

    public function isReady() {
        if ($this->url) {
            return true;
        }
        return false;
    }

    public function send($data = null, $isPost = true) {

        if ($isPost && (empty($data) || !is_array($data))) {
            return false;
        }

        if (($curl = curl_init())) {
            curl_setopt($curl, CURLOPT_URL, $this->url);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 6);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            
            if ($isPost) {
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            } else {
                curl_setopt($curl, CURLOPT_HTTPHEADER , ['Content-Length: 0']);
            }
            $out = curl_exec($curl);
            if (curl_error($curl)) {
                //(curl_error($curl));
                return false;
            }
            curl_close($curl);
            return $out;
        }
        return false;
    }

}
