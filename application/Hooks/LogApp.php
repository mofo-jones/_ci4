<?php

namespace App\Hooks;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Utils
 *
 * @author kodeinside
 */
class LogApp {

    public function __construct() {
        
    }

    public function logApp() {
        log_msg(' <-><-><-><-><-><-><SERVER><-><-><-><-><-><->');
        log_msg(keyParam($_SERVER));
        log_msg(' <-><-><-><-><-><-><REQUEST><-><-><-><-><-><->');
        log_msg(keyParam($_REQUEST));
        log_msg(' <-><-><-><-><-><-><-GET-><-><-><-><-><-><-><-');
        log_msg(keyParam($_GET));
        log_msg(' <-><-><-><-><-><-><-POST-><-><-><-><-><-><-><');
        log_msg(keyParam($_POST));
        log_msg(' <-><-><-><-><-><-><-COOKIE-><-><-><-><-><-><-');
        log_msg(keyParam($_COOKIE));
        log_msg(' <-><-><-><-><-><-><-ENV-><-><-><-><-><-><-><-');
        log_msg(keyParam($_ENV));
        log_msg(' <-><-><-><-><-><-><-FILES-><-><-><-><-><-><->');
//        log_msg(keyParam($_FILES));
        if (!empty($_SESSION)) {
            log_msg(' <-><-><-><-><-><-><-SESSION-><-><-><-><-><-><');
            log_msg(keyParam($_SESSION));
        }
        if (!empty(getallheaders())) {
            log_msg(' <-><-><-><-><-><-><-getallheaders()-><-><-><-><-><-><');
            log_msg(keyParam(getallheaders()));
        }
        
    }

}
