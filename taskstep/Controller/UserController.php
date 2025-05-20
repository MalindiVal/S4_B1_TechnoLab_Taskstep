<?php

require_once "Service/injectorService.php";

/**
 * Classe UserController
 */
class UserController {
    private $userService;

    /**
     * Constructeur de UserConstroller
     */
    public function __construct() {
        $this->userService = InjectorService::getUserService();
    }

    /**
     * Récupération du service permettant de récupérer un utilisateur à partir de son id
     * @param mixed $idUser identifiant de l'utilisateur
     * @return User instance d'un utilisateur
     */
    public function getUserById($idUser){
        return $this->userService->getUserById($idUser);
    }

    /**
     * Mise à jour du mots de passe de l'utilisateur
     * @param mixed $user_id identidiant de l'utilisateur
     * @param mixed $secure_password nouveau mots de passe 
     */
    public function updatePassword($user_id,$secure_password){
        $this->userService->updatePassword($user_id,$secure_password);
    }


}