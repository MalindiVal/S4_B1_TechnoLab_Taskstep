<?php

require_once "Model/injectorDAO.php";
/**
 * Classe UserService 
 */
class UserService{

    private $userModel;
    
    /**
     * Constructeur de UserService
     */
    public function __construct() {
        $this->userModel = InjectorDAO::getUserDao();
    }

    /**
     * Récupération d'un User à partir de l'id
     * @param mixed $idUser identifiant de l'utilisateur
     * @return User une instance de User
     */
    public function getUserById($idUser){
        return $this->userModel->getUserById($idUser);
    }

    /**
     * Mise à jour du mot de passe de l'utilisateur
     * @param mixed $user_id identidiant de l'utilisateur
     * @param mixed $secure_password nouveau mots de passe 
     */
    public function updatePassword($user_id,$secure_password){
        $this->userModel->updatePasswoordById($user_id,$secure_password);
    }

}