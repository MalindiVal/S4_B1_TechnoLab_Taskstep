<?php

class Context{
    private int $id;      // Identifiant unique du contexte
    private string $title; // Titre du contexte
    
    /**
     * Récupère l'identifiant du contexte
     * @return int L'identifiant unique du contexte
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * Récupère le titre du contexte
     * @return string Le titre du contexte
     */
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * Définit le titre du contexte
     * @param string $title Le titre du contexte
     * @return void
     */
    public function setTitle(string $title): void {
        $this->title = $title;
    }

    /**
     * Hydrate un objet Context avec les données d'un tableau associatif
     * Cela permet de remplir l'objet avec les données récupérées d'une base de données ou d'une autre source.
     * 
     * @param array $data Le tableau associatif contenant les données à hydrater
     * @return void
     */
    public function hydrate(array $data) : void{
        // Si l'index "id" existe dans le tableau, l'attribuer à la propriété id
        if (isset($data["id"])){
            $this->id = intval($data["id"]);
        }

        // Si l'index "title" existe dans le tableau, l'attribuer à la propriété title
        if (isset($data["title"])){
            $this->title = $data["title"];
        }
    }
}
