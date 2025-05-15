<?php

//require_once "Controller/LoginController.php";
require_once "Service/LoginService.php";
require_once "Model/UserDAO.php";

/**
 * Class DependencyInjector
 */
class DependencyInjector {

    /**
     * Méthode static permettant de retourner un Controller
     * @param mixed $controllerName nom du controller 
     * @return LoginController contoller à retourner
     */
    public static function getController($controllerName){
        switch($controllerName) {
            case 'LoginContoller' :
                return new LoginController();
            default:
                throw new Exception("Controller not found");
        }
    }

    /**
     * Méthode statique permettant de retourner un Service
     * @param mixed $serviceName instance du service à retourner
     * @throws \Exception si le service n'est pas trouvé
     * @return LoginService le service en question 
     */
    public static function getService($serviceName){
        switch($serviceName) {
            case 'LoginService' :
                return new LoginService();
            default:
                throw new Exception("Service not found");
        }
    }

    /**
     * Méthode statique permettant de retourner un Model
     * @param mixed $daoName nom du modèle (DAO)
     * @throws \Exception si le DAO n'est pas trouvé
     * @return UserDAO instance du modèle à retourner
     */
    public static function getModel($daoName){
        switch($daoName) {
            case 'UserDao' :
                return new UserDAO();
            default:
                throw new Exception("Model not found");
        }
    }
}