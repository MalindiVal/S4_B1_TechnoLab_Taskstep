<?php

require_once "LoginController.php";
require_once "SettingController.php";
require_once "UserController.php"; 


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
     * @return SettingController instance de Setting Conroller
     */
    public static function getSettingController(){
        return new SettingController();
    }

    /**
     * Méthode static permettant de retourner une instance de User Controller
     * @return UserController instance de User Conroller
     */
    public static function getUserController(){
        return new UserController();
    }

           
}