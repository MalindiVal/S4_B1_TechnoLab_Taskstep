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

    public function getById() : Project {
        $tab = array();
        $res= $this->queryOne("SELECT id,title FROM projects Where id= :id",[":id" => $id]);
        $project = new Project();
        $project->hydrate($res);
        
        return $project;
    }
}