<?php

class TopupController extends BaseController {
    
    public function processTopup() {
        $arrForm = Input::all();
        $queryString = http_build_query($arrForm);
        
        $response = $this->httpGET_API("/gateway/url?$queryString");
        $arrResp = array();
        if(isset($response['info']) && $response['info']['http_code']==200) {
            $arrResp = json_decode($response['content'], true);
        } else {
            return Redirect::to("/error")->with("flash_error", "Service Unavailable / No Data");
        }
        return Redirect::to($arrResp['url']);
    }
    public function userTopup() {
        return View::make('user_registration', array("title"=>"user"));
    }
    public function topupSuccess($id) {
        $id = (empty($id)?$arrForm['trackid']:$id);
        $response = $this->httpGET_API("/transactions/$id");
        $arrDetails = array();
        if(isset($response['info']) && $response['info']['http_code']==200) {
            $arrDetails = json_decode($response['content'], true);
        } else {
            return Redirect::to("/error")->with("flash_error", "Service Unavailable / No Data");
        }
        return View::make('result_topup', array("title"=>"topup", "topup"=>$arrDetails['transactionStatus'], "result"=>$arrDetails))->with('message', 'Topup Success!!!.');
    }
    public function topupError($id) {
        $id = (empty($id)?$arrForm['trackid']:$id);
        $response = $this->httpGET_API("/transactions/$id");
        $arrDetails = array();
        if(isset($response['info']) && $response['info']['http_code']==200) {
            $arrDetails = json_decode($response['content'], true);
        } else {
            return Redirect::to("/error")->with("flash_error", "Service Unavailable / No Data");
        }
        return View::make('result_topup', array("title"=>"topup", "topup"=>$arrDetails['transactionStatus'], "result"=>$arrDetails))->with('message', 'Topup Failed!!! Please retry.');
    }
}
