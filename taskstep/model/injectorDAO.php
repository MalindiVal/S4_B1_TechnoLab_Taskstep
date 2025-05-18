<?php

require_once "UserDAO.php";

/**
 * Classe InjectorDAO
 */
class InjectorDAO{

    /**
     * Méthode statique permettant de retourner une instance de login Model
     * @return UserDAO instance du UserDao
     */
    public static function getLoginDao(){
        return new UserDAO();
    }

}