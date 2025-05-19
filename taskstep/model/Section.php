<?php

/**
 * Déclaration de la classe Section, qui représente une section (par exemple d’un cours ou d’un module)
 */
class Section
{

    private int $id;
    private string $title;
    private string $fancytitle;
    private int $total;
    private int $finished;

    private int $userId;

    /**
     * Récupère l'identifiant de la section
     * @return int L'identifiant
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Récupère le titre simple de la section
     * @return string Le titre
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Récupère le titre stylisé de la section
     * @return string Le titre stylisé
     */
    public function getFancyTitle(): string
    {
        return $this->fancytitle;
    }

    /**
     * Récupère le nombre total de tâches/éléments dans la section
     * @return int Le total
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * Récupère le nombre de tâches/éléments terminés dans la section
     * @return int Le nombre terminé
     */
    public function getFinished(): int
    {
        return $this->finished;
    }

    /**
     * Récupère l'identifiant du créateur de la section
     * @return int L'identifiant de l'utilisateur
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * Définit le titre simple de la section
     * @param string $title Le nouveau titre
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Définit le titre stylisé de la section
     * @param string $fancytitle Le nouveau titre stylisé
     */
    public function setFancyTitle(string $fancytitle): void
    {
        $this->fancytitle = $fancytitle;
    }

    /**
     * Définit l’identifiant du createur
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * Remplit les propriétés de l’objet à partir d’un tableau associatif.
     * @param array $data Données d'hydratation
     */
    public function hydrate(array $data): void
    {
        if (isset($data["id"])) {
            $this->id = intval($data["id"]);
        }

        if (isset($data["title"])) {
            $this->title = $data["title"];
        }

        if (isset($data["fancy_title"])) {
            $this->fancytitle = $data["fancy_title"];
        }

        if (isset($data["total"])) {
            $this->total = $data["total"];
        }

        if (isset($data["finished"])) {
            $this->finished = $data["finished"];
        }

        if (isset($data["user_id"])) {
            $this->userId = intval($data["user_id"]);
        }
    }
}
