<?php

require_once "Service/injectorService.php";

/**
 * Classe LoginController
 */
class LoginController {
    private $loginService;

    /**
     * Constructeur de loginConstroller
     */
    public function __construct() {
        $this->loginService = InjectorService::getLoginService();
    }

    /**
     * Gère la connexion de l'utilisateur
     * @return User|null L'objet User si l'authentification réussit, sinon null
     */ 
    public function connexion() {
        $user = null;

        // Vérifier si le formulaire a été soumis
        if (isset($_POST["submit"])) 
        {
            $identifiant =$_POST["identifiant"];
            $password = $_POST["password"];

            // Vérifier que les champs ne sont pas vides
            if (!empty($identifiant) && !empty($password)){
                $user = $this->loginService->authenticate($identifiant,$password);
            } 
        } else if (isset($_GET["action"])) {
            $_SESSION['loggedin'] = false; 
        }

        return $user;
    }

}   