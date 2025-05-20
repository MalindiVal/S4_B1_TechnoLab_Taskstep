<?php
require_once("Database.php");
require_once("User.php");
/**
 * Classe UserDao héritant de Database
 */
class UserDAO extends Database
{
    private $user;

    /**
     * Constructeur de UserDAO
     */
    public function __construct() {
        parent::__construct();
        $this->user = new User();
    }

    /**
     * Récupère un utilisateur à partir de son identifiant (email)
     * @param string $identifiant L'identifiant de l'utilisateur (email)
     * @throws \Exception Exception si un erreur est survenu lors de l'exécution de la requête
     * @return User L'objet User si trouvé, sinon null
     */
    public function getUser(string $identifiant): ?User
    {
        try
        {
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = $this->queryOne($sql, [$identifiant]);
            if($stmt){
                $this->user->hydrate($stmt);
            }   
            else{
                $this->user = null;
            }
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'exécution de la requête: " . $e->getMessage());
        }
        return $this->user;
    }   

    /**
     * Mise à jour du mot de passe ne BDD 
     * @param mixed $user_id identifiant de l'utilisateur
     * @param mixed $secure_password nouveau mot de passe
     * @throws \Exception erreur lors de la mise à jour
     * @return void
     */
    public function updatePasswoordById($user_id,$secure_password){
        try
        {
            $sql ="UPDATE users SET password = ? WHERE id = ?";
            $this->execute($sql,[$secure_password,$user_id]);
        }
        catch(Exception $e){

            throw new Exception("Erreur lors de la mise à jour du mot de passe: " . $e->getMessage());
        }
    }

    /**
     * Récupère un utilisateur à partir de son id
     * @param string $identifiant L'identifiant de l'utilisateur 
     * @throws \Exception Exception si un erreur est survenu lors de l'exécution de la requête
     * @return User L'objet User si trouvé, sinon null
     */
    public function getUserById(string $id): ?User
    {
        try
        {
            $sql = "SELECT * FROM users WHERE id = ?";
            $stmt = $this->queryOne($sql, [$id]);
            if($stmt){
                $this->user->hydrate($stmt);
            }   
            else{
                $this->user = null;
            }
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'exécution de la requête: " . $e->getMessage());
        }
        return $this->user;
    }   

    
}
