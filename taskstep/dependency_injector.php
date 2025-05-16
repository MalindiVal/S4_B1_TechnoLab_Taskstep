<?php

//require_once "Controller/LoginController.php";
require_once "Service/LoginService.php";
require_once "Model/UserDAO.php";

/**
 * Class DependencyInjector
 */
class DependencyInjector {

    /**
     * Méthode static permettant de retourner une instance de login Controller
     * @return LoginController instance de LoginController
     */
    public static function getLoginController(){
        return new LoginController();
    }

    /**
     * Méthode statique permettant de retourner une instance de login Service
     * @return LoginService instance de LoginService
     */
    public static function getLoginService(){
        return new LoginService();
    }
    

    /**
     * Méthode statique permettant de retourner une instance de login Model
     * @return UserDAO instance du UserDao
     */
    public static function getLoginDao(){
        return new UserDAO();
    }
           
}