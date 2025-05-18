<?php

require_once "LoginService.php";
require_once "SettingService.php";

/**
 * Classe Injecteur Service
 */
class InjectorService{

    /**
     * Méthode statique permettant de retourner une instance de login Service
     * @return LoginService instance de LoginService
     */
    public static function getLoginService(){
        return new LoginService();
    }

    public static function getSettingService(){
        return new SettingService();
    }

}