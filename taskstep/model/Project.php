<?php

class Project{
    private int $id;
    private string $title;

    private int $userId;
    
    /**
     * Récupère l'identifiant du projet.
     * @return int L'identifiant du projet
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * Récupère le titre du projet.
     * @return string Le titre du projet
     */
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * le créateur du projet (clé étrangère)
     * @return int
     */
    public function getUserID(): int {
        return $this->userId;
    }
    

    /**
     * Définit le titre du projet.
     * @param string $title Le nouveau titre à attribuer
     */
    public function setTitle(string $title): void {
        $this->title = $title;
    }

    /**
     * Définit l’identifiant du createur
     */
    public function setUserId(int $userId): void {
        $this->$userId = $$userId;
    }

    /**
     * Hydrate l'objet à partir d'un tableau associatif de données.
     * @param array $data Données à injecter dans l'objet
     */
    public function hydrate(array $data) : void{
        if (isset($data["id"])){
            $this->id = intval($data["id"]);
        }

        if (isset($data["title"])){
            $this->title= $data["title"];
        }

        if (isset($data["user_id"])) {
            $this->userId = intval($data["user_id"]);
        }
    }
}