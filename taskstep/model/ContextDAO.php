<?php
require_once("Database.php");
require_once("Context.php");
class ContextDAO extends Database
{
    public function getAll() : array{
        $tab = array();
        $res= $this->queryMany("SELECT id,title FROM contexts ORDER BY title");
        foreach ($res as $s) {
            $context = new Context();
            $context->hydrate($s);
            $tab[]=$context;
        }
        
        return $tab;
        
    }

    public function getById(int $id) : Context{
        $tab = array();
        $res= $this->queryOne("SELECT id,title FROM contexts Where id= :section",[":section" => $id]);
        $context = new Context();
        $context->hydrate($res);
        
        return $context;
    }

    public function Add(Context $context){
        $this->execute("INSERT INTO contexts (title) VALUES (:title)",[":title" => $context->getTitle()]);
    }

    public function Update(Context $context){
        var_dump($context);
        $this->execute("UPDATE contexts SET title= :title WHERE id= :id ",[":title" => $context->getTitle(), ":id" => $context->getId()]);
    }

    public function Delete(int $id){
        $this->execute("DELETE FROM contexts WHERE id= :id",[":id" => $id]);
    }
}