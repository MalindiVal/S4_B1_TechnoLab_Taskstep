<?php

require_once "Model/injectorDAO.php";

/**
 * Classe SettingService
 */
class SettingService{

    private $settingModel;  
    
    /**
     * Constructeur de SettinService
     */
    public function __construct() {
        $this->settingModel = InjectorDAO::getSettingDao();
    }
    
    /**
     * Récupère les settings en fonction de l'utilisateur
     * @param mixed $idUser identifiant de l'utilisateur
     * @return array|Setting l'objet créer 
     */
    public function getSettingByUser($idUser) : Setting {
        return $this->settingModel->getSettingsByUser($idUser);
    }


}