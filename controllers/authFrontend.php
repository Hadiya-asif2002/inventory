<?php
namespace Controllers;

class AuthFrontend {
    public static function viewLogin() {
           return include 'views/login.php';
        
    }


    public static function viewLogout() {
           return include 'views/logout.php';

    }


    public static function viewRegister() { 
           return include 'views/register.php';

    }



    public static function viewForgotPassword() { 
           return include 'views/forgot-password.php';
        
    }



    public static function viewSubmitForgotPassword() { 
           return include 'views/submit-forgot-password.php';
        
    }
}