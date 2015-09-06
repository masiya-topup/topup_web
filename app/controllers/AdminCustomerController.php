<?php

class AdminCustomerController extends BaseController {
    public function show($resource) {
        $resp = "";
        $userLogin = (Session::get("userLogin"));
        $usr = $userLogin->user;
        $arrData = array("title"=>"admin", "user"=>$usr);
        switch($resource) {
            case "tickets":
                $response = $this->httpGET_API("/users?role=user");
        
                $arrTickets = array();
                if(isset($response['info']) && $response['info']['http_code']==200) {
                    $arrTickets = json_decode($response['content'], true);
                } else {
                    return Redirect::to("/error")->with("flash_error", "Service Unavailable / No Data");
                }
                $arrData["users"] = $arrTickets['rows'];
                break;
            case "users":
                $response = $this->httpGET_API("/countries");
        
                $arrCountries = array();
                if(isset($response['info']) && $response['info']['http_code']==200) {
                    $arrCountries = json_decode($response['content'], true);
                } else {
                    return Redirect::to("/error")->with("flash_error", "Service Unavailable / No Data");
                }
                $arrData["countries"] = $arrCountries;
                break;
            case "logs":
                
                break;
        }

        $resp = View::make("admin_customer_$resource", $arrData);
        
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
            case "tickets":
                $id = $arrInput["ticketId"];
                $arrData["ticketId"] = (isset($arrInput["ticketId"])? $arrInput["ticketId"]: "");
                $arrData["ticketTitle"] = (isset($arrInput["ticketTitle"])? $arrInput["ticketTitle"]: "");
                $arrData["ticketDesc"] = (isset($arrInput["ticketDesc"])? $arrInput["ticketDesc"]: "");
                $arrData["ticketStatus"] = (isset($arrInput["ticketStatus"])? $arrInput["ticketStatus"]: "");
                $arrData["user"] = array("userId" => (isset($arrInput["userId"])? $arrInput["userId"]: "1"));
                break;
            case "users":
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
                $arrData["userRole"] = (isset($arrInput["userRole"])? "user": "");
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
                return Redirect::to("/admin/customer/$resource")->with("message", "Service Unavailable / No Data");
            }
            Log::info($response);
        }
        if(isset($arrInput['userPhone'])) {
            if($arrInput["action"] == "add" && $resource == "users") {
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
//        $arrInput = Input::all();
//        $arrData = array();
//        Log::info(print_r($arrInput, true));
//        $id = "";
//        $api_path = "/$resource";
//        if($resource == "tickets") {
//            $id = $arrInput["ticketId"];
//            $arrData["ticketId"] = (isset($arrInput["ticketId"])? $arrInput["ticketId"]: "");
//            $arrData["ticketTitle"] = (isset($arrInput["ticketTitle"])? $arrInput["ticketTitle"]: "");
//            $arrData["ticketDesc"] = (isset($arrInput["ticketDesc"])? $arrInput["ticketDesc"]: "");
//            $arrData["ticketStatus"] = (isset($arrInput["ticketStatus"])? $arrInput["ticketStatus"]: "");
//            $arrData["user"] = array("userId" => (isset($arrInput["userId"])? $arrInput["userId"]: "1"));
//        } else if($resource == "users") {
//            $api_path = "/users";
//            $id = $arrInput["userId"];
//            $arrData["userId"] = (isset($arrInput["userId"])? $arrInput["userId"]: "");
//            $arrData["userFirstName"] = (isset($arrInput["userFirstName"])? $arrInput["userFirstName"]: "");
//            $arrData["userLastName"] = (isset($arrInput["userLastName"])? $arrInput["userLastName"]: "");
//            $arrData["userLogin"] = (isset($arrInput["userLogin"])? $arrInput["userLogin"]: "");
//            $arrData["userEmail"] = (isset($arrInput["userEmail"])? $arrInput["userEmail"]: "");
//            $arrData["userPassword"] = (isset($arrInput["userPassword"])? $arrInput["userPassword"]: "");
//            $arrData["userGender"] = (isset($arrInput["userGender"])? $arrInput["userGender"]: "");
//            $arrData["userBirthDate"] = (isset($arrInput["userBirthDate"])? $arrInput["userBirthDate"]: "");
//            $arrData["userAddress"] = (isset($arrInput["userAddress"])? $arrInput["userAddress"]: "");
//            $arrData["userRole"] = (isset($arrInput["userRole"])? $arrInput["userRole"]: "");
//            $arrData["country"] = array("countryId" => (isset($arrInput["countryId"])? $arrInput["countryId"]: "1"));
//        }
//        
//        $resp = "";
//        if(count($arrData) >0) {
//            if($arrInput["action"] == "add") {
//                $hdr = array("Content-Type: application/json");
//                $resp = $this->httpPOST_API($api_path, json_encode($arrData), $hdr);
//                $arrResp = json_decode($resp, true);
//                $resp = json_encode($arrResp['user']);
//            } else if($arrInput["action"] == "edit") {
//                $api_path = $api_path . "/$id";
//                $hdr = array("Content-Type: application/json");
//                $resp = $this->httpPUT_API($api_path, json_encode($arrData), $hdr);
//            } else if($arrInput["action"] == "delete") {
//                $api_path = $api_path . "/$id";
//                $hdr = array("Content-Type: application/json");
//                $resp = $this->httpDELETE_API($api_path, json_encode($arrData), $hdr);
//            }
//        }
//        if(isset($arrInput['userPhone'])) {
//            $arrResp = json_decode($resp, true);
//            $id = $arrResp['userId'];
//            $arrPhoneData = array("user"=>$arrResp);
//            $arrPhoneData["userPhoneNo"] = $arrInput['userPhone'][0];
//            $arrPhoneData["userPhoneType"] = $arrInput['userPhoneType'][0];
//            $hdr = array("Content-Type: application/json");
//            $phoneId = $arrInput['userPhoneId'][0];
//            if($phoneId === "0") {
//                $resp = $this->httpPOST_API("/users/$id/phones", json_encode($arrPhoneData), $hdr);
//            } else {
//                $arrPhoneData['userPhoneId'] = $phoneId;
//                $resp = $this->httpPUT_API("/users/$id/phones/$phoneId", json_encode($arrPhoneData), $hdr);
//            }
//        }
        return Redirect::to("/admin/customer/$resource");
    }
}
