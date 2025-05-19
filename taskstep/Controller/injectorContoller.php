<?php

require_once "LoginController.php";


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

           
}