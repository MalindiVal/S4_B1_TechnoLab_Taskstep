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

    public function getById() : Context{
        $tab = array();
        $res= $this->queryOne("SELECT id,title FROM contexts Where id= :section",[":section" => $id]);
        $context = new Context();
        $context->hydrate($res);
        
        return $context;
    }
}