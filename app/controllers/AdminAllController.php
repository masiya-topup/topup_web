<?php

class AdminAllController extends BaseController {
    public function show($resource) {
        $resp = "";
        $userLogin = (Session::get("userLogin"));
        $usr = $userLogin->user;
        $arrData = array("title"=>"admin", "user"=>$usr);
        
        $response = $this->httpGET_API("/countries");
        
        $arrCountries = array();
        if(isset($response['info']) && $response['info']['http_code']==200) {
            $arrCountries = json_decode($response['content'], true);
        } else {
            return Redirect::to("/error")->with("flash_error", "Service Unavailable / No Data");
        }
        $arrData["countries"] = $arrCountries;
        
        switch($resource) {
            case "companies":
                
                break;
            case "categories":
                $response = $this->httpGET_API("/companies");
        
                $arrCompanies = array();
                if(isset($response['info']) && $response['info']['http_code']==200) {
                    $arrCompanies = json_decode($response['content'], true);
                } else {
                    return Redirect::to("/error")->with("flash_error", "Service Unavailable / No Data");
                }
                $arrData["companies"] = $arrCompanies['rows'];
                break;
            case "services":
                $response = $this->httpGET_API("/companies");
        
                $arrCompanies = array();
                if(isset($response['info']) && $response['info']['http_code']==200) {
                    $arrCompanies = json_decode($response['content'], true);
                } else {
                    return Redirect::to("/error")->with("flash_error", "Service Unavailable / No Data");
                }
                $arrData["companies"] = $arrCompanies['rows'];
                
                $response = $this->httpGET_API("/categories");
        
                $arrCategories = array();
                if(isset($response['info']) && $response['info']['http_code']==200) {
                    $arrCategories = json_decode($response['content'], true);
                } else {
                    return Redirect::to("/error")->with("flash_error", "Service Unavailable / No Data");
                }
                $arrData["categories"] = $arrCategories['rows'];
                break;
            case "user":
            case "customercares":
            case "financeusers":
                
                break;
        }
        $resp = View::make("admin_all_$resource", $arrData);
        
        return $resp;
    }
    
    public function process($resource) {
        $arrInput = Input::all();
        $arrData = array();
        $arrAction2Verbs = array("add"=>"POST", "edit"=>"PUT", "delete"=>"DELETE");
        $arrAction2Code = array("add"=>200, "edit"=>200, "delete"=>204);
        $id = "";
        $api_path = "/$resource";
        switch($resource) {
            case "companies":
                $id = $arrInput["companyId"];
                $arrData["companyId"] = (isset($arrInput["companyId"])? $arrInput["companyId"]: "");
                $arrData["companyName"] = (isset($arrInput["companyName"])? $arrInput["companyName"]: "");
                $arrData["companyDesc"] = (isset($arrInput["companyDesc"])? $arrInput["companyDesc"]: "");
                $arrData["country"] = array("countryId" => (isset($arrInput["countryId"])? $arrInput["countryId"]: "1"));
                break;
            case "categories":
                $id = $arrInput["categoryId"];
                $arrData["categoryId"] = (isset($arrInput["categoryId"])? $arrInput["categoryId"]: "");
                $arrData["categoryName"] = (isset($arrInput["categoryName"])? $arrInput["categoryName"]: "");
                $arrData["categoryDesc"] = (isset($arrInput["categoryDesc"])? $arrInput["categoryDesc"]: "");
                $arrData["company"] = array("companyId" => (isset($arrInput["companyId"])? $arrInput["companyId"]: "1"));
                $arrData["country"] = array("countryId" => (isset($arrInput["countryId"])? $arrInput["countryId"]: "1"));
                break;
            case "services":
                $id = $arrInput["serviceId"];
                $arrData["serviceId"] = (isset($arrInput["serviceId"])? $arrInput["serviceId"]: "");
                $arrData["serviceName"] = (isset($arrInput["serviceName"])? $arrInput["serviceName"]: "");
                $arrData["serviceDesc"] = (isset($arrInput["serviceDesc"])? $arrInput["serviceDesc"]: "");
                $arrData["serviceApiURL"] = (isset($arrInput["serviceApiURL"])? $arrInput["serviceApiURL"]: "");
                $arrData["company"] = array("companyId" => (isset($arrInput["companyId"])? $arrInput["companyId"]: "1"));
                $arrData["category"] = array("categoryId" => (isset($arrInput["categoryId"])? $arrInput["categoryId"]: "1"));
                break;
            case "users":
            case "customercares":
            case "financeusers":
                $api_path = "/users";
                $id = $arrInput["userId"];
                $arrData["userId"] = (isset($arrInput["userId"])? $arrInput["userId"]: "");
                $arrData["userFirstName"] = (isset($arrInput["userFirstName"])? $arrInput["userFirstName"]: "");
                $arrData["userLastName"] = (isset($arrInput["userLastName"])? $arrInput["userLastName"]: "");
                $arrData["userLogin"] = (isset($arrInput["userLogin"])? $arrInput["userLogin"]: "");
                $arrData["userEmail"] = (isset($arrInput["userEmail"])? $arrInput["userEmail"]: "");
                $arrData["userPassword"] = (isset($arrInput["userPassword"])? $arrInput["userPassword"]: "");
                $arrData["userGender"] = (isset($arrInput["userGender"])? $arrInput["userGender"]: "");
                $arrData["userBirthDate"] = (isset($arrInput["userBirthDate"])? $arrInput["userBirthDate"]: "");
                $arrData["userAddress"] = (isset($arrInput["userAddress"])? $arrInput["userAddress"]: "");
                $arrData["userRole"] = (isset($arrInput["userRole"])? $arrInput["userRole"]: "");
                $arrData["country"] = array("countryId" => (isset($arrInput["countryId"])? $arrInput["countryId"]: "1"));
                break;
        }
        
        $resp = "";
        $hdr = array("Content-Type: application/json");
        $arrResp = array();
        if(count($arrData) >0) {
            $verb = $arrAction2Verbs[$arrInput["action"]];
            $code = $arrAction2Code[$arrInput["action"]];
            if($arrInput["action"] != "add") {
                $api_path = "$api_path/$id";
            }
            
            $response = $this->httpCURL_API($verb, $api_path, json_encode($arrData), $hdr);
            
            if(isset($response['info']) && $response['info']['http_code']==$code) {
                $arrResp = json_decode($response['content'], true);
            } else {
                return Redirect::to("/admin/all/$resource")->with("message", "Service Unavailable / No Data");
            }
            Log::info($response);
        }
        if(isset($arrInput['userPhone'])) {
            if($arrInput["action"] == "add" && preg_match("/users|customercares|financeusers/", $resource)>0) {
                $arrResp = $arrResp['user'];
            }
            Log::info($arrResp);
            $id = $arrResp['userId'];
            $arrPhoneData = array("user"=>$arrResp);
            $arrPhoneData["userPhoneNo"] = $arrInput['userPhone'][0];
            $arrPhoneData["userPhoneType"] = $arrInput['userPhoneType'][0];
            $hdr = array("Content-Type: application/json");
            $phoneId = $arrInput['userPhoneId'][0];
            if($phoneId === "0") {
                $resp = $this->httpPOST_API("/users/$id/phones", json_encode($arrPhoneData), $hdr);
            } else {
                $arrPhoneData['userPhoneId'] = $phoneId;
                $resp = $this->httpPUT_API("/users/$id/phones/$phoneId", json_encode($arrPhoneData), $hdr);
            }
        }
        
        return Redirect::to("/admin/all/$resource");
    }
}
