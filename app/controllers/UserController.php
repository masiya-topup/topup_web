<?php

class UserController extends BaseController {
    public function showProfile() {
        $userLogin = (Session::get("userLogin"));
        $usr = $userLogin->user;
        return View::make('user_profile', array("title"=>"user", "user"=>$usr));
    }
    public function show($resource) {
        $userLogin = (Session::get("userLogin"));
        $usr = (array) $userLogin->user;
        $arrData = array("title"=>$resource, "user"=>$usr);
        if($resource === "topup") {
            $response = $this->httpGET_API("/services");
            $arrServices = array();
            if(isset($response['info']) && $response['info']['http_code']==200) {
                $arrServices = json_decode($response['content'], true);
            } else {
                return Redirect::to("/error")->with("flash_error", "Service Unavailable / No Data");
            }
            
            $id = $usr['userId'];
            $response = $this->httpGET_API("/users/$id/phones");
            $arrPhones = array();
            if(isset($response['info']) && $response['info']['http_code']==200) {
                $arrPhones = json_decode($response['content'], true);
            } else {
                return Redirect::to("/error")->with("flash_error", "Service Unavailable / No Data");
            }
            
            $arrData["services"] = $arrServices['rows'];
            $arrData["phones"] = $arrPhones['rows'];
        } else if($resource === "account") {
            $response = $this->httpGET_API("/countries");
        
            $arrCountries = array();
            if(isset($response['info']) && $response['info']['http_code']==200) {
                $arrCountries = json_decode($response['content'], true);
            } else {
                return Redirect::to("/error")->with("flash_error", "Service Unavailable / No Data");
            }
            $arrData["countries"] = $arrCountries;
            
            $response = $this->httpGET_API("/users/".$userLogin->user->userId."/phones");
        
            $arrPhones = array();
            if(isset($response['info']) && $response['info']['http_code']==200) {
                $arrPhones = json_decode($response['content'], true);
            } else {
                return Redirect::to("/error")->with("flash_error", "Service Unavailable / No Data");
            }
            $arrData["phones"] = $arrPhones['rows'];
        }
        
        return View::make("user_profile_$resource", $arrData);
    }
    
    public function showGuestTopup() {
        $response = $this->httpGET_API("/services");
        $arrServices = array();
        if(isset($response['info']) && $response['info']['http_code']==200) {
            $arrServices = json_decode($response['content'], true);
        } else {
            return Redirect::to("/error")->with("flash_error", "Service Unavailable / No Data");
        }
        return View::make('guest_topup', array("title"=>"guest", "services"=>$arrServices['rows']));
    }
    
    public function showRegistration() {
        $response = $this->httpGET_API("/countries");
        
        $arrCountries = array();
        if(isset($response['info']) && $response['info']['http_code']==200) {
            $arrCountries = json_decode($response['content'], true);
        } else {
            return Redirect::to("/error")->with("flash_error", "Service Unavailable / No Data");
        }
        return View::make('user_registration', array("title"=>"user", "countries"=>$arrCountries));
    }
    
    public function registerUser() {
        $arrInput = Input::all();
        if(!isset($arrInput['userLogin'])
           || !isset($arrInput['userEmail'])
           || !isset($arrInput['userPassword'])
           || !isset($arrInput['userPhone'])) {
           return Redirect::to("/registration")->with("flash_error", "Please fill required data!!!");
        }
        
        $arrUserData = array();
        $api_path = "/users/register";
        $arrUserData["userId"] = (isset($arrInput["userId"])? $arrInput["userId"]: "");
        $arrUserData["userFirstName"] = (isset($arrInput["userFirstName"])? $arrInput["userFirstName"]: "");
        $arrUserData["userLastName"] = (isset($arrInput["userLastName"])? $arrInput["userLastName"]: "");
        $arrUserData["userLogin"] = (isset($arrInput["userLogin"])? $arrInput["userLogin"]: "");
        $arrUserData["userEmail"] = (isset($arrInput["userEmail"])? $arrInput["userEmail"]: "");
        $arrUserData["userPassword"] = (isset($arrInput["userPassword"])? $arrInput["userPassword"]: "");
        $arrUserData["userGender"] = (isset($arrInput["userGender"])? $arrInput["userGender"]: "");
        $arrUserData["userBirthDate"] = (isset($arrInput["userBirthDate"])? $arrInput["userBirthDate"]: "");
        $arrUserData["userAddress"] = (isset($arrInput["userAddress"])? $arrInput["userAddress"]: "");
        $arrUserData["userRole"] = (isset($arrInput["userRole"])? $arrInput["userRole"]: "");
        $arrUserData["country"] = array("countryId" => (isset($arrInput["countryId"])? $arrInput["countryId"]: "1"));
        $arrPhoneData["userPhoneNo"] = $arrInput['userPhone'][0];
        $arrPhoneData["userPhoneType"] = $arrInput['userPhoneType'][0];
        $hdr = array("Content-Type: application/json");
        $arrData = array();
        $arrData["user"] = $arrUserData;
        $arrData["userPhones"] = array();
        $arrData["userPhones"][] = $arrPhoneData;
        $jsonUser = json_encode($arrData);
        Log::info($jsonUser);
        
        $response = $this->httpPOST_API($api_path, $jsonUser, $hdr);
        $objUserLogin = "";
        if(isset($response['info']) && $response['info']['http_code']==200) {
            $objUserLogin = json_decode($response['content'], false);
        } else if(isset($response['info']) && $response['info']['http_code']==400) {
            $error = json_decode($response['content'], false);
            return Redirect::to("/registration")->with("flash_error", $error->message)->with("prevData", $arrUserData);
        } else {
            return Redirect::to("/error")->with("flash_error", "Service Unavailable / No Data");
        }
        
        if(Session::has('userLogin')) {
            Session::forget('authtoken');
            Session::forget('userLogin');Session::flush();
            Session::flush();
        }
        
        Session::put('authtoken', $objUserLogin->userAuthToken);
        Session::put('userLogin', $objUserLogin);
        Log::info(print_r($arrInput, true));
        Log::info(print_r($objUserLogin->user, true));
        
        return Redirect::to('/user/profile')->with('message', 'Welcome !!!');
    }
    
    public function updateUser() {
        
        $userLogin = (Session::get("userLogin"));
        $usr = $userLogin->user;
        
        $arrInput = Input::all();
        $arrData = array();
        $api_path = "/users/".$usr->userId;
        $arrData["userId"] = (isset($arrInput["userId"])? $arrInput["userId"]: "");
        //Log::info(print_r($usr, true));
        
        if($usr->userId != $arrData["userId"]) {
            return Redirect::to('/user/profile/account')->with('message', 'Error !!! Invalid User');
        }
        
        $arrData["userFirstName"] = (isset($arrInput["userFirstName"])? $arrInput["userFirstName"]: "");
        $arrData["userLastName"] = (isset($arrInput["userLastName"])? $arrInput["userLastName"]: "");
        $arrData["userLogin"] = $usr->userLogin;
        $arrData["userEmail"] = (isset($arrInput["userEmail"])? $arrInput["userEmail"]: "");
        
        if(!empty($arrInput["userPasswordOld"])) {
//            if($usr->userPassword !== $arrData["userPasswordOld"]) {
//                return Redirect::to('/user/profile/account')->with('message', 'Error !!! Old Password not matching');
//            }
            $arrData["userPassword"] = (isset($arrInput["userPasswordNew"])? $arrInput["userPasswordNew"]: "");
            $api_path .= "?oldPwd=". (isset($arrInput["userPasswordOld"])? $arrInput["userPasswordOld"]: "");
        }
        
        $arrData["userGender"] = (isset($arrInput["userGender"])? $arrInput["userGender"]: "");
        $arrData["userBirthDate"] = (isset($arrInput["userBirthDate"])? $arrInput["userBirthDate"]: "");
        $arrData["userAddress"] = (isset($arrInput["userAddress"])? $arrInput["userAddress"]: "");
        $arrData["userRole"] = $usr->userRole;
        $arrData["country"] = array("countryId" => (isset($arrInput["countryId"])? $arrInput["countryId"]: "1"));
        $hdr = array("Content-Type: application/json");
        $response = $this->httpPUT_API($api_path, json_encode($arrData), $hdr);
        $objUserLogin = "";
        if(isset($response['info']) && $response['info']['http_code']==200) {
            $objUser = json_decode($response['content'], false);
            $userLogin->user = $objUser;
            Session::put('userLogin', $userLogin);
            
            if(isset($arrInput['userPhone'])) {
                $id = $userLogin->user->userId;
                $arrPhoneData = array("user"=> (array) $userLogin->user);
                for($i=0; $i<count($arrInput['userPhone']); $i++) {
                    $arrPhoneData["userPhoneNo"] = $arrInput['userPhone'][$i];
                    $arrPhoneData["userPhoneType"] = $arrInput['userPhoneType'][$i];
                    $hdr = array("Content-Type: application/json");
                    $phoneId = $arrInput['userPhoneId'][$i];
                    if($phoneId === "0" || $phoneId === "") {
                        $resp = $this->httpPOST_API("/users/$id/phones", json_encode($arrPhoneData), $hdr);
                    } else {
                        $arrPhoneData['userPhoneId'] = $phoneId;
                        $resp = $this->httpPUT_API("/users/$id/phones/$phoneId", json_encode($arrPhoneData), $hdr);
                    }
                }
            }
        } else if(isset($response['info']) && $response['info']['http_code']<500) {
            $objErr = json_decode($response['content']);
            return Redirect::to("/user/profile/account")->with("message", "Error!!! ". $objErr->message);
        } else {
            return Redirect::to("/error")->with("flash_error", "Service Unavailable / No Data");
        }
        
        return Redirect::to('/user/profile/account')->with('message', 'Updated !!!');
    }
}
