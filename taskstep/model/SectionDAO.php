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

    public function getRatio() : array{
        $tab = array();
        $res= $this->queryMany("SELECT s.title, SUM(IF(i.done = 1, 1, 0)) AS finished, COUNT(i.id) AS total
			FROM sections s 
			LEFT JOIN items i ON s.title = i.section 
			GROUP BY s.title 
			ORDER BY s.id"
        );
        foreach ($res as $s) {
            $section = new Section();
            $section->hydrate($s);
            $tab[]=$section;
        }
        
        return $tab;
    }
}