<?php

class AdminFinanceController extends BaseController {
    public function show() {
        $resp = "";
        $resp = View::make("admin_finance", array("title"=>"finance"));
        
        return $resp;
    }
    
}
