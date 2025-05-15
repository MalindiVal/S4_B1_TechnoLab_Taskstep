<?php
require_once("./Config/Config.php");
abstract class Database{
    private PDO $pdo;
    public function __construct(){
        try {
            $this->pdo = new PDO(
                Config::get('dsn'),
                Config::get('user'),
                Config::get('pass'),
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        }
        catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
            throw new PDOException("Database connection failed");
        }
        
    }

    /**
     * Execute une requête de type SELECT qui renvoie plusieurs valeurs
     * @param string $req la requête, éventuellement paramétrée
     * @param array $params les paramètres de la requête
     * @return array le tableau avec les valeurs de retour
     */
    public function queryMany(string $req, array $params = []) : array{
        $req = $this->pdo->prepare($req, $params);
        
        // Bind the parameters
        $this->binding($req,$params);
        $tab = array();
        $req->execute();
        while($data = $req->fetch(PDO::FETCH_ASSOC))
        {
            $tab[]=$data;
        }
        return $tab;
    }

    /**
     * Exécute une requête du type SELECT qui renvoie une seule valeur
     * @param string $sql la requête SQL avec des éventuels paramètres
     * @param array $params les paramètres de la requête
     * @return mixed un tableau associatif avec en clés les noms des colonnes et en valeur les valeur de chaque */
    
    public function queryOne(string $sql, array $params = []):array{
        $req = $this->pdo->prepare($sql, $params);
        $this->binding($req,$params);
        $req->execute();
        $data = $req->fetch(PDO::FETCH_ASSOC);

        return $data ? $data : [];
    }

    /**
     * Execute une requête SQL sans valeur de retour
     * @param string $sql la requête (paramétrée)
     * @param array $params les paramètres
     */
    public function execute(string $sql,array $params = []) {
        $req = $this->pdo->prepare($sql, $params);
        $this->binding($req,$params);
        $req->execute();
    }

    private function binding($req,array $params) : void{
        foreach ($params as $key => $value) {
            $req->bindValue($key, $value);
        }
    }
}