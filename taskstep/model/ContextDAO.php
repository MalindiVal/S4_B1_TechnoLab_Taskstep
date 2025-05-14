<?php
require_once("Database.php");
require_once("Context.php");
class ContextDAO extends Database
{
    /**
     * Récupère la liste des contextes depuis la base de données.
     * @return Context[] Tableau d'objets de type Context.
     */
    public function getAll() : array {
        $tab = array();  
        $res = $this->queryMany("SELECT id, title FROM contexts ORDER BY title");
        
        foreach ($res as $s) {
            $context = new Context(); 
            $context->hydrate($s);    
            $tab[] = $context;   
        }
        
       
        return $tab;
    }

    /**
     * Récupère un contexte spécifique par son id.
     * @param int $id L'identifiant du contexte à récupérer.
     * @return Context L'objet Context associé à l'id.
     */
    public function getById(int $id) : Context {
        $tab = array();  
        
        $res = $this->queryOne("SELECT id, title FROM contexts WHERE id = :section", [":section" => $id]);
        
        $context = new Context();  
        $context->hydrate($res); 
        
       
        return $context;
    }

    /**
     * Ajoute un nouveau contexte à la base de données.
     * @param Context $context L'objet Context à ajouter.
     * @return void
     */
    public function Add(Context $context) {
        $this->execute("INSERT INTO contexts (title) VALUES (:title)", [":title" => $context->getTitle()]);
    }

    /**
     * Met à jour un contexte existant dans la base de données.
     * @param Context $context L'objet Context à mettre à jour.
     * @return void
     */
    public function Update(Context $context) {
        var_dump($context);  
        
        
        $this->execute("UPDATE contexts SET title = :title WHERE id = :id", [
            ":title" => $context->getTitle(), 
            ":id" => $context->getId()
        ]);
    }

    /**
     * Supprime un contexte de la base de données.
     * @param int $id L'identifiant du contexte à supprimer.
     * @return void
     */
    public function Delete(int $id) {
        $this->execute("DELETE FROM contexts WHERE id = :id", [":id" => $id]);
    }
}
