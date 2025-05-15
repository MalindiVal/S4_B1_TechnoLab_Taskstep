<?php

/**
 * Classe LoginService 
 */
class LoginService{

    private $loginModel;
    
    /**
     * Constructeur de loginService
     */
    public function __construct() {
        $this->loginModel = DependencyInjector::getModel('UserDao');
    }

    /**
     * Authentifie un utilisateur en vérifiant son identifiant et son mot de passe
     * @param mixed $identifiant L'identifiant de l'utilisateur (email)
     * @param mixed $password Le mot de passe de l'utilisateur
     * @return User|null L'objet User si l'authentification réussit, sinon null
     */
    public function authenticate($identifiant,$password):?User{

        $user = $this->loginModel->getUser($identifiant);

        if ($user !== null){
            if(password_verify($password,$user->getPassword()))
            {
                $_SESSION["loggedin"] = true;   
                $host  = $_SERVER['HTTP_HOST'];
                $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                $extra = 'index.php';
                session_write_close();
                header("Location: http://$host$uri/$extra");
                exit;  
            }
            else
            {
                $_SESSION["loggedin"] = false;
                $user = null ;
            }
        }        
        return $user;

    }
}