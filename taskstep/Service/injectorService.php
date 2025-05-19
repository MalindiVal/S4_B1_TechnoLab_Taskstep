<?php

require_once "LoginService.php";
require_once "SettingService.php";
require_once "UserService.php";

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

    /**
     * Méthode statique permettant de retourner une instance de Setting Service
     * @return SettingService instance de Setting Service
     */
    public static function getSettingService(){
        return new SettingService();
    }

    /**
     * Méthode statique permettant de retourner une instance de User Service
     * @return UserService instance de user Service
     */
    public static function getUserService(){
        return new UserService();
    }

}