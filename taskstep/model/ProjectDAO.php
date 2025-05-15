<?php
require_once("Database.php");
require_once("Project.php");

class ProjectDAO extends Database
{
    /**
     * Récupère tous les projets depuis la base de données.
     * @return array Tableau d'objets Project
     */
    public function getAll() : array {
        $tab = array(); 
        $res = $this->queryMany("SELECT id, title FROM projects ORDER BY title"); 

        foreach ($res as $s) {
            $project = new Project();
            $project->hydrate($s); 
            $tab[] = $project; 
        }

        return $tab; 
    }

    /**
     * Met à jour un projet existant dans la base de données.
     * @param Project $project Le projet à mettre à jour
     */
    public function Update(Project $project) {
        $this->execute(
            "UPDATE projects SET title = :title WHERE id = :id",
            [
                ":title" => $project->getTitle(),
                ":id" => $project->getId()
            ]
        );
    }

    /**
     * Ajoute un nouveau projet à la base de données.
     * @param Project $project Le projet à ajouter
     */
    public function Add(Project $project) {
        $this->execute(
            "INSERT INTO projects (title,user_id) VALUES (:title,:userid)",
            [":title" => $project->getTitle(),
                ":userid" => intval($_SESSION["user_id"])
            ]
        );
    }

    /**
     * Récupère un projet à partir de son identifiant.
     * @param int $id L'identifiant du projet
     * @return Project Le projet correspondant
     */
    public function getById(int $id) : Project {
        $res = $this->queryOne(
            "SELECT id, title FROM projects WHERE id = :id ",
            [":id" => $id]
        );

        $project = new Project();
        $project->hydrate($res); 

        return $project;
    }

    /**
     * Supprime un projet de la base de données à partir de son identifiant.
     * @param int $id L'identifiant du projet à supprimer
     */
    public function Delete(int $id) {
        $this->execute(
            "DELETE FROM projects WHERE id = :id",
            [":id" => $id]
        );
    }
}
