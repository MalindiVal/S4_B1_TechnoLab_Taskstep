<?php
require_once("Database.php");
require_once("Project.php");
class ProjectDAO extends Database
{
    public function getAll() : array{
        $tab = array();
        $res= $this->queryMany("SELECT id,title FROM projects ORDER BY title");
        foreach ($res as $s) {
            $project = new Project();
            $project->hydrate($s);
            $tab[]=$project;
        }
        
        return $tab;
        
    }

    public function Update(Project $project){
        $this->execute("UPDATE projects SET title= :title WHERE id= :id ",[":title" => $project->getTitle(), ":id" => $project->getId()]);
    }

    public function Add(Project $project){
        $this->execute("INSERT INTO projects (title) VALUES (:title)",[":title" => $project->getTitle()]);
    }

    public function getById(int $id) : Project {
        $tab = array();
        $res= $this->queryOne("SELECT id,title FROM projects Where id= :id",[":id" => $id]);
        $project = new Project();
        $project->hydrate($res);
        
        return $project;
    }

    public function Delete(int $id){
        $this->execute("DELETE FROM projects WHERE id= :id",[":id" => $id]);
    }
}