<?php

require_once "LoginController.php";
require_once "SettingController.php";


/**
 * Class InjectorContoller
 */
class InjectorContoller {

    /**
     * Méthode static permettant de retourner une instance de login Controller
     * @return LoginController instance de LoginController
     */
    public static function getLoginController(){
        return new LoginController();
    }
    
    /**
     * Méthode static permettant de retourner une instance de Setting Controller
     * @return SettingController
     */
    public static function getSettingController(){
        return new SettingController();
    }

           
}