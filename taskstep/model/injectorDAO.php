<?php

require_once "UserDAO.php";
require_once "SettingDAO.php";

/**
 * Classe InjectorDAO
 */
class InjectorDAO{

    /**
     * Méthode statique permettant de retourner une instance de login Model
     * @return UserDAO instance du UserDao
     */
    public static function getUserDao(){
        return new UserDAO();
    }

    /**
     * Méthode statique permettant de retourner une instance de SettingDao
     * @return SettingDAO instance de SettingDao
     */
    public static function getSettingDao(){
        return new SettingDAO();
    }


}