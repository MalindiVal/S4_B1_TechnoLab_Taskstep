<?php
require_once("Database.php");
require_once("model/Section.php");
class SectionDAO extends Database
{
    public function getAll() : array{
        $tab = array();
        $res= $this->queryMany("SELECT id,title,fancytitle FROM sections ORDER BY id");
        foreach ($res as $s) {
            $section = new Section();
            $section->hydrate($s);
            $tab[]=$section;
        }
        
        return $tab;
        
    }
}