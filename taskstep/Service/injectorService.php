<?php

require_once "LoginService.php";

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

}