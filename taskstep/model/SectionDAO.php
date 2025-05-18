<?php
require_once("Database.php");
require_once("model/Section.php");
class SectionDAO extends Database
{
    /**
     * Recupère les sections
     * @return Section[] Tableau d'objets Section
     */
    public function getAll() : array{
        $tab = array();
        $res= $this->queryMany("SELECT id,title,fancy_title FROM sections ORDER BY id");
        foreach ($res as $s) {
            $section = new Section();
            $section->hydrate($s);
            $tab[]=$section;
        }
        
        return $tab;
        
    }

    /**
     * Récupèration d'une section en fonction de l'identifiant
     * @param int $id l'identifiant de la section
     * @return Section l'objet Section récupéré
     */
    public function getById(int $id) : Section{

        var_dump($id);
        $res= $this->queryOne("SELECT id,title,fancy_title FROM sections Where id = :id",[":id" => $id]);
        $section = new Section();
        var_dump($res);
        $section->hydrate($res);
        return $section;
        
    }

    /**
     * Récupère les Sections avec le ration taches terminées/Nombres de taches par section
     * @return Section[] tableau d'objets Section
     */
    public function getRatio() : array{
        $tab = array();
        $res= $this->queryMany("SELECT s.id, s.title, SUM(IF(i.done = 1, 1, 0)) AS finished, COUNT(i.id) AS total
			FROM sections s 
			LEFT JOIN items i ON s.id = i.section_id 
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