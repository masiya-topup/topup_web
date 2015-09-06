<?php

class ApiController extends BaseController {
    public function fetch($res) {
        $arrQueryStr = Input::all();
        $queryString = http_build_query($arrQueryStr);
        $response = $this->httpGET_API("/$res?$queryString");
        $arrDetails = array();
        if(isset($response['info']) && $response['info']['http_code']==200) {
            $arrDetails = json_decode($response['content'], true);
        } else {
            return Redirect::to("/error")->with("flash_error", "Service Unavailable / No Data");
        }

        $arrNew = $this->processContent($arrDetails, Input::get("current"), Input::get("rowCount"));
        
        return json_encode($arrNew);
    }
    
    public function fetchOne($res) {
        $arrQueryStr = Input::all();
        $queryString = http_build_query($arrQueryStr);
        $response = $this->httpGET_API("/$res?$queryString");
        $arrDetails = array();
        if(isset($response['info']) && $response['info']['http_code']==200) {
            $arrDetails = json_decode($response['content'], true);
        } else {
            return Redirect::to("/error")->with("flash_error", "Service Unavailable / No Data");
        }
        return json_encode($arrDetails);
    }
    
    public function userDetails($id, $res) {
        $arrQueryStr = Input::all();
        $queryString = http_build_query($arrQueryStr);
        $response = $this->httpGET_API("/users/$id/$res?$queryString");
        $arrDetails = array();
        if(isset($response['info']) && $response['info']['http_code']==200) {
            $arrDetails = json_decode($response['content'], true);
        } else {
            return Redirect::to("/error")->with("flash_error", "Service Unavailable / No Data");
        }

        $arrNew = $this->processContent($arrDetails);

        return json_encode($arrNew);
    }
    
    private function flattenArray($arr) {
    }
    
    private function processContent($arr, $offset=1, $limit=10) {
        $arrNew = array();
        $arrNew["current"] = 0;
        $arrNew["rowCount"] = 0;
        $arrNew["total"] = 0;
        $arrNew["rows"] = array();
        $offset = ($offset-1);
        $offset = ($offset<0?0:$offset);
        
        if(!empty($arr) && $arr["total"]>0) {
            $arrNew["current"] = $offset+1;
            $arrNew["rowCount"] = $limit;
            $arrNew["total"] = $arr["total"];
            $rowsArr = $arr["rows"];
            foreach ($rowsArr as $indx => $arrData) {
                $arrDataNew = $arrData;
                foreach ($arrData as $key => $value) {
                    if(is_array($value)) {
                        //$arrDataNew = array_merge($arrDataNew, $value);
                        foreach( $value as $keyS => $valueS ) {
                            $arrDataNew[$key."_".$keyS] = $valueS;
                        }
                        unset($arrDataNew[$key]);
                    }
                }
                $arrNew["rows"][] = $arrDataNew;
            }
            if($limit > 0) {
                $arrNew["rows"] = array_splice($arrNew["rows"], $offset*$limit, $limit);
            }
        }
        return $arrNew;
    }
}
