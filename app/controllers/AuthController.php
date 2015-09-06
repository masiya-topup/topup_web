<?php

class AuthController extends BaseController {
    public function login() {
        $inpArray = Input::all();
        $basic_auth = base64_encode($inpArray['username'].":".$inpArray['password']);
    
        $headr = array();
        $headr[] = 'Authorization: Basic '.$basic_auth;
        
        $response = $this->httpPOST_API("/users/login", "", $headr);
        $arrDetails = array();
        if(isset($response['info']) && $response['info']['http_code']==200) {
            $objUserLogin = json_decode($response['content'], false);
            
            Session::put('authtoken', $objUserLogin->userAuthToken);
            Session::put('userLogin', $objUserLogin);
            switch ($objUserLogin->user->userRole) {
                case "admin_all":
                    return Redirect::to('/admin/all')->with('message', 'Login Success');
                    break;
                case "admin_customer":
                    return Redirect::to('/admin/customer')->with('message', 'Login Success');
                    break;
                case "admin_finance":
                    return Redirect::to('/admin/finance')->with('message', 'Login Success');
                    break;
                case "user":
                    return Redirect::to('/user/profile')->with('message', 'Login Success');
                    break;
                default:
                    return Redirect::to('/')->with('message', 'Login Successful but Role undefined');
                    break;
            }
        } else {
            return Redirect::to("/")->with("message", "Login Failed");
        }
    }
    
    public function logout() {
        $resp = $this->httpPOST_API("/users/logout");
        Session::forget('authtoken');
        Session::forget('userLogin');
        Session::flush();
        return Redirect::to('/');
    }
    
    
    public function showForgotPassword() {
        return View::make('forgot_passwd', array("title"=>"guest"));
    }
    
    public function processForgotPwd() {
        $arrInput = Input::all();
        $email = $arrInput['email'];
        $hdr = array("application/x-www-form-urlencoded");
        $response = $this->httpPOST_API("/users/password/reset?email=$email", null, $hdr);
        $data = "";
        if(isset($response['info']) && $response['info']['http_code']==200) {
            $data = $response['content'];
        } else if(isset($response['info']) && $response['info']['http_code']==400) {
            $data = $response['content'];
            return Redirect::to("/forgotpassword")->with("message", "Wrong email");
        } else {
            return Redirect::to("/error")->with("flash_error", "Service Unavailable / No Data");
        }
        return Redirect::to("/")->with("message", "Email sent with link");
    }
    
    public function showPwdChangeForm() {
        $arrInput = Input::all();
        if(!isset($arrInput["token"])) {
            return Redirect::to("/")->with("message", "Invalid link");
        }
        return View::make('change_passwd', array("title"=>"guest", "token"=>$arrInput["token"]));
    }
    
    public function processPwdReset() {
        $arrInput = Input::all();
        $token = $arrInput['token'];
        $newPwd = $arrInput['newPwd'];
        $hdr = array("application/x-www-form-urlencoded");
        $response = $this->httpPUT_API("/users/password/reset?token=$token", "newPwd=$newPwd", $hdr);
        $data = "";
        if(isset($response['info']) && $response['info']['http_code']==200) {
            $data = $response['content'];
        } else if(isset($response['info']) && $response['info']['http_code']==400) {
            $data = $response['content'];
            return Redirect::to("/forgotpassword")->with("message", "Wrong/Expired token");
        } else {
            return Redirect::to("/error")->with("flash_error", "Service Unavailable / No Data");
        }
        return Redirect::to("/")->with("message", "Password changed successfully");
    }
    
}
