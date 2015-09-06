<?php

class BaseController extends Controller {

    private $host_path;
    private $base_path;
    
    public function __construct() {
        $this->host_path = "http://localhost:8080";
        $this->base_path = $this->host_path."/topup/api/v1";
    }

    protected function setupLayout() {
        if ( ! is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }
    
    public function httpGET_API($api_path, $header = array(), $bearer=true) {
        if($bearer) {
            $authToken = Session::get('authtoken');
            $header[] = 'Authorization: Bearer '.$authToken;
        }
        $content = $this->httpGET($this->base_path . $api_path, $header);
        return $content;
    }
    
    public function httpPOST_API($api_path, $body = "", $header = array(), $bearer=true) {
        if($bearer) {
            $authToken = Session::get('authtoken');
            $header[] = 'Authorization: Bearer '.$authToken;
        }
        $content = $this->httpPOST($this->base_path . $api_path, $body, $header);
        
        return $content;
    }
    
    public function httpPUT_API($api_path, $body = "", $header = array(), $bearer=true) {
        if($bearer) {
            $authToken = Session::get('authtoken');
            $header[] = 'Authorization: Bearer '.$authToken;
        }
        $content = $this->httpPUT($this->base_path . $api_path, $body, $header);
        
        return $content;
    }

    public function httpDELETE_API($api_path, $body = "", $header = array(), $bearer=true) {
        if($bearer) {
            $authToken = Session::get('authtoken');
            $header[] = 'Authorization: Bearer '.$authToken;
        }
        $content = $this->httpDELETE($this->base_path . $api_path, $body, $header);
        
        return $content;
    }
    
    public function httpCURL_API($verb, $api_path, $body = null, $header = array(), $bearer=true) {
        if($bearer) {
            $authToken = Session::get('authtoken');
            $header[] = 'Authorization: Bearer '.$authToken;
        }
        $content = $this->httpCURL($verb, $this->base_path . $api_path, $body, $header);
        
        return $content;
    }
    
    public function httpCURL($verb, $full_path, $body = null, $header = array()) {
        $l4_sid = Session::getId();
        $header[] = "X-L4-Session: $l4_sid";
        $ch = curl_init();
        
        if($verb === "GET") {
            curl_setopt($ch, CURLOPT_POST, false);
        } else if($verb === "POST") {
            curl_setopt($ch, CURLOPT_POST, true);
            if(!empty($body)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            }
        } else if($verb === "PUT") {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            if(!empty($body)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            }
        } else if($verb === "DELETE") {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        }
        
        curl_setopt($ch, CURLOPT_URL, $full_path);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 100);
        curl_setopt($ch, CURLOPT_TIMEOUT, 100);
        
        $content = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        
        $hdr = implode("\n", $header);
        Log::info("$l4_sid: OutgoingRequest: $verb $full_path\n".$hdr."\n$body");
        $resp = array("info"=>$info, "content"=>$content);
        Log::info($resp);
        return $resp;
    }

    public function httpGET($full_path, $header = array()) {
        return $this->httpCURL("GET", $full_path, "", $header);
    }
    
    public function httpPOST($full_path, $body = "", $header = array()) {
        return $this->httpCURL("POST", $full_path, $body, $header);
    }
    
    public function httpPUT($full_path, $body = "", $header = array()) {
        return $this->httpCURL("PUT", $full_path, $body, $header);
    }
    
    public function httpDELETE($full_path, $body = "", $header = array()) {
        return $this->httpCURL("DELETE", $full_path, $body, $header);
    }

}
