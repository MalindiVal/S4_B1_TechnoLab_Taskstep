<?php

require_once "Service/injectorService.php";

/**
 * Classe LoginController
 */
class SettingController {

    private $settingService;

    /**
     * Constructeur de SettingController
     */
    public function __construct() {
        $this->settingService = InjectorService::getSettingService();
    }

    /**
     * Récupère les paramètres de l'utilisateurs
     * @param mixed $userId identifiant de l'utilisateur
     * @return Setting l'objet créé
     */
    public function getSettingByUser($userId){
        return $this->settingService->getSettingByUser($userId);
    }
}